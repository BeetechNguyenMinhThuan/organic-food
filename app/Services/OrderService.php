<?php

namespace App\Services;

use App\Http\Requests\CategoryRequest;
use App\Jobs\SendMailCheckOut;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use App\Models\UserAddress;
use App\Traits\StorageImageTrait;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class OrderService
{
    use StorageImageTrait;

    private Product $product;
    private UserAddress $userAddress;
    private Order $order;
    private OrderDetail $orderDetail;

    public function __construct(Product $product, UserAddress $userAddress, Order $order, OrderDetail $orderDetail)
    {
        $this->cart = $order;
        $this->userAddress = $userAddress;
        $this->product = $product;
        $this->order = $order;
        $this->orderDetail = $orderDetail;
        $this->cartDetail = $orderDetail;
    }

    const PAGINATE_CATEGORY = '15';

    /**
     * Display a listing of Products
     *
     * @return Builder[]|Collection
     */
    public function get()
    {
        return $this->order->query()
            ->get();
    }

    /**
     * Display a listing of Products
     *
     * @return LengthAwarePaginator
     */
    public function getPaginate()
    {
        return $this->order->query()
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
            $orders = Session::get('carts');

            if (isset($orders[$productId])) {
                $orders[$productId]['quantity'] = $orders[$productId]['quantity'] + $quantity;
            } else {
                $orders[$productId] = [
                    'product' => $product,
                    'quantity' => $quantity
                ];
            }
            Session::put('carts', $orders);
            $orders = Session::get('carts');
            $orderDropdownComponent = view('frontend.carts.components.cart-header-dropdown', compact('carts'))->render();

            return response()->json([
                'code' => 200,
                'message' => 'success',
                'cartListDropdown' => $orderDropdownComponent
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
                $orders = Session::get('carts');

                if (isset($orders[$productId])) {
                    $orders[$productId]['quantity'] = $quantity;
                    Session::put('carts', $orders);

                    $orders = Session::get('carts');
                    $orderListComponent = view('frontend.carts.components.cart-list', compact('carts'))->render();
                    $orderDropdownComponent = view('frontend.carts.components.cart-header-dropdown', compact('carts'))->render();

                    return response()->json([
                        'status' => 200,
                        'cartList' => $orderListComponent,
                        'cartListDropdown' => $orderDropdownComponent
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
                $orders = Session::get('carts');
                if (isset($orders[$productId])) {
                    unset($orders[$productId]);
                    Session::put('carts', $orders);
                    $orders = Session::get('carts');
                    $orderListComponent = view('frontend.carts.components.cart-list', compact('carts'))->render();
                    $orderDropdownComponent = view('frontend.carts.components.cart-header-dropdown', compact('carts'))->render();

                    return response()->json([
                        'status' => 200,
                        'cartList' => $orderListComponent,
                        'cartListDropdown' => $orderDropdownComponent
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
        $orders = Session::get('carts');
        if (!empty($orders)) {
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
        return $this->order->query()->findOrFail($id);
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

            $orderShippingAddress = $this->getShippingAddressUser();
            $htmlListShippingAddressUser = view('frontend.carts.components.user-shipping-address', compact('cartShippingAddress'))->render();

            DB::commit();
            return response()->json([
                'status' => 200,
                'data' => $htmlListShippingAddressUser,
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

    public function checkoutCart($request)
    {
        DB::beginTransaction();
        try {
            $orders = Session::get('carts');
            $userId = Auth::user()->id;
//            dd($request->all(), $orders);


            $totalPrice = 0;
            $basePrice = 0;

            // Init Order
            $order = new Cart();
            $order->user_id = $userId;
            $order->payment_method = $request->payment_method ?? 1;
            $order->delivery_method = $request->delivery_method;
            $order->discount_id = $request->discount_id ?? 1;
            $order->user_address_id = $request->user_address_id;
            $order->user_comment = $request->get('note-shipping');
            if ($request->delivery_method == Cart::PICK_STORE) {
                $order->shipping_date = Carbon::createFromFormat('d/m/Y', $request->pick_store_date)->format('Y-m-d');
                $order->shipping_hours = $request->pick_store_hour;
            } elseif ($request->delivery_method == Cart::PICK_SHIP) {
                $order->shipping_date = Carbon::createFromFormat('d/m/Y', $request->pick_ship_date)->format('Y-m-d');
                $order->shipping_hours = $request->pick_ship_hour;
            }
            $order->save();


            // Init Order
            $order = new Order();
            $order->cart_id = $order->id;
            $order->user_id = $userId;
            $order->payment_method = $request->payment_method ?? 1;
            $order->delivery_method = $request->delivery_method;
            $order->discount_id = $request->discount_id ?? 1;
            $order->user_address_id = $request->user_address_id;
            $order->user_comment = $request->get('note-shipping');
            if ($request->delivery_method == Cart::PICK_STORE) {
                $order->shipping_date = Carbon::createFromFormat('d/m/Y', $request->pick_store_date)->format('Y-m-d');
                $order->shipping_hours = $request->pick_store_hour;
            } elseif ($request->delivery_method == Cart::PICK_SHIP) {
                $order->shipping_date = Carbon::createFromFormat('d/m/Y', $request->pick_ship_date)->format('Y-m-d');
                $order->shipping_hours = $request->pick_ship_hour;
            }
            $order->save();


            // Insert Cart Detail
            $dataCartDetail = [];
            foreach ($orders as $orderItem) {
                $product = $orderItem['product'];
                $quantity = $orderItem['quantity'];
                $priceOfProduct = $product->getPrice();
                $subTotal = $priceOfProduct * $quantity;
                $totalPrice = $subTotal + ($product->ship_fee ?? 0);

                $dataCartDetail[] = [
                    'cart_id' => $order->id,
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
            foreach ($orders as $orderItem) {
                $product = $orderItem['product'];
                $quantity = $orderItem['quantity'];
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
            $orderDetailById = $this->cartDetail::query()->where('cart_id', $order->id);
            $totalBasePrice = $orderDetailById->sum('price');
            $totalSubPrice = $orderDetailById->sum('sub_total');
            $totalPrice = $orderDetailById->sum('total_price');
            $order->price = $totalBasePrice;
            $order->sub_total = $totalSubPrice;
            $order->total_price = $totalPrice;
            $order->save();

            // Update Order
            $orderDetailById = $this->orderDetail::query()->where('order_id', $order->id);
            $totalBasePrice = $orderDetailById->sum('price');
            $totalSubPrice = $orderDetailById->sum('sub_total');
            $totalPrice = $orderDetailById->sum('total_price');
            $order->sub_total = $totalSubPrice;
            $order->total_price = $totalPrice;
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
