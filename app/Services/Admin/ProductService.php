<?php

namespace App\Services\Admin;

use App\Models\Image;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductTag;
use App\Models\Tag;
use App\Traits\StorageImageTrait;
use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Nette\FileNotFoundException;

class ProductService
{
    use StorageImageTrait;

    const PRODUCT_PAGINATE = 15;
    private Product $product;
    private ProductImage $productImage;
    private Image $image;
    private Tag $tag;
    private ProductTag $productTag;


    public function __construct(Product $product, Image $image, ProductImage $productImage, Tag $tag, ProductTag $productTag)
    {
        $this->product = $product;
        $this->productImage = $productImage;
        $this->image = $image;
        $this->tag = $tag;
        $this->productTag = $productTag;
    }

    /**
     * Display a listing of Products
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function get()
    {
        $query = Product::query()
            ->latest()
            ->with(['category', 'tags', 'images']);

//        if ($searchByStock = request('filter_stock')) {
//            $this->filterByStock($searchByStock, $query, [10, 100, 200]);
//        }
//
//        $search = request('search');
//        $query->when($search, function ($query1) use ($search) {
//            $query1->whereHas('category', function ($query2) use ($search) {
//                $query2
//                    ->Where('product_categories.name', 'LIKE', "%{$search}%")
//                    ->orWhere('products.name', 'LIKE', "%{$search}%");
//            });
//        });


        return $query->paginate(self::PRODUCT_PAGINATE);
    }

    /**
     * Display a listing of Products To Array
     * @return array
     */
    public function getToArray($isArray = false)
    {
        $query = Product::query()
            ->join('product_categories', 'products.category_id', '=', 'product_categories.id')
            ->select(['products.id', 'products.name AS NameProduct', 'products.stock', 'product_categories.name', 'products.expired_at'])
            ->orderBy('products.id', 'DESC')
            ->get();
        if ($isArray) {
            $query->toArray();
            return $query;
        }
        return $query;
    }

    /**
     * Insert Product
     * @param ImageService $imageService
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model
     */
    public function createProduct($request)
    {
        $data = [
            'sku' => $request->sku,
            'name' => $request->name,
            'stock' => $request->stock,
            'expired_at' => $request->expired_at,
            'category_id' => $request->category_id,
            'description' => $request->description,
            'price' => $request->price,
            'user_id' => auth()->id(),
            'sale_price' => $request->sale_price,
            'sale_status' => $request->sale_status,
            'status' => $request->status
        ];
        // Store avatar image
        if ($request->hasFile('avatar')) {
            $avatar = $request->avatar;
            $data['avatar'] = $this->uploadFile($avatar, PRODUCT_DIR . '/' . auth()->id() . '/' . Str::random(30) . "." . $avatar->getClientOriginalExtension());
        }

        $product = $this->product->query()->create($data);

        // Insert data to images table
        if ($request->hasFile('image_path')) {
            $imagePath = $request->image_path;
            foreach ($imagePath as $index => $image) {
                $dataProductImageDetail = $this->uploadFile($image, PRODUCT_DIR . '/' . auth()->id() . '/' . Str::random(30) . "." . $image->getClientOriginalExtension());
                $imageCreated = $this->image->create([
                    'name' => $image->getClientOriginalName(),
                    'image_path' => $dataProductImageDetail,
                    'size' => $image->getSize() / 1024   // KB
                ]);

                // Insert data to product_images table
                $product->images()->create([
                    'image_id' => $imageCreated->id,
                    'sort_order' => $index + 1
                ]);
            }
        }

        // Insert data to tags table
        $tags = $request->tags;
        if (!empty($tags)) {
            foreach ($tags as $tag) {
                $idTags[] = $this->tag->firstOrCreate(['name' => $tag])->id;
            }
            $product->tags()->attach($idTags);
        }


        // Insert to tags table
        return $product;
    }

    /**
     * Get Product via ID
     * @param int $id
     * @return Builder|Builder[]|Collection|Model
     */
    public function findItem($id)
    {
        return Product::query()->with(['category', 'tags', 'images'])->findOrFail($id);
    }

