<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Services\Admin\BrandService;
use App\Services\Admin\CategoryService;
use App\Services\Admin\MenuService;
use App\Services\Admin\ProductService;
use App\Services\Admin\SliderService;
use App\Services\Admin\TagService;
use App\Services\CartService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    private CartService $cartService;

    public function __construct(CartService $cartService, TagService $tagService, SliderService $sliderService, CategoryService $categoryService, ProductService $productService, MenuService $menuService, BrandService $brandService)
    {
        $this->sliderService = $sliderService;
        $this->categoryService = $categoryService;
        $this->productService = $productService;
        $this->menuService = $menuService;
        $this->tagService = $tagService;
        $this->brandService = $brandService;
        $this->cartService = $cartService;

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
        $cartShippingAddress = $this->cartService->getShippingAddressUser();

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

    public function addShippingAddress(Request $request)
    {
        return $this->cartService->addShippingAddress($request);
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
