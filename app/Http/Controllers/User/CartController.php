<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Services\AccountService;
use App\Services\BrandService;
use App\Services\CartService;
use App\Services\CategoryService;
use App\Services\MenuService;
use App\Services\ProductService;
use App\Services\SliderService;
use App\Services\TagService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    private CartService $cartService;
    protected AccountService $accountService;
    private CategoryService $categoryService;
    protected ProductService $productService;
    protected MenuService $menuService;
    private SliderService $sliderService;
    protected TagService $tagService;
    private BrandService $brandService;

    public function __construct(AccountService $accountService, CartService $cartService, TagService $tagService, SliderService $sliderService, CategoryService $categoryService, ProductService $productService, MenuService $menuService, BrandService $brandService)
    {
        $this->sliderService = $sliderService;
        $this->categoryService = $categoryService;
        $this->productService = $productService;
        $this->menuService = $menuService;
        $this->tagService = $tagService;
        $this->brandService = $brandService;
        $this->cartService = $cartService;
        $this->accountService = $accountService;

    }


    /**
     * Display a listing of the resource.
     */
    public function addToCart(Request $request, $productId)
    {
        return $this->cartService->create($request, $productId);
    }

    public function showCart()
    {
        $sliders = $this->sliderService->get();
        $categories = $this->categoryService->getParent();
        $menus = $this->menuService->getParent();
        $carts = Session::get('carts');
        $cartShippingAddress = $this->accountService->getShippingAddressUser();

        return view("frontend.carts.show", [
            'sliders' => $sliders,
            'categories' => $categories,
            'menus' => $menus,
            'carts' => $carts,
            'cartShippingAddress' => $cartShippingAddress
        ]);
    }

    public function updateCart(Request $request)
    {
        return $this->cartService->updateCart($request);
    }

    public function deleteCart(Request $request)
    {
        return $this->cartService->deleteCart($request);
    }

    public function deleteAllCart()
    {
        $cartDeleteAll = $this->cartService->deleteAllCart();
        if ($cartDeleteAll) {
            return redirect()->route('cart.show')->with([
                'status_succeed' => trans('messages.cart.delete_all_product_cart_success')
            ]);
        }
    }


    public function checkoutCart(Request $request)
    {
        $cart = $this->cartService->checkoutCart($request);
        if ($cart) {
            return redirect()->route('cart.show')->with([
                'success' => trans('messages.cart.order_success')
            ]);
        }
    }
}
