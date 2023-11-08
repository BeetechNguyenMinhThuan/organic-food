<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Services\Admin\BrandService;
use App\Services\Admin\CategoryService;
use App\Services\Admin\MenuService;
use App\Services\Admin\ProductService;
use App\Services\Admin\SliderService;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    public function __construct(BrandService $brandService, SliderService $sliderService, CategoryService $categoryService, ProductService $productService, MenuService $menuService)
    {
        $this->sliderService = $sliderService;
        $this->categoryService = $categoryService;
        $this->productService = $productService;
        $this->menuService = $menuService;
        $this->brandService = $brandService;
    }

    public function index()
    {
        $sliders = $this->sliderService->get();
        $categories = $this->categoryService->getParent();
        $menus = $this->menuService->getParent();
        $brands = $this->brandService->getPaginate();
        return view('frontend.brands.index', [
            'sliders' => $sliders,
            'categories' => $categories,
            'menus' => $menus,
            'brands' => $brands
        ]);
    }

    public function detail($slug)
    {
        $brand = $this->brandService->getModel()->where('slug', $slug)->first();
        $sliders = $this->sliderService->get();
        $categories = $this->categoryService->getParent();
        $menus = $this->menuService->getParent();
        $products = $brand->products()->paginate(15);
        return view('frontend.brands.detail', [
            'sliders' => $sliders,
            'categories' => $categories,
            'menus' => $menus,
            'brand' => $brand,
            'products' => $products
        ]);
    }
}
