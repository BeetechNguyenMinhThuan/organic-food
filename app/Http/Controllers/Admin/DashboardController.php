<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
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
use Illuminate\Http\Request;

class DashboardController extends Controller
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

    public function index()
    {
        $products = $this->productService->get();
        $orders = $this->orderService->get();
        $categories = $this->categoryService->get();
        $order = $this->orderService->getModel();
        $users = $this->userService->statisticsUser();
        $activityUsers = $this->userService->activityLogUser();
        return view('backend.dashboards.dashboard', [
            'products' => $products,
            'orders' => $orders,
            'categories' => $categories,
            'order' => $order,
            'users' => $users,
            'activityUsers' => $activityUsers
        ]);
    }
}
