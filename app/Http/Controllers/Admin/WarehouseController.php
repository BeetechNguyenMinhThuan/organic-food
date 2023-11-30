<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\ProductService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class WarehouseController extends Controller
{
    private ProductService $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = $this->productService->get();
        return view('backend.warehouse.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
        $product = $this->productService->findItem('id', $id);
        return view('backend.warehouse.edit', compact('product'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $product = $this->productService->findItem('id', $id);
        $product->name = $request->name;
        $product->stock = $request->stock;
        $product->save();
        return redirect()->route('admin.warehouse.index')->with(['status_succeed' => trans('messages.create_succeed')]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function exportToCSV()
    {
        $products = $this->productService->get();
        if ($products->isEmpty()) {
            return redirect()->back()->with(['status_failed' => trans('messages.server_error')]);
        }

        $csvFileName = 'products.csv';
        $csvHeader = [
            'Tên sản phẩm',
            'Thương hiệu',
            'Số lượng'
        ];

        $csvData = [];
        $csvData[] = implode(',', $csvHeader);

        foreach ($products as $product) {
            $rowData = [
                $product->name,
                $product->brand->name ?? "",
                $product->stock
            ];
            $csvData[] = implode(',', $rowData);
        }

        $content = implode("\n", $csvData);

        // Lưu file CSV với encoding UTF-8
        Storage::put($csvFileName, "\xEF\xBB\xBF" . $content); // Thêm BOM để đảm bảo encoding UTF-8

        $csvFilePath = Storage::path($csvFileName);
        return response()->download($csvFilePath)->deleteFileAfterSend(true);
    }
}
