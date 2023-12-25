<?php

namespace App\Services;

use App\Helpers\UploadHelper;
use App\Http\Requests\CategoryRequest;
use App\Models\Blog;
use App\Models\UserAddress;
use App\Traits\StorageImageTrait;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class BlogService
{
    use StorageImageTrait;

    private $blog;

    public function __construct(Blog $blog)
    {
        $this->blog = $blog;
    }

    const PAGINATE_CATEGORY = '15';


    public function getModel()
    {
        return $this->blog;
    }

    /**
     * Display a listing of Products
     *
     * @return Builder[]|Collection
     */
    public function get()
    {
        return $this->blog->query()
            ->get();
    }

    /**
     * Display a listing of Products
     *
     * @return LengthAwarePaginator
     */
    public function getPaginate()
    {
        return $this->blog->query()
            ->latest()
            ->paginate(self::PAGINATE_CATEGORY);
    }

    /**
     * Insert Product
     * @param CategoryRequest $request
     * @return bool
     */
    public function insertBlog($request)
    {
        $data = [
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'description' => $request->description,
            'status' => $request->status,
            'user_id' => Auth::guard('admin')->id()

        ];
        // Store thumbnail image
        if ($request->hasFile('thumbnail')) {
            $thumbnail = UploadHelper::handleUploadFile('thumbnail', BLOG_DIR . '/' . Auth::guard('admin')->id(), $request);
            if ($thumbnail) {
                $data['thumbnail'] = $thumbnail;
            }
        }
        // Store avatar image
        $this->blog->query()->create($data);
    }

    /**
     * Get Category via ID
     * @param int $id
     * @return Builder|Builder[]|Collection|Model
     */
    public function findItem($id)
    {
        return $this->blog->query()->findOrFail($id);
    }

    /**
     * Update Category
     * @param int $id ,
     * @param UpdateCategoryRequest $request
     * @return bool
     */
    public function update($request, $id)
    {
        $blog = $this->blog->findOrFail($id);
        $data = [
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'description' => $request->description,
            'status' => $request->status,
            'user_id' => Auth::guard('admin')->id()

        ];
        // Store thumbnail image
        if ($request->hasFile('thumbnail')) {
            $thumbnail = UploadHelper::handleUploadFile('thumbnail', BLOG_DIR . '/' . Auth::guard('admin')->id(), $request);
            if ($thumbnail) {
                UploadHelper::handleRemoveFile($blog->thumbnail);
                $data['thumbnail'] = $thumbnail;
            }
        }
        // Store avatar image
        $blog->update($data);
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
            $blog = $this->blog->query()->findOrFail($id);
            if (!empty($blog->image)) {
                $this->deleteFile($blog->image);
            }
            $blog->delete();
            DB::commit();
            return true;
        } catch (Exception $e) {
            DB::rollBack();
            Log::error("Message: {$e->getMessage()}. Line: {$e->getLine()}");
            return false;
        }
    }

    public function addShippingAddress($request)
    {
        DB::beginTransaction();
        try {
            $userAddress = new UserAddress();
            $userAddress->user_id = Auth::user()->id;
            $userAddress->address = $request->shipping_address;
            $userAddress->receiver_first_name = $request->shipping_firstname;
            $userAddress->receiver_last_name = $request->shipping_lastname;
            $userAddress->phone_number = $request->shipping_phone;
            $userAddress->save();

            $cartShippingAddress = $this->getShippingAddressUser();
            $htmlListShippingAddressUser = view('frontend.carts.components.user-shipping-address', compact('cartShippingAddress'))->render();
            $htmlListShippingAddressUserProfile = view('frontend.account.components.list-address', [
                'addressDelivery' => $cartShippingAddress
            ])->render();

            DB::commit();
            return response()->json([
                'status' => 200,
                'data' => $htmlListShippingAddressUser,
                'htmlProfileAddress' => $htmlListShippingAddressUserProfile
            ], 200);
        } catch (Exception $e) {
            DB::rollBack();
            Log::error("Message: {$e->getMessage()}. Line: {$e->getLine()}");
            return response()->json([
                'status' => 500,
                'data' => trans('messages.server_error'),
            ], 500);
        }
    }

    public function getShippingAddressUser()
    {
        $userShippingAddress = [];
        if (Auth::check()) {
            $userShippingAddress = $this->userAddress::query()->where('user_id', Auth::user()->id)->get();
        }
        return $userShippingAddress;
    }
}
