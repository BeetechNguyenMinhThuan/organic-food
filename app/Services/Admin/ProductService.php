<?php

namespace App\Services\Admin;

use App\Models\Product;
use App\Traits\StorageImageTrait;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class ProductService
{
    use StorageImageTrait;

    private Product $product;
    public function __construct(Product $product)
    {
        $this->product = $product;
    }

    /**
     * Display a listing of Products
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function get()
    {
        $query = Product::query()
            ->select(['id', 'name', 'stock', 'avatar', 'category_id', 'sku', 'expired_at', 'price'])
            ->latest()
            ->with('category');

        if ($searchByStock = request('filter_stock')) {
            $this->filterByStock($searchByStock, $query, [10, 100, 200]);
        }

        $search = request('search');
        $query->when($search, function ($query1) use ($search) {
            $query1->whereHas('category', function ($query2) use ($search) {
                $query2
                    ->Where('product_categories.name', 'LIKE', "%{$search}%")
                    ->orWhere('products.name', 'LIKE', "%{$search}%");
            });
        });


        return $query->paginate(15);
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
     * @param StoreProductRequest $request
     * @param ImageService $imageService
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model
     */
    public function createProduct($data,$avatar = null)
    {
        // Store avatar image
        if ($avatar) {
            $data['avatar'] = $this->uploadFile($avatar, PRODUCT_DIR . '/' . auth()->id() . '/' . Str::random(30) . "." . $avatar->getClientOriginalExtension());
        }
        return $this->product->query()->create($data);
    }

    /**
     * Get Product via ID
     * @param int $id
     * @return Builder|Builder[]|Collection|Model
     */
    public function findItem($id)
    {
        return Product::query()->findOrFail($id);
    }

    /**
     * Update Product
     * @param int $id ,
     * @param UpdateProductRequest $request
     * @param ImageService $imageService
     * @return bool
     */
    public function update($request, $id, $imageService)
    {
        DB::beginTransaction();
        try {
            $product = $this->findItem($id);
            $productUpdate = [
                'sku' => $request->sku,
                'name' => $request->name,
                'stock' => $request->stock,
                'expired_at' => $request->expired_at,
                'category_id' => $request->category_id,
                'price' => $request->price,
            ];
            $dataFileImage = $imageService->uploadImage($request, "avatar", "upload/product");
            if (!empty($dataFileImage)) {
                $productUpdate['avatar'] = $dataFileImage['file_name_hash'];
                if (file_exists($product->avatar)) {
                    unlink($product->avatar);
                }
            }

            $product->update($productUpdate);
            DB::commit();
            return true;
        } catch (Exception $e) {
            DB::rollBack();
            Log::error("Message: {$e->getMessage()}. Line: {$e->getLine()}");
            return false;
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
        } catch (Exception $e) {
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
