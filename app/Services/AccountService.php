<?php

namespace App\Services;

use App\Helpers\UploadHelper;
use App\Http\Requests\CategoryRequest;
use App\Models\Blog;
use App\Models\User;
use App\Models\UserAddress;
use App\Traits\StorageImageTrait;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class AccountService
{
    use StorageImageTrait;

    private $blog;
    private User $user;
    private UserAddress $userAddress;

    public function __construct(UserAddress $userAddress, Blog $blog, User $user)
    {
        $this->blog = $blog;
        $this->userAddress = $userAddress;
        $this->user = $user;
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
                $data['thumbnail'] = $thumbnail;
                UploadHelper::handleRemoveFile($blog->thumbnail);
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
            $userAddress = new $this->userAddress;
            $userAddress->user_id = Auth::user()->id;
            $userAddress->address = $request->shipping_address;
            $userAddress->receiver_first_name = $request->shipping_firstname;
            $userAddress->receiver_last_name = $request->shipping_lastname;
            $userAddress->phone_number = $request->shipping_phone;
            $userAddress->save();

            $cartShippingAddress = $this->getShippingAddressUser();
            $htmlListShippingAddressUser = view('frontend.carts.components.user-shipping-address', compact('cartShippingAddress'))->render();
            $htmlProfileAddress = view('frontend.account.components.list-address', [
                'addressDelivery' => $cartShippingAddress
            ])->render();

            DB::commit();
            return response()->json([
                'status' => 200,
                'data' => $htmlListShippingAddressUser,
                'htmlProfileAddress' => $htmlProfileAddress
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

    public function deleteShippingAddress($id)
    {
        DB::beginTransaction();
        try {
            $userAddress = $this->userAddress::query()->find($id);
            if ($userAddress) {
                $userAddress->delete();
                $cartShippingAddress = $this->getShippingAddressUser();
                $htmlProfileAddress = view('frontend.account.components.list-address', [
                    'addressDelivery' => $cartShippingAddress
                ])->render();
                DB::commit();
                return response()->json([
                    'status' => 200,
                    'htmlProfileAddress' => $htmlProfileAddress
                ], 200);
            }
        } catch (Exception $e) {
            DB::rollBack();
            Log::error("Message: {$e->getMessage()}. Line: {$e->getLine()}");
            return response()->json([
                'status' => 500,
                'data' => trans('messages.server_error'),
            ], 500);
        }
    }

    public function updateAccount($request)
    {
        DB::beginTransaction();
        try {
            $user = Auth::user();
            $user->first_name = $request->first_name;
            $user->last_name = $request->last_name;
            $user->email = $request->email;
            $user->phone = $request->phone;
            if (!empty($request->current_password) && !empty($request->new_password) && !empty($request->confirm_password)) {
                if (Hash::check($request->current_password, $user->password) && $request->new_password == $request->confirm_password) {
                    $user->password = $request->new_password;
                }else{
                    return false;
                }
            }
            if ($request->hasFile('avatar')) {
                $avatar = UploadHelper::handleUploadFile('avatar', USER_DIR . '/avatar/' . Auth::user()->id . "/", $request);
                if ($avatar) {
                    UploadHelper::handleRemoveFile($user->avatar);
                    $user->avatar = $avatar;
                }
            }
            $user->save();
            DB::commit();
            return true;
        } catch (Exception $e) {
            DB::rollBack();
            Log::error("Message: {$e->getMessage()}. Line: {$e->getLine()}");
            return false;
        }

    }

}
