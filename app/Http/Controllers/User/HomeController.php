<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Services\Admin\CategoryService;
use App\Services\Admin\MenuService;
use App\Services\Admin\ProductService;
use App\Services\Admin\SliderService;
use Illuminate\Http\Request;
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
}
