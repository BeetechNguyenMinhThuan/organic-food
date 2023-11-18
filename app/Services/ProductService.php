<?php

namespace App\Services;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductTag;
use App\Models\Tag;
use App\Models\UserFavorite;
use App\Services\Admin\BinaryFileResponse;
use App\Services\Admin\Builder;
use App\Services\Admin\Carbon;
use App\Services\Admin\Collection;
use App\Services\Admin\Excel;
use App\Services\Admin\ImageService;
use App\Services\Admin\Model;
use App\Services\Admin\Pdf;
use App\Services\Admin\ProductAttributesModel;
use App\Services\Admin\ProductExport;
use App\Services\Admin\ProductInformationModel;
use App\Services\Admin\ProductsModel;
use App\Services\Admin\UpdateProductRequest;
use App\Traits\StorageImageTrait;
use Illuminate\Http\Client\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class ProductService
{
    use StorageImageTrait;

    const PRODUCT_PAGINATE = 15;
    private Product $product;
    private ProductImage $productImage;
    private Tag $tag;
    private ProductTag $productTag;
    private UserFavorite $userFavorite;
    private Category $category;


    public function __construct(Category $category, Product $product, ProductImage $productImage, Tag $tag, ProductTag $productTag, UserFavorite $userFavorite)
    {
        $this->product = $product;
        $this->productImage = $productImage;
        $this->tag = $tag;
        $this->productTag = $productTag;
        $this->userFavorite = $userFavorite;
        $this->category = $category;
    }

    public function getModel()
    {
        return $this->product;
    }

    public function search(Request $request)
    {
        $keyword = $request->get('keyword');
        if ($request->sort_price == 1) {
            $sort = ['product_attributes.promotional_price', 'desc'];
        } else if ($request->sort_price == 2) {
            $sort = ['product_attributes.promotional_price', 'asc'];
        } else {
            $sort = ['product_attributes.created_at', 'desc'];
        }
        $product = ProductsModel::join('product_attributes', 'products.id', '=', 'product_attributes.product_id')
            ->orderBy($sort[0], $sort[1])
            ->select('products.*', DB::raw('MAX(product_attributes.promotional_price) as max_promotional_price'))
            ->where('products.name', 'like', '%' . $keyword . '%')
            ->groupBy('product_attributes.product_id', 'product_attributes.created_at', 'product_attributes.promotional_price')
            ->orderBy('max_promotional_price', 'desc')
            ->paginate(20);
        foreach ($product as $item) {
            $item->infor = ProductInformationModel::find($item->product_infor_id);
            $item->type_product = ProductsModel::where('product_infor_id', $item->product_infor_id)->get();
            $item->price = ProductAttributesModel::where('product_id', $item->id)->first()->price;
            $this->flashSale($item);
            $this->starReview($item);
        }
        return view('web.product.search', compact('product', 'keyword'));
    }

    /**
     * Display a listing of Products
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function get()
    {
        $query = $this->product::query()
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
    public function getRandom()
    {
        $query = $this->product::query()
            ->inRandomOrder()
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

    private function prepairData($request)
    {
        $params = $request->only([
            'name',
            'slug',
            'parent_id',
            'thumbnail',
            'status',
            'description'
        ]);
        if (!isset($request->parent_id)) {
            $params['parent_id'] = 0;
        }
        $params['slug'] = Str::slug($request->name);
        return $params;
    }

    public function calculatePriceDiscount($price, $percent)
    {
        return $price - ($price * ($percent / 100));
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
            'slug' => Str::slug($request->name),
            'stock' => $request->stock,
            'expired_at' => $request->expired_at,
            'category_id' => $request->category_id,
            'description' => $request->description,
            'price' => $request->price,
            'user_id' => auth()->id(),
            'discount' => $request->discount,
            'weight' => $request->weight,
            'sale_status' => $request->sale_status,
            'status' => $request->status
        ];
        // Store avatar image
        if ($request->hasFile('avatar')) {
            $avatar = $request->avatar;
            $data['avatar'] = $this->uploadFile($avatar, PRODUCT_DIR . '/' . auth()->id() . '/' . Str::random(30) . "." . $avatar->getClientOriginalExtension());
        }

        $product = $this->product->query()->create($data);

        // Sale Price
        if ($product->discount) {
            $product->sale_price = $this->calculatePriceDiscount($product->price, $product->discount);
            $product->save();
        }

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
    public function findItem($column, $value)
    {
        return $this->product::query()->with(['category', 'tags', 'images', 'brand'])->where($column, $value)->firstOrFail();
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
            'slug' => Str::slug($request->name),
            'stock' => $request->stock,
            'expired_at' => $request->expired_at,
            'category_id' => $request->category_id,
            'description' => $request->description,
            'price' => $request->price,
            'discount' => $request->discount,
            'weight' => $request->weight,
            'user_id' => auth()->id(),
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

        // Sale Price
        if ($product->discount) {
            $product->sale_price = $this->calculatePriceDiscount($product->price, $product->discount);
            $product->save();
        }


        // --- 2.Remove old file avatar ---
        if ($old_avatar_path) {
            // Remove old file
            $this->deleteFile($old_avatar_path);
        }

        // Insert data to images table
        if ($request->hasFile('image_path')) {
            $old_image_detail_path = $this->productImage->where('product_id', $id)->get()->pluck('image_id')->toArray();

            // Remove old file image detail
            $this->productImage->where('product_id', $id)->delete();

            $imagePath = $request->image_path;
            foreach ($imagePath as $index => $image) {
                $dataProductImageDetail = $this->uploadFile($image, PRODUCT_DIR . '/' . auth()->id() . '/' . Str::random(30) . "." . $image->getClientOriginalExtension());

                // Insert data to product_images table
                $product->images()->create([
                    'name' => $image->getClientOriginalName(),
                    'image_path' => $dataProductImageDetail,
                    'size' => $image->getSize() / 1024,   // KB
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
            $this->findItem('id', $id)->delete();
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Message: {$e->getMessage()}. Line: {$e->getLine()}");
            return false;
        }
    }

    public function getProductRelated($id, $categoryId)
    {
        return $this->product->query()->where('category_id', $categoryId)->where('id', '!=', $id)->get();
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

    public function getProductFavorite()
    {
        $user = Auth::user();
        return $user->favorites;
    }

    public function createFavoriteProduct($productId)
    {
        DB::beginTransaction();
        try {
            $productFavorite = $this->userFavorite::query()->create([
                'user_id' => Auth::user()->id,
                'product_id' => $productId
            ]);
            DB::commit();
            return response()->json([
                'status' => 200,
                'data' => $productFavorite
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Message: {$e->getMessage()}. Line: {$e->getLine()}");
            return response()->json([
                'status' => 500,
                'data' => []
            ], 500);
        }
    }

    public function removeFavoriteProduct($productId)
    {
        DB::beginTransaction();
        try {
            $user = Auth::user();
            $this->userFavorite::query()->where([
                'product_id' => $productId,
                'user_id' => $user->id
            ])->delete();
            DB::commit();
            return response()->json([
                'status' => 200,
                'data' => true
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Message: {$e->getMessage()}. Line: {$e->getLine()}");
            return response()->json([
                'status' => 500,
                'data' => trans('messages.server_error')
            ], 500);
        }
    }

    public function checkFavoriteProduct($productId)
    {
        try {
            if(!Auth::check()){
                return response()->json([
                    'status' => Response::HTTP_NOT_FOUND,
                ]);
            }
            $favoriteProduct = $this->userFavorite::query()->where([
                'user_id' => Auth::user()->id,
                'product_id' => $productId
            ])->first();
            if ($favoriteProduct) {
                return response()->json([
                    'status' => 200,
                    'data' => true
                ]);
            }
            return response()->json([
                'status' => 200,
                'data' => false
            ]);


        } catch (\Exception $e) {
            Log::error("Message: {$e->getMessage()}. Line: {$e->getLine()}");
            return response()->json([
                'status' => 500,
                'data' => trans('messages.server_error')
            ], 500);
        }
    }

    public function filterProductCategory($request, $categoryId)
    {
        try {
            $tagsId = $request->tagsId ?? [];
            $brandsId = $request->brandsId ?? [];
            $orderPrice = $request->orderPrice;
            $categoryBySlug = $this->category->where('id', $categoryId)->firstOrFail();
            $products = $this->product::query()->where('category_id', $categoryId);
            if (!empty($tagsId)) {
                $products->whereHas('tags', function ($query) use ($tagsId) {
                    $query->whereIn('tag_id', $tagsId);
                });
            }
            if (!empty($brandsId)) {
                $products->whereIn('brand_id', $brandsId);
            }

            if (!empty($orderPrice)) {
                if ($orderPrice == Product::ORDER_PRICE_LOW_TO_HIGH) {
                    $products->orderBy('price');
                } else {
                    $products->orderBy('price', 'DESC');
                }
            }

            $products = $products->paginate(self::PRODUCT_PAGINATE);
            if ($products->isEmpty()) {
                return response()->json([
                    'status' => Response::HTTP_NOT_FOUND,
                ]);
            }
            $productsHtml = view('frontend.products.components.list-product-filter', compact('products', 'categoryBySlug'))->render();
            return response()->json([
                'status' => 200,
                'data' => $products,
                'html' => $productsHtml
            ]);

        } catch (\Exception $e) {
            Log::error("Message: {$e->getMessage()}. Line: {$e->getLine()}");
            return response()->json([
                'status' => 500,
                'data' => trans('messages.server_error')
            ], 500);
        }

    }
}
