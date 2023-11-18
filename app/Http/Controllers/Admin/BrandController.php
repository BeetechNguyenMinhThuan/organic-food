<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SliderRequest;
use App\Services\BrandService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class BrandController extends Controller
{
    private $brandService;

    public function __construct(BrandService $brandService)
    {
        $this->brandService = $brandService;
    }


    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $brands = $this->brandService->getPaginate();
        return view('backend.brands.index', [
            'brands' => $brands
        ]);
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
    public function store(SliderRequest $request)
    {
        DB::beginTransaction();
        try {
            $this->brandService->insertBrand($request);
            DB::commit();
            return redirect()->route('admin.brands.index')->with([
                'status_succeed' => trans('messages.create_category_succeed')
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Message: {$e->getMessage()}. Line: {$e->getLine()}");
            return redirect()->route('admin.brands.index')->with([
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
        $sliderDelete = $this->brandService->delete($id);
        if ($sliderDelete) {
            return response()->json(['status' => 200, 'message' => "Success"]);
        }
        return response()->json(['status' => 500, 'message' => "Fail"], 500);
    }
}
