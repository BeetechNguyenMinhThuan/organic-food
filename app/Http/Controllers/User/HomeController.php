<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Services\CategoryService;
use App\Services\MenuService;
use App\Services\ProductService;
use App\Services\SliderService;
use Illuminate\Support\Facades\Session;

class HomeController extends Controller
{
    private $sliderService;
    private $categoryService;
    private $productService;
    private $menuService;

    public function __construct(SliderService $sliderService, CategoryService $categoryService, ProductService $productService, MenuService $menuService)
    {
        $this->sliderService = $sliderService;
        $this->categoryService = $categoryService;
        $this->productService = $productService;
        $this->menuService = $menuService;
    }

    public function index()
    {
        $sliders = $this->sliderService->get();
        $categories = $this->categoryService->getParent();
        $menus = $this->menuService->getParent();
        $products = $this->productService->get();
        return view('frontend.home.index', [
            'sliders' => $sliders,
            'categories' => $categories,
            'products' => $products,
            'menus' => $menus,
        ]);
    }

    public function contact()
    {
        $sliders = $this->sliderService->get();
        $categories = $this->categoryService->getParent();
        $menus = $this->menuService->getParent();
        $products = $this->productService->get();
        return view('frontend.contact.index', [
            'sliders' => $sliders,
            'categories' => $categories,
            'products' => $products,
            'menus' => $menus
        ]);
    }

    public function changeLanguage($language){
        Session::put('website_language', $language);
        return redirect()->back();
    }

    public function wishlist(){
        $sliders = $this->sliderService->get();
        $categories = $this->categoryService->getParent();
        $menus = $this->menuService->getParent();
        $productsFavorite = $this->productService->getProductFavorite();;
        return view('frontend.wishlist.index', [
            'sliders' => $sliders,
            'categories' => $categories,
            'menus' => $menus,
            'productsFavorite' => $productsFavorite
        ]);
    }
}
