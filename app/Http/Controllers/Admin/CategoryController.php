<?php

namespace App\Http\Controllers\Admin;

use App\Components\Recursive;
use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use App\Services\Admin\CategoryService;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    private $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Handle recursive categories
        $htmlOption = $this->categoryService->getCategory();

        // Get full category
        $categories = $this->categoryService->getPaginate();
        return view('backend.categories.index', [
            'htmlOption' => $htmlOption,
            'categories' => $categories
        ]);

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CategoryRequest $request)
    {
        $categoryInsert = $this->categoryService->insert($request);
        if ($categoryInsert) {
            return redirect()->route('admin.categories.index')->with([
                'status_succeed' => trans('messages.create_category_succeed')
            ]);
        }
        return redirect()->route('admin.categories.index')->with([
            'status_failed' => trans('messages.server_error')
        ]);
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
        $categoryDelete = $this->categoryService->delete($id);
        if ($categoryDelete) {
            return response()->json(['status' => 200, 'message' => "Success"]);
        }
        return response()->json(['status' => 500, 'message' => "Fail"], 500);
    }
}
