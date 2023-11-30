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
use App\Models\Payment;
use App\Models\PaymentMethod;
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

class PaymentService
{
    use StorageImageTrait;

    private $cart;
    private Product $product;
    private UserAddress $userAddress;
    private CartDetail $cartDetail;
    private Order $order;
    private OrderDetail $orderDetail;
    private PaymentMethod $paymentMethod;
    private Payment $payment;

    public function __construct(PaymentMethod $paymentMethod, Payment $payment, Cart $cart, Product $product, UserAddress $userAddress, CartDetail $cartDetail, Order $order, OrderDetail $orderDetail)
    {
        $this->cart = $cart;
        $this->userAddress = $userAddress;
        $this->product = $product;
        $this->order = $order;
        $this->orderDetail = $orderDetail;
        $this->cartDetail = $cartDetail;
        $this->paymentMethod = $paymentMethod;
        $this->payment = $payment;
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

    public function createOrder($cart)
    {
        $carts = Session::get('carts');
        $userId = Auth::user()->id;

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
                'user_address_id' => $cart->user_address_id,
                'created_at' => now(),
                'updated_at' => now()
            ];

        }
        $this->orderDetail::query()->insert($dataOrderDetail);


        // Update Order
        $order->sub_total = $cart->sub_total;
        $order->total_price = $cart->total_price;
        $order->save();

        return $order;
    }


    public function paymentCart($request)
    {
        DB::beginTransaction();
        try {
            $carts = Session::get('carts');
            $userId = Auth::user()->id;

            if (!$request->delivery_method || !$request->payment_method) {
                return redirect()->route('cart.show')->with([
                    'status_failed' => trans('messages.require_input'),
                ]);
            }

            if ($request->delivery_method == Order::PICK_STORE && (!$request->pick_store_date || !$request->pick_store_hour)) {
                return redirect()->route('cart.show')->with([
                    'status_failed' => trans('messages.require_input'),
                ]);
            }

            if ($request->delivery_method == Order::PICK_SHIP && (!$request->pick_ship_date || !$request->pick_ship_hour || !$request->user_address_id)) {
                return redirect()->route('cart.show')->with([
                    'status_failed' => trans('messages.require_input'),
                ]);
            }


            // Init Cart
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

            // Update Cart
            $cartDetailById = $this->cartDetail::query()->where('cart_id', $cart->id);
            $totalBasePrice = $cartDetailById->sum('price');
            $totalSubPrice = $cartDetailById->sum('sub_total');
            $totalPrice = $cartDetailById->sum('total_price');
            $cart->price = $totalBasePrice;
            $cart->sub_total = $totalSubPrice;
            $cart->total_price = $totalPrice;
            $cart->save();
            DB::commit();


            if ($request->payment_method == PaymentMethod::VN_PAY) {
                Session::put('cart_id', $cart->id);
                return view('frontend.payments.vnpay.index', compact('cart'));
            }

            $this->createOrder($cart);


            Session::forget('carts');

            #Send Mail
            SendMailCheckOut::dispatch(Auth::user())->delay(now()->addSeconds(3));
            DB::commit();
            return redirect()->route('cart.show')->with([
                'success' => trans('messages.cart.order_success')
            ]);

        } catch (Exception $e) {
            DB::rollBack();
            Log::error("Message: {$e->getMessage()}. Line: {$e->getLine()}");
            return redirect()->route('cart.show')->with([
                'status_failed' => trans('messages.server_error'),
            ]);
        }
    }

    public function createPaymentVNPAY($request)
    {
        $cart = $this->cart::query()->findOrFail($request->cart_id);
        $vnp_Url = env("VNP_URL");
        $vnp_Returnurl = route('payment.vnpay.return');
        $vnp_TmnCode = env("VNP_TMN_CODE");//Mã website tại VNPAY
        $vnp_HashSecret = env("VNP_HASH_SECRET"); //Chuỗi bí mật
        $vnp_TxnRef = uniqid(); //Mã đơn hàng. Trong thực tế Merchant cần insert đơn hàng vào DB và gửi mã này sang VNPAY
        $vnp_OrderInfo = $request->order_info;
        $vnp_OrderType = $request->ordertype;
        $vnp_Amount = $cart->total_price * 100;
        $vnp_Locale = $request->language;
        $vnp_BankCode = $request->bankcode;
        $vnp_IpAddr = $_SERVER['REMOTE_ADDR'];

        $inputData = array(
            "vnp_Version" => "2.1.0",
            "vnp_TmnCode" => $vnp_TmnCode,
            "vnp_Amount" => $vnp_Amount,
            "vnp_Command" => "pay",
            "vnp_CreateDate" => date('YmdHis'),
            "vnp_CurrCode" => "VND",
            "vnp_IpAddr" => $vnp_IpAddr,
            "vnp_Locale" => $vnp_Locale,
            "vnp_OrderInfo" => $vnp_OrderInfo,
            "vnp_OrderType" => $vnp_OrderType,
            "vnp_ReturnUrl" => $vnp_Returnurl,
            "vnp_TxnRef" => $vnp_TxnRef,
        );

        if (isset($vnp_BankCode) && $vnp_BankCode != "") {
            $inputData['vnp_BankCode'] = $vnp_BankCode;
        }
        if (isset($vnp_Bill_State) && $vnp_Bill_State != "") {
            $inputData['vnp_Bill_State'] = $vnp_Bill_State;
        }

        ksort($inputData);
        $query = "";
        $i = 0;
        $hashdata = "";
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashdata .= urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
            $query .= urlencode($key) . "=" . urlencode($value) . '&';
        }

        $vnp_Url = $vnp_Url . "?" . $query;
        if (isset($vnp_HashSecret)) {
            $vnpSecureHash = hash_hmac('sha512', $hashdata, $vnp_HashSecret);//
            $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
        }

        return redirect($vnp_Url);

    }

    public function vnpayReturn($request)
    {
        if ($request->vnp_ResponseCode === "00") {
            DB::beginTransaction();
            try {
                $vnPayData = $request->all();
                $cart = $this->cart::query()->find(Session::get('cart_id'));
                $order = $this->createOrder($cart);

                $payment = new Payment();
                $payment->order_id = $order->id;
                $payment->user_id = $order->user_id;
                $payment->money = $order->total_price;
                $payment->note = $vnPayData['vnp_OrderInfo'];
                $payment->transaction_code = $vnPayData['vnp_TxnRef'];
                $payment->vnpay_response_code = $vnPayData['vnp_ResponseCode'];
                $payment->vnpay_code = $vnPayData['vnp_TransactionNo'];
                $payment->bank_code = $vnPayData['vnp_BankCode'];
                $payment->p_time = $vnPayData['vnp_PayDate'];
                $payment->save();
                Session::forget('carts');

                DB::commit();
                return view('frontend.payments.vnpay.return', compact('payment', 'order', 'vnPayData'));
            } catch (Exception $e) {
                DB::rollBack();
                Log::error("Message: {$e->getMessage()}. Line: {$e->getLine()}");
                return false;
            }
        }
    }
}
