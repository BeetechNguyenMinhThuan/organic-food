<?php

namespace App\Services;

use App\Http\Requests\CategoryRequest;
use App\Models\Brand;
use App\Services\Admin\Builder;
use App\Services\Admin\Collection;
use App\Services\Admin\LengthAwarePaginator;
use App\Services\Admin\Model;
use App\Services\Admin\UpdateCategoryRequest;
use App\Traits\StorageImageTrait;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class BrandService
{
    use StorageImageTrait;

    private $brand;

    public function __construct(Brand $brand)
    {
        $this->brand = $brand;
    }

    const PAGINATE_CATEGORY = '15';


    public function getModel()
    {
        return $this->brand;
    }

    /**
     * Display a listing of Products
     *
     * @return Builder[]|Collection
     */
    public function get()
    {
        return $this->brand->query()
            ->get();
    }

    /**
     * Display a listing of Products
     *
     * @return LengthAwarePaginator
     */
    public function getPaginate($request)
    {
        $data = $this->brand->query()
            ->latest();
        if ($request->search) {
            $data->where('name','LIKE', "%$request->search%");
        }
        return $data->paginate(self::PAGINATE_CATEGORY);
    }

    /**
     * Insert Product
     * @param CategoryRequest $request
     * @return bool
     */
    public function insertBrand($request)
    {
        $data = [
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'description' => $request->description,
        ];
        // Store avatar image
        if ($request->hasFile('image')) {
            $image = $request->image;
            $data['image'] = $this->uploadFile($image, BRAND_DIR . '/' . auth()->id() . '/' . Str::random(30) . "." . $image->getClientOriginalExtension());
        }
        $this->brand->query()->create($data);
    }

    /**
     * Get Category via ID
     * @param int $id
     * @return Builder|Builder[]|Collection|Model
     */
    public function findItem($id)
    {
        return $this->brand->query()->findOrFail($id);
    }

    /**
     * Update Category
     * @param int $id ,
     * @param UpdateCategoryRequest $request
     * @return bool
     */
    public function update($request, $id)
    {
        $data = [
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'description' => $request->description,
        ];
        // Store avatar image
        if ($request->hasFile('image')) {
            $image = $request->image;
            $data['image'] = $this->uploadFile($image, BRAND_DIR . '/' . auth()->id() . '/' . Str::random(30) . "." . $image->getClientOriginalExtension());
        }
        $this->brand->query()->find($id)->update($data);
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
            $brand = $this->brand->query()->findOrFail($id);
            if (!empty($brand->image)) {
                $this->deleteFile($brand->image);
            }
            $brand->delete();
            DB::commit();
            return true;
        } catch (Exception $e) {
            DB::rollBack();
            Log::error("Message: {$e->getMessage()}. Line: {$e->getLine()}");
            return false;
        }
    }
}
