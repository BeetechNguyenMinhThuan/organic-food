<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use App\Services\AccountService;
use App\Services\BrandService;
use App\Services\CartService;
use App\Services\CategoryService;
use App\Services\MenuService;
use App\Services\OrderService;
use App\Services\ProductService;
use App\Services\SliderService;
use App\Services\TagService;
use App\Services\UserService;
use Carbon\Carbon;
use Carbon\Traits\Date;
use Illuminate\Http\Request;

class StatisticController extends Controller
{
    private CartService $cartService;
    protected AccountService $accountService;
    private CategoryService $categoryService;
    protected ProductService $productService;
    protected MenuService $menuService;
    private SliderService $sliderService;
    protected TagService $tagService;
    private BrandService $brandService;
    private OrderService $orderService;

    public function __construct(UserService $userService, OrderService $orderService, AccountService $accountService, CartService $cartService, TagService $tagService, SliderService $sliderService, CategoryService $categoryService, ProductService $productService, MenuService $menuService, BrandService $brandService)
    {
        $this->sliderService = $sliderService;
        $this->categoryService = $categoryService;
        $this->productService = $productService;
        $this->menuService = $menuService;
        $this->tagService = $tagService;
        $this->brandService = $brandService;
        $this->cartService = $cartService;
        $this->accountService = $accountService;
        $this->orderService = $orderService;
        $this->userService = $userService;

    }

    public function statisticProduct(Request $request)
    {
        $products = $this->productService->getProductSold($request);
        return view('backend.statistics.products.product', compact('products'));
    }

    public function showCustomer(Request $request)
    {
        $customerIds = Order::query()->select('user_id')
            ->join('order_details', 'orders.id', '=', 'order_details.order_id')
            ->where('order_details.product_id', $request->productId)
            ->pluck('user_id');
        $customers = User::query()
            ->whereIn('id', $customerIds)
            ->get();

        return response()->json($customers);
    }

    public function statisticOrder(Request $request)
    {
        $orders = $this->orderService->statisticOrder($request);
        $ordersRevenue = $this->orderService->statisticOrdersRevenue($request);
        $firstDayOfMonth = Carbon::now()->startOfMonth();

// Lấy ngày cuối cùng của tháng hiện tại
        $lastDayOfMonth = Carbon::now()->endOfMonth();

// Khởi tạo mảng để chứa tất cả các ngày trong tháng
        $allDaysInMonth = [];

// Tạo một vòng lặp để thêm từng ngày vào mảng
        for ($date = $firstDayOfMonth; $date->lte($lastDayOfMonth); $date->addDay()) {
            $allDaysInMonth[] = $date->format('d/m/Y'); // Copy ngày để tránh tham chiếu cùng một đối tượng
        }
        return view('backend.statistics.orders.order', compact('orders', 'ordersRevenue','allDaysInMonth'));

    }
}
