<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Services\CategoryService;
use App\Services\ProductService;
use App\Services\TagService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ProductController extends Controller
{
    private CategoryService $categoryService;
    private ProductService $productService;
    private TagService $tagService;

    public function __construct(ProductService $productService, CategoryService $categoryService, TagService $tagService)
    {
        $this->categoryService = $categoryService;
        $this->productService = $productService;
        $this->tagService = $tagService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = $this->productService->get();
        return view('backend.products.index', [
            'products' => $products
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $htmlOption = $this->categoryService->getCategory();
        $tags = $this->tagService->getTags();
        return view('backend.products.create', [
            'htmlOption' => $htmlOption,
            'tags' => $tags
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductRequest $request)
    {
        DB::beginTransaction();
        try {
            $this->productService->createProduct($request);
            DB::commit();
            return redirect()->route('admin.products.create')->with([
                'status_succeed' => trans('messages.create_product_succeed')
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
        $tags = $this->tagService->getTags();
        $product = $this->productService->findItem('id',$id);
        $htmlOption = $this->categoryService->getCategory($product->category_id);
        return view('backend.products.edit', [
            'htmlOption' => $htmlOption,
            'tags' => $tags,
            'product' => $product
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductRequest $request, string $id)
    {
        DB::beginTransaction();
        try {
            $this->productService->updateProduct($request, $id);
            DB::commit();
            return redirect()->route('admin.products.index')->with([
                'status_succeed' => trans('messages.edit_product_succeed')
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("File: " . $e->getFile() . '---Line: ' . $e->getLine() . "---Message: " . $e->getMessage());
            return redirect()->route('admin.products.index')->with([
                'status_failed' => trans('messages.server_error')
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $productDelete = $this->productService->delete($id);
        if ($productDelete) {
            return response()->json(['status' => 200, 'message' => "Success"]);
        }
        return response()->json(['status' => 500, 'message' => "Fail"], 500);
    }


}
