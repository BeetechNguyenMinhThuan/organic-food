<?php

namespace App\Services;

use App\Helpers\Common;
use App\Http\Requests\CategoryRequest;
use App\Jobs\SendMailCheckOut;
use App\Models\Brand;
use App\Models\Cart;
use App\Models\CartDetail;
use App\Models\Discount;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use App\Models\UserAddress;
use App\Traits\StorageImageTrait;
use Carbon\Carbon;
use Exception;
use http\Env\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class CartService
{
    use StorageImageTrait;

    private $cart;
    private Product $product;
    private UserAddress $userAddress;
    private CartDetail $cartDetail;
    private Order $order;
    private OrderDetail $orderDetail;
    private Discount $discount;

    public function __construct(Discount $discount, Cart $cart, Product $product, UserAddress $userAddress, CartDetail $cartDetail, Order $order, OrderDetail $orderDetail)
    {
        $this->cart = $cart;
        $this->userAddress = $userAddress;
        $this->product = $product;
        $this->order = $order;
        $this->orderDetail = $orderDetail;
        $this->cartDetail = $cartDetail;
        $this->discount = $discount;
    }

    const PAGINATE_CATEGORY = '15';

    /**
     * Display a listing of Products
     *
     * @return Builder[]|Collection
     */
    public function get()
    {
        return $this->cart->query()
            ->get();
    }

    /**
     * Display a listing of Products
     *
     * @return LengthAwarePaginator
     */
    public function getPaginate()
    {
        return $this->brand->query()
            ->latest()
            ->paginate(self::PAGINATE_CATEGORY);
    }

    /**
     * Insert Product
     * @param CategoryRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function create($request, $productId)
    {
        try {
            $quantity = (int)$request->quantity;
            if (!$quantity) {
                $quantity = 1;
            }
            if (!$productId) {
                return response()->json([
                    'code' => 500,
                    'data' => trans('messages.server_error'),
                ], 500);
            }
            $product = $this->product->findOrFail($productId);
            $carts = Session::get('carts');

            if (isset($carts[$productId])) {
                $carts[$productId]['quantity'] = $carts[$productId]['quantity'] + $quantity;
            } else {
                $carts[$productId] = [
                    'product' => $product,
                    'quantity' => $quantity
                ];
            }
            Session::put('carts', $carts);
            $carts = Session::get('carts');
            $cartDropdownComponent = view('frontend.carts.components.cart-header-dropdown', compact('carts'))->render();

            return response()->json([
                'code' => 200,
                'message' => 'success',
                'cartListDropdown' => $cartDropdownComponent
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'code' => 500,
                'data' => trans('messages.server_error'),
            ], 500);
        }

    }

    public function updateCart($request)
    {
        try {
            $quantity = $request->quantity;
            $productId = $request->productId;

            if ($productId && $quantity) {
                $carts = Session::get('carts');

                if (isset($carts[$productId])) {
                    $carts[$productId]['quantity'] = $quantity;
                    Session::put('carts', $carts);

                    $carts = Session::get('carts');
                    $cartListComponent = view('frontend.carts.components.cart-list', compact('carts'))->render();
                    $cartDropdownComponent = view('frontend.carts.components.cart-header-dropdown', compact('carts'))->render();

                    return response()->json([
                        'status' => 200,
                        'cartList' => $cartListComponent,
                        'cartListDropdown' => $cartDropdownComponent
                    ], 200);
                }
            }
        } catch (\Exception $e) {
            // Xử lý ngoại lệ ở đây
            return response()->json([
                'status' => 500,
                'data' => trans('messages.server_error'),
            ], 500);
        }
    }

    public function deleteCart($request)
    {
        try {
            $productId = $request->productId;
            if ($productId) {
                $carts = Session::get('carts');
                if (isset($carts[$productId])) {
                    unset($carts[$productId]);
                    Session::put('carts', $carts);
                    $carts = Session::get('carts');
                    $cartListComponent = view('frontend.carts.components.cart-list', compact('carts'))->render();
                    $cartDropdownComponent = view('frontend.carts.components.cart-header-dropdown', compact('carts'))->render();

                    return response()->json([
                        'status' => 200,
                        'cartList' => $cartListComponent,
                        'cartListDropdown' => $cartDropdownComponent
                    ], 200);
                }
            }
        } catch (\Exception $e) {
            return response()->json([
                'status' => 500,
                'data' => trans('messages.server_error'),
            ], 500);
        }
    }

    public function deleteAllCart()
    {
        $carts = Session::get('carts');
        if (!empty($carts)) {
            Session::forget('carts');
            return true;
        }
        return false;
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
        DB::beginTransaction();
        try {
            $brandUpdate = [
                'name' => $request->name,
                'slug' => Str::slug($request->name),
                'parent_id' => $request->parent_id
            ];
            $brand = $this->findItem($id);
            $brand->update($brandUpdate);
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

    public function checkDiscountCode($request)
    {
        $discountName = $request->name;
        $discount = $this->discount::query()->where('name', $discountName)->first();
        if ($discount) {
            Session::put('discount_id', $discount->id);
            $cartDropdownComponent = view('frontend.carts.components.cart-header-dropdown', compact('carts'))->render();
            return response()->json([
                'status' => 200,
                'cartList' => $cartListComponent,
                'cartListDropdown' => $cartDropdownComponent
            ], 200);
        }
        return response()->json([
            'status' => 500,
            'data' => trans('messages.server_error'),
        ], 500);
    }
}
