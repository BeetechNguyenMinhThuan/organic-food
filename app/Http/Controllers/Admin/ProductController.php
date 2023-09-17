<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Services\Admin\CategoryService;
use App\Services\Admin\ProductService;
use App\Traits\StorageImageTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    private $categoryService;
    private $productService;
    public function __construct(ProductService $productService, CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
        $this->productService = $productService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        return view('backend.products.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $htmlOption = $this->categoryService->getCategory();
        return view('backend.products.create', [
            'htmlOption' => $htmlOption
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
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

            $this->productService->createProduct($data,$request->avatar);
            DB::commit();
            return redirect()->route('admin.products.create')->with([
                'status_succeed' => trans('messages.create_succeed')
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("File: " . $e->getFile() . '---Line: ' . $e->getLine() . "---Message: " . $e->getMessage());
            return redirect()->route('admin.products.create')->with([
                'status_failed' => trans('messages.server_error')
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
