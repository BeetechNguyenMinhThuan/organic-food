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
        return view("frontend.carts.show", [
            'sliders' => $sliders,
            'categories' => $categories,
            'menus' => $menus,
            'carts' => $carts,
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
                'status_succeed' => trans('messages.delete_all_product_cart_success')
            ]);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}