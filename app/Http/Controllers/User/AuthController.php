<?php

namespace App\Http\Controllers\User;

use App\Helpers\UploadHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\AccountRequest;
use App\Models\User;
use App\Services\CategoryService;
use App\Services\MenuService;
use App\Services\ProductService;
use App\Services\SliderService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function __construct(SliderService $sliderService, CategoryService $categoryService, ProductService $productService, MenuService $menuService)
    {
        $this->sliderService = $sliderService;
        $this->categoryService = $categoryService;
        $this->productService = $productService;
        $this->menuService = $menuService;
    }

    public function login()
    {
        $sliders = $this->sliderService->get();
        $categories = $this->categoryService->getParent();
        $menus = $this->menuService->getParent();
        $products = $this->productService->get();
        if (Auth::check()) {
            return redirect()->route('home');
        }
        return view('frontend.auth.login', [
            'sliders' => $sliders,
            'categories' => $categories,
            'products' => $products,
            'menus' => $menus,
        ]);
    }

    public function register()
    {
        $sliders = $this->sliderService->get();
        $categories = $this->categoryService->getParent();
        $menus = $this->menuService->getParent();
        $products = $this->productService->get();
        if (Auth::check()) {
            return redirect()->route('frontend.home.index');
        }
        return view('frontend.auth.register', [
            'sliders' => $sliders,
            'categories' => $categories,
            'products' => $products,
            'menus' => $menus,
        ]);
    }

    public function doLogin(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);
        $rememberMe = $request->has('remember_me');
        if (Auth::attempt($credentials, $rememberMe)) {
            $request->session()->regenerate();
            return redirect()->route('home')->with('status_succeed', 'Đăng nhập thành công!');
        }

        return redirect()->route('user.login')->with('status_failed', 'Sai tài khoản hoặc mật khẩu, vui lòng kiểm tra lại!');

    }

    public function doRegister(AccountRequest $request)
    {

        $isReadTerm = $request->input('isReadTerm');
        // Tạo một bản ghi người dùng mới
        $user = new User();
        $user->first_name = $request->input('first_name');
        $user->last_name = $request->input('last_name');
        $user->email = $request->input('email');
        $user->password = bcrypt($request->input('password'));
        $user->save();
        if ($request->hasFile('avatar')) {
            $avatar = UploadHelper::handleUploadFile('avatar', "users/avatar/$user->id/", $request);
            if ($avatar) {
                $user->avatar = $avatar;
                $user->save();
            }
        }
        return redirect()->route('user.login')->with('status_succeed', 'Đăng ký thành công! Đăng nhập ngay.');
    }

    public function doLogout(Request $request)
    {
        Auth::logout();
        return redirect()->route('user.login');
    }
}
