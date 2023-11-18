<?php

namespace App\Services;

use App\Components\Recursive;
use App\Http\Requests\CategoryRequest;
use App\Models\Menu;
use App\Services\Admin\Builder;
use App\Services\Admin\Collection;
use App\Services\Admin\LengthAwarePaginator;
use App\Services\Admin\Model;
use App\Services\Admin\UpdateCategoryRequest;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class MenuService
{
    private Menu $menu;

    public function __construct(Menu $menu)
    {
        $this->menu = $menu;
    }

    const PAGINATE_CATEGORY = '15';

    /**
     * Display a listing of Products
     *
     * @return Builder[]|Collection
     */
    public function get()
    {
        return $this->menu->query()
            ->with(['parent', 'children'])
            ->select(['id', 'name', 'parent_id', 'slug', 'sort_key'])
            ->get();
    }

    public function getParent()
    {
        return $this->menu->query()
            ->where('parent_id',0)
            ->with(['children'])
            ->get();
    }

    public function getMenu($parentId = "")
    {
        $data = $this->get();
        $recursive = new Recursive($data);
        return $recursive->categoryRecursive($parentId);
    }

    /**
     * Display a listing of Products
     *
     * @return LengthAwarePaginator
     */
    public function getPaginate()
    {
        return $this->menu->query()
            ->latest()
            ->with(['parent', 'children'])
            ->paginate(self::PAGINATE_CATEGORY);
    }

    /**
     * Insert Product
     * @param CategoryRequest $request
     * @return bool
     */
    public function insert($request)
    {
        DB::beginTransaction();
        try {
            $menuCreate = [
                'name' => $request->name,
                'slug' => Str::slug($request->name),
                'parent_id' => $request->parent_id
            ];
            $this->menu->query()->create($menuCreate);
            DB::commit();
            return true;
        } catch (Exception $e) {
            DB::rollBack();
            Log::error("Message: {$e->getMessage()}. Line: {$e->getLine()}");
            return false;
        }
    }

    /**
     * Get Category via ID
     * @param int $id
     * @return Builder|Builder[]|Collection|Model
     */
    public function findItem($id)
    {
        return $this->menu->query()->findOrFail($id);
    }

    /**
     * Update Category
     * @param int $id ,
     * @param UpdateCategoryRequest $request
     * @return bool
     */
    public function update($request, $id)
    {
        DB::beginTransaction();
        try {
            $menuUpdate = [
                'name' => $request->name,
                'slug' => Str::slug($request->name),
                'parent_id' => $request->parent_id
            ];
            $menu = $this->findItem($id);
            $menu->update($menuUpdate);
            DB::commit();
            return true;
        } catch (Exception $e) {
            DB::rollBack();
            Log::error("Message: {$e->getMessage()}. Line: {$e->getLine()}");
            return false;
        }
    }

    /**
     * Delete Category
     * @param int $id
     * @return bool
     */
    public function delete($id)
    {
        DB::beginTransaction();
        try {
            $menu = $this->menu->query()->findOrFail($id);
            if ($menu->children->count() > 0) {
                $categoriesChildren = $menu->children->pluck('id')->toArray();
                $this->menu->query()->whereIn('id', $categoriesChildren)->delete();
            }
            $menu->delete();
            DB::commit();
            return true;
        } catch (Exception $e) {
            DB::rollBack();
            Log::error("Message: {$e->getMessage()}. Line: {$e->getLine()}");
            return false;
        }
    }
}
