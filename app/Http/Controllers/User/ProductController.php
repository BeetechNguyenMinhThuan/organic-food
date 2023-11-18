<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Services\BrandService;
use App\Services\CategoryService;
use App\Services\MenuService;
use App\Services\ProductService;
use App\Services\SliderService;
use App\Services\TagService;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    private $productService;
    private $brandService;
    private $tagService;

    public function __construct(TagService $tagService, SliderService $sliderService, CategoryService $categoryService, ProductService $productService, MenuService $menuService, BrandService $brandService)
    {
        $this->sliderService = $sliderService;
        $this->categoryService = $categoryService;
        $this->productService = $productService;
        $this->menuService = $menuService;
        $this->tagService = $tagService;
        $this->brandService = $brandService;
    }

    public function detail($name)
    {
        $sliders = $this->sliderService->get();
        $categories = $this->categoryService->getParent();
        $menus = $this->menuService->getParent();
        $product = $this->productService->findItem('slug', $name);
        $productRelated = $this->productService->getProductRelated($product->id, $product->category->id);
        return view('frontend.products.detail', [
            'product' => $product,
            'sliders' => $sliders,
            'categories' => $categories,
            'menus' => $menus,
            'productRelated' => $productRelated
        ]);
    }

    public function listProduct($slug)
    {
        $sliders = $this->sliderService->get();
        $categories = $this->categoryService->getParent();
        $brands = $this->brandService->get();
        $tags = $this->tagService->getTags();
        $categoryBySlug = $this->categoryService->getModel()->where('slug', $slug)->firstOrFail();
        $products = $categoryBySlug->products()->paginate(10);
        $menus = $this->menuService->getParent();
        return view('frontend.products.list', [
            'sliders' => $sliders,
            'categories' => $categories,
            'menus' => $menus,
            'categoryBySlug' => $categoryBySlug,
            'brands' => $brands,
            'tags' => $tags,
            'products' => $products
        ]);
    }

    public function search(Request $request)
    {
        $sliders = $this->sliderService->get();
        $categories = $this->categoryService->getParent();
        $brands = $this->brandService->get();
        $tags = $this->tagService->getTags();
        $menus = $this->menuService->getParent();

        $products = [];
        if (!empty($request->search)) {
            $products = $this->productService->getModel()::query()
                ->where('name', 'LIKE', "%$request->search%");
        }
        if (!empty($request->category) && $request->category != 0) {
            $products = $products->where('category_id', $request->category);
        }
        $products = $products->paginate(10);

        return view('frontend.products.search', [
            'sliders' => $sliders,
            'categories' => $categories,
            'menus' => $menus,
            'brands' => $brands,
            'tags' => $tags,
            'products' => $products
        ]);
    }

    public function shop()
    {

    }

    public function createFavoriteProduct($productId)
    {
        return $this->productService->createFavoriteProduct($productId);
    }

    public function removeFavoriteProduct($productId)
    {
        return $this->productService->removeFavoriteProduct($productId);

    }

    public function checkFavoriteProduct($productId)
    {
        return $this->productService->checkFavoriteProduct($productId);
    }

    public function filterProductCategory(Request $request, $categoryId)
    {
        return $this->productService->filterProductCategory($request, $categoryId);
    }
}
