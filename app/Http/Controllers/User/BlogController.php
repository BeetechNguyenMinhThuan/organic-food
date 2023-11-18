<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Services\BlogService;
use App\Services\CategoryService;
use App\Services\MenuService;
use App\Services\ProductService;
use App\Services\SliderService;

class BlogController extends Controller
{
    private $sliderService;
    private $categoryService;
    private $productService;
    private $menuService;
    private BlogService $blogService;

    public function __construct(BlogService $blogService, SliderService $sliderService, CategoryService $categoryService, ProductService $productService, MenuService $menuService)
    {
        $this->sliderService = $sliderService;
        $this->categoryService = $categoryService;
        $this->productService = $productService;
        $this->menuService = $menuService;
        $this->blogService = $blogService;
    }

    public function index()
    {
        $sliders = $this->sliderService->get();
        $categories = $this->categoryService->getParent();
        $menus = $this->menuService->getParent();
        $blogs = $this->blogService->getPaginate();
        return view('frontend.blogs.index', [
            'sliders' => $sliders,
            'categories' => $categories,
            'menus' => $menus,
            'blogs' => $blogs
        ]);
    }

    public function detail($slug)
    {
        $sliders = $this->sliderService->get();
        $categories = $this->categoryService->getParent();
        $menus = $this->menuService->getParent();
        $blog = $this->blogService->getModel()->where('slug', $slug)->first();
        $products = $this->productService->getRandom()->take(4);
        return view('frontend.blogs.detail', [
            'sliders' => $sliders,
            'categories' => $categories,
            'menus' => $menus,
            'blog' => $blog,
            'products' => $products
        ]);
    }
}
