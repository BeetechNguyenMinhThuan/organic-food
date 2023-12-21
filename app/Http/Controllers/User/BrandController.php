<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Services\BrandService;
use App\Services\CategoryService;
use App\Services\MenuService;
use App\Services\ProductService;
use App\Services\SliderService;
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

    public function index(Request $request)
    {
        $sliders = $this->sliderService->get();
        $categories = $this->categoryService->getParent();
        $menus = $this->menuService->getParent();
        $brands = $this->brandService->getPaginate($request);
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
