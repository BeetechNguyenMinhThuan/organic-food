<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\AccountRequest;
use App\Services\AccountService;
use App\Services\BlogService;
use App\Services\CategoryService;
use App\Services\MenuService;
use App\Services\OrderService;
use App\Services\ProductService;
use App\Services\SliderService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AccountController extends Controller
{
    private AccountService $accountService;

    public function __construct(OrderService $orderService, AccountService $accountService, BlogService $blogService, SliderService $sliderService, CategoryService $categoryService, ProductService $productService, MenuService $menuService)
    {
        $this->sliderService = $sliderService;
        $this->categoryService = $categoryService;
        $this->productService = $productService;
        $this->menuService = $menuService;
        $this->blogService = $blogService;
        $this->accountService = $accountService;
        $this->orderService = $orderService;
    }

    public function profile()
    {
        $sliders = $this->sliderService->get();
        $categories = $this->categoryService->getParent();
        $menus = $this->menuService->getParent();
        $blogs = $this->blogService->getPaginate();
        $orders = $this->orderService->getModel()::query()->where('user_id', Auth::user()->id)->paginate(15);
        $user = Auth::user();
        $addressDelivery = $user->addresses;
        return view('frontend.account.profile', [
            'sliders' => $sliders,
            'categories' => $categories,
            'menus' => $menus,
            'blogs' => $blogs,
            'user' => $user,
            'orders' => $orders,
            'addressDelivery' => $addressDelivery
        ]);
    }

    public function addShippingAddress(Request $request)
    {
        return $this->accountService->addShippingAddress($request);
    }

    public function deleteShippingAddress($id)
    {
        return $this->accountService->deleteShippingAddress($id);

    }

    public function updateAccount(AccountRequest $request)
    {
        $resultUpdateUser = $this->accountService->updateAccount($request);
        if ($resultUpdateUser) {
            return redirect()->back()->with(['status_succeed' => "Cập nhập tài khoản thành công"]);
        }
        return redirect()->back()->with(['status_failed' => "Cập nhập tài khoản thất bại"]);

    }

    public function myOrder(Request $request)
    {
        try {
            $orders = $this->orderService->getModel()::query()->where('user_id', Auth::user()->id);
            if ($request->order_search) {
                $orders->where('hash_order_id', $request->order_search);
            }
            $orders = $orders->paginate(15);

            $listOrder = view('frontend.account.components.list-order', compact('orders'))->render();
            return response()->json([
                'status' => 200,
                'html' => $listOrder,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 500,
                'data' => trans('messages.server_error'),
            ], 500);
        }
    }
}
