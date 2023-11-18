<?php

namespace App\Services;

use App\Helpers\Common;
use App\Http\Requests\CategoryRequest;
use App\Jobs\SendMailCheckOut;
use App\Models\Brand;
use App\Models\Cart;
use App\Models\CartDetail;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use App\Models\UserAddress;
use App\Traits\StorageImageTrait;
use Carbon\Carbon;
use Exception;
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

    public function __construct(Cart $cart, Product $product, UserAddress $userAddress, CartDetail $cartDetail, Order $order, OrderDetail $orderDetail)
    {
        $this->cart = $cart;
        $this->userAddress = $userAddress;
        $this->product = $product;
        $this->order = $order;
        $this->orderDetail = $orderDetail;
        $this->cartDetail = $cartDetail;
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

    public function checkoutCart($request)
    {
        DB::beginTransaction();
        try {
            $carts = Session::get('carts');
            $userId = Auth::user()->id;
//            dd($request->all(), $carts);


            $totalPrice = 0;
            $basePrice = 0;

            // Init Order
            $cart = new Cart();
            $cart->user_id = $userId;
            $cart->payment_method = $request->payment_method ?? 1;
            $cart->delivery_method = $request->delivery_method;
            $cart->discount_id = $request->discount_id ?? 1;
            $cart->user_address_id = $request->user_address_id;
            $cart->user_comment = $request->get('note-shipping');
            if ($request->delivery_method == Order::PICK_STORE) {
                $cart->shipping_date = Carbon::createFromFormat('d/m/Y', $request->pick_store_date)->format('Y-m-d');
                $cart->shipping_hours = $request->pick_store_hour;
            } elseif ($request->delivery_method == Order::PICK_SHIP) {
                $cart->shipping_date = Carbon::createFromFormat('d/m/Y', $request->pick_ship_date)->format('Y-m-d');
                $cart->shipping_hours = $request->pick_ship_hour;
            }
            $cart->save();


            // Init Order
            $order = new Order();
            $order->cart_id = $cart->id;
            $order->user_id = $userId;
            $order->payment_method = $cart->payment_method ?? 1;
            $order->delivery_method = $cart->delivery_method;
            $order->discount_id = $cart->discount_id ?? 1;
            $order->user_address_id = $cart->user_address_id;
            $order->user_comment = $cart->user_comment;
            $order->shipping_date = $cart->shipping_date;
            $order->shipping_hours = $cart->shipping_hours;
            $order->order_status = ORDER::PENDING;
            $order->save();
            $hashOrderId = ORDER_PREFIX . str_pad($order->id, 3, '0', STR_PAD_LEFT);
            $order->hash_order_id = $hashOrderId;
            $order->save();


            // Insert Cart Detail
            $dataCartDetail = [];
            foreach ($carts as $cartItem) {
                $product = $cartItem['product'];
                $quantity = $cartItem['quantity'];
                $priceOfProduct = $product->getPrice();
                $subTotal = $priceOfProduct * $quantity;
                $totalPrice = $subTotal + ($product->ship_fee ?? 0);

                $dataCartDetail[] = [
                    'cart_id' => $cart->id,
                    'product_id' => $product->id,
                    'price' => $priceOfProduct,
                    'quantity' => $quantity,
                    'sub_total' => $priceOfProduct * $quantity,
                    'total_price' => $totalPrice,
                    'user_address_id' => $request->user_address_id
                ];

            }
            $this->cartDetail::query()->insert($dataCartDetail);

            // Insert Order Detail
            $dataOrderDetail = [];
            foreach ($carts as $cartItem) {
                $product = $cartItem['product'];
                $quantity = $cartItem['quantity'];
                $priceOfProduct = $product->getPrice();
                $subTotal = $priceOfProduct * $quantity;
                $totalPrice = $subTotal + ($product->ship_fee ?? 0);

                $dataOrderDetail[] = [
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'price' => $priceOfProduct,
                    'quantity' => $quantity,
                    'sub_total' => $priceOfProduct * $quantity,
                    'total_price' => $totalPrice,
                    'user_address_id' => $request->user_address_id
                ];

            }
            $this->orderDetail::query()->insert($dataOrderDetail);

            // Update Cart
            $cartDetailById = $this->cartDetail::query()->where('cart_id', $cart->id);
            $totalBasePrice = $cartDetailById->sum('price');
            $totalSubPrice = $cartDetailById->sum('sub_total');
            $totalPrice = $cartDetailById->sum('total_price');
            $cart->price = $totalBasePrice;
            $cart->sub_total = $totalSubPrice;
            $cart->total_price = $totalPrice;
            $cart->save();

            // Update Order
            $order->sub_total = $cart->sub_total;
            $order->total_price = $cart->total_price;
            $order->save();

            Session::forget('carts');

            #Send Mail
            SendMailCheckOut::dispatch(Auth::user())->delay(now()->addSeconds(3));
            DB::commit();
            return true;

        } catch (Exception $e) {
            DB::rollBack();
            Log::error("Message: {$e->getMessage()}. Line: {$e->getLine()}");
            return false;
        }
    }
}
