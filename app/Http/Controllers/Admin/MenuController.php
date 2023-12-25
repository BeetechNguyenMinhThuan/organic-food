<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Services\MenuService;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    private $menuService;

    public function __construct(MenuService $menuService)
    {
        $this->menuService = $menuService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Handle recursive menus
        $htmlOption = $this->menuService->getMenu();

        // Get full menu
        $menus = $this->menuService->getPaginate();
        return view('backend.menus.index', [
            'htmlOption' => $htmlOption,
            'menus' => $menus
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
        $menuInsert = $this->menuService->insert($request);
        if ($menuInsert) {
            return redirect()->route('admin.menus.index')->with([
                'status_succeed' => trans('messages.create_menu_succeed')
            ]);
        }
        return redirect()->route('admin.menus.index')->with([
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
        $menuInsert = $this->menuService->update($request,$id);
        if ($menuInsert) {
            return redirect()->route('admin.menus.index')->with([
                'status_succeed' => trans('messages.create_menu_succeed')
            ]);
        }
        return redirect()->route('admin.menus.index')->with([
            'status_failed' => trans('messages.server_error')
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $menuDelete = $this->menuService->delete($id);
        if ($menuDelete) {
            return response()->json(['status' => 200, 'message' => "Success"]);
        }
        return response()->json(['status' => 500, 'message' => "Fail"], 500);
    }
}
