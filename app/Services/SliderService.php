<?php

namespace App\Services;

use App\Http\Requests\CategoryRequest;
use App\Models\Slider;
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

class SliderService
{
    use StorageImageTrait;

    private $slider;

    public function __construct(Slider $slider)
    {
        $this->slider = $slider;
    }

    const PAGINATE_CATEGORY = '15';

    /**
     * Display a listing of Products
     *
     * @return Builder[]|Collection
     */
    public function get()
    {
        return $this->slider->query()
            ->get();
    }

    /**
     * Display a listing of Products
     *
     * @return LengthAwarePaginator
     */
    public function getPaginate()
    {
        return $this->slider->query()
            ->latest()
            ->paginate(self::PAGINATE_CATEGORY);
    }

    /**
     * Insert Product
     * @param CategoryRequest $request
     * @return bool
     */
    public function insertSlider($request)
    {
        $data = [
            'name' => $request->name,
            'description' => $request->description,
        ];
        // Store avatar image
        if ($request->hasFile('image')) {
            $image = $request->image;
            $data['image'] = $this->uploadFile($image, SLIDER_DIR . '/' . auth()->id() . '/' . Str::random(30) . "." . $image->getClientOriginalExtension());
        }
        $this->slider->query()->create($data);
    }

    /**
     * Get Category via ID
     * @param int $id
     * @return Builder|Builder[]|Collection|Model
     */
    public function findItem($id)
    {
        return $this->slider->query()->findOrFail($id);
    }

    /**
     * Update Category
     * @param int $id ,
     * @param UpdateCategoryRequest $request
     * @return bool
     */
    public function updateSlider($request, $id)
    {
        $data = [
            'name' => $request->name,
            'description' => $request->description,
        ];
        // Store avatar image
        if ($request->hasFile('image')) {
            $image = $request->image;
            $data['image'] = $this->uploadFile($image, SLIDER_DIR . '/' . auth()->id() . '/' . Str::random(30) . "." . $image->getClientOriginalExtension());
        }
        $this->slider->query()->find($id)->update($data);
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
            $slider = $this->slider->query()->findOrFail($id);
            if (!empty($slider->image)) {
                $this->deleteFile($slider->image);
            }
            $slider->delete();
            DB::commit();
            return true;
        } catch (Exception $e) {
            DB::rollBack();
            Log::error("Message: {$e->getMessage()}. Line: {$e->getLine()}");
            return false;
        }
    }
}