    /**
     * Update Product
     * @param int $id ,
     * @param UpdateProductRequest $request
     * @param ImageService $imageService
     * @return bool
     */
    public function updateProduct($request, $id)
    {
        //--- 1. Update user ---
        $product = $this->product->findOrFail($id);
        $data = [
            'sku' => $request->sku,
            'name' => $request->name,
            'stock' => $request->stock,
            'expired_at' => $request->expired_at,
            'category_id' => $request->category_id,
            'description' => $request->description,
            'price' => $request->price,
            'user_id' => auth()->id(),
            'sale_price' => $request->sale_price,
            'sale_status' => $request->sale_status,
            'status' => $request->status
        ];

        $old_avatar_path = null;
        if ($request->hasFile('avatar')) {
            $old_avatar_path = $product->avatar;
            $avatar = $request->avatar;
            $data['avatar'] = $this->uploadFile($avatar, PRODUCT_DIR . '/' . auth()->id() . '/' . Str::random(30) . "." . $avatar->getClientOriginalExtension());
        }

        $product->update($data);

        // --- 2.Remove old file avatar ---
        if ($old_avatar_path) {
            // Remove old file
            $this->deleteFile($old_avatar_path);
        }

        // Insert data to images table
        if ($request->hasFile('image_path')) {
            $old_image_detail_path = $this->productImage->where('product_id', $id)->get()->pluck('image_id')->toArray();

            // Remove old file image detail
            $this->image->whereIn('image_path', $old_image_detail_path)->delete();
            $this->productImage->where('product_id', $id)->delete();

            $imagePath = $request->image_path;
            foreach ($imagePath as $index => $image) {
                $dataProductImageDetail = $this->uploadFile($image, PRODUCT_DIR . '/' . auth()->id() . '/' . Str::random(30) . "." . $image->getClientOriginalExtension());

                // Insert data to images table
                $imageCreated = $this->image->create([
                    'name' => $image->getClientOriginalName(),
                    'image_path' => $dataProductImageDetail,
                    'size' => $image->getSize() / 1024   // KB
                ]);

                // Insert data to product_images table
                $product->images()->create([
                    'image_id' => $imageCreated->id,
                    'sort_order' => $index + 1
                ]);
            }
        }

        // Insert data to tags table
        $tags = $request->tags;
        if (!empty($tags)) {
            foreach ($tags as $tag) {
                $idTags[] = $this->tag->firstOrCreate(['name' => $tag])->id;
            }
            $product->tags()->sync($idTags);
        }
    }

    /**
     * Delete Product
     * @param int $id
     * @return bool
     */
    public function delete($id)
    {
        DB::beginTransaction();
        try {
            $this->findItem($id)->delete();
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Message: {$e->getMessage()}. Line: {$e->getLine()}");
            return false;
        }
    }

    /**
     * Export Product CSV
     * @return BinaryFileResponse
     */
    public function exportCSV()
    {
        return Excel::download(new ProductExport($this), 'products-csv.csv');
    }

    /**
     * Export Product PDF
     * @return Response
     */
    public function exportPDF()
    {
        $products = collect($this->getToArray());
        $mytime = Carbon::now()->isoFormat('DD/MM/YYYY');
        $pdf = Pdf::loadView('pdf.product.products', [
            'products' => $products,
            'title' => "Products List",
            'mytime' => $mytime
        ]);
        return $pdf->download('products.pdf');
    }

    /**
     * Filter stock
     * @param string $searchValue
     * @param string $query
     * @param array $range
     * @return void
     */
    private function filterByStock($searchValue, $query, $range)
    {
        if ($searchValue == 1) {
            $query->where('stock', '<', $range[0]);
        } else if ($searchValue == 2) {
            $query->WhereBetween('stock', [$range[0], $range[1]]);
        } else if ($searchValue == 3) {
            $query->WhereBetween('stock', [$range[1], $range[2]]);
        } else {
            $query->where('stock', '>', $range[2]);
        }
    }
}
