<?php

namespace App\Services;

use App\Components\Recursive;
use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use App\Services\Admin\Builder;
use App\Services\Admin\Collection;
use App\Services\Admin\LengthAwarePaginator;
use App\Services\Admin\UpdateCategoryRequest;
use App\Traits\StorageImageTrait;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class CategoryService
{
    use StorageImageTrait;
    private Category $category;

    public function __construct(Category $category)
    {
        $this->category = $category;
    }

    public function getModel()
    {
        return $this->category;
    }

    const PAGINATE_CATEGORY = '15';

    /**
     * Display a listing of Products
     *
     * @return Builder[]|Collection
     */
    public function get()
    {
        return $this->category->query()
            ->with(['parent', 'children'])
            ->select(['id', 'name', 'parent_id', 'slug', 'sort_key'])
            ->get();
    }

    public function getParent()
    {
        return $this->category->query()
            ->where('parent_id',0)
            ->with(['children'])
            ->select(['id', 'name', 'parent_id', 'slug', 'sort_key','avatar'])
            ->get();
    }

    public function getCategory($parentId = "")
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
        return $this->category->query()
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
            $categoryCreate = [
                'name' => $request->name,
                'slug' => Str::slug($request->name),
                'parent_id' => $request->parent_id
            ];
            if ($request->hasFile('avatar')) {
                $image = $request->avatar;
                $categoryCreate['avatar'] = $this->uploadFile($image, CATEGORY_DIR . '/' . auth()->id() . '/' . Str::random(30) . "." . $image->getClientOriginalExtension());
            }
            $this->category->query()->create($categoryCreate);
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
        return $this->category->query()->findOrFail($id);
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
            $categoryUpdate = [
                'name' => $request->name,
                'slug' => Str::slug($request->name),
                'parent_id' => $request->parent_id
            ];
            $category = $this->findItem($id);
            if ($request->hasFile('avatar')) {
                $image = $request->avatar;
                $categoryUpdate['avatar'] = $this->uploadFile($image, CATEGORY_DIR . '/' . auth()->id() . '/' . Str::random(30) . "." . $image->getClientOriginalExtension());
            }
            $category->update($categoryUpdate);
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
            $category = $this->category->query()->findOrFail($id);
            if ($category->children->count() > 0) {
                $categoriesChildren = $category->children->pluck('id')->toArray();
                $this->category->query()->whereIn('id', $categoriesChildren)->delete();
            }
            $category->delete();
            DB::commit();
            return true;
        } catch (Exception $e) {
            DB::rollBack();
            Log::error("Message: {$e->getMessage()}. Line: {$e->getLine()}");
            return false;
        }
    }
}
