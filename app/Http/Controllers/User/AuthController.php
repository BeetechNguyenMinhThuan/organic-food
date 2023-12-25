<?php

namespace App\Http\Controllers\User;

use App\Helpers\Common;
use App\Helpers\UploadHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\AccountRequest;
use App\Http\Requests\ForgotPasswordRequest;
use App\Jobs\SendMailUserForgotPassword;
use App\Models\User;
use App\Rules\MatchSecurityCode;
use App\Rules\UserEmailMatch;
use App\Services\CategoryService;
use App\Services\MenuService;
use App\Services\ProductService;
use App\Services\SliderService;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

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

    public function forgotPassword()
    {
        $sliders = $this->sliderService->get();
        $categories = $this->categoryService->getParent();
        $menus = $this->menuService->getParent();

        return view('frontend.auth.forgot-password', [
            'sliders' => $sliders,
            'categories' => $categories,
            'menus' => $menus,
        ]);
    }

    /**
     * Handle forgot password
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function doForgotPassword(Request $request)
    {
        DB::beginTransaction();
        try {
            $securityCode = $request->security_code_generate;

            $validator = Validator::make($request->all(), [
                'email' => ['email', 'required', new UserEmailMatch],
                'security_code' => ['required', new MatchSecurityCode($securityCode)],
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $user = User::query()->where('email', $request['email'])->first();
            if ($user) {
                $token = bin2hex(random_bytes(50));
                $user->update(['reset_password' => $token]);
                $dataMail = [
                    'user' => $user,
                    'view' => 'mails.users.reset-password',
                    'token' => $token,
                    'subject' => 'Reset Password'
                ];

                #Send Mail
                SendMailUserForgotPassword::dispatch($dataMail);
                DB::commit();
                return redirect()->back()->with('status_succeed', __("Success Send Mail Reset Password"));
            }
            throw new Exception;
        } catch
        (Exception $e) {
            DB::rollBack();
            Log::error("Message: {$e->getMessage()}. Line: {$e->getLine()}");
            return redirect()->back()->with('status_failed', trans('messages.server_error'));
        }
    }

    /**
     * Render reset password page
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
     */
    public function resetPassword()
    {
        $user_token = request()->input('token');
        $userResetPassword = User::query()->where('reset_password', $user_token)->first();
        if (!$userResetPassword) {
            return redirect()->route('user.login')->with('status_failed', trans('messages.server_error'));
        }
        if (Carbon::parse($userResetPassword->updated_at)->addHours(3)->isPast()) {
            $userResetPassword->update(['reset_password' => null]);
            return redirect()->route('user.login')->with('status_failed', "Link đã hết hạn");
        }
        $sliders = $this->sliderService->get();
        $categories = $this->categoryService->getParent();
        $menus = $this->menuService->getParent();

        return view('frontend.auth.reset-password', [
            'sliders' => $sliders,
            'categories' => $categories,
            'menus' => $menus,
        ]);
    }

    /**
     * Handle reset password
     *
     * @param ResetPasswordUserRequest $request
     *
     * @return RedirectResponse
     */
    public function doResetPassword(Request $request)
    {
        $request->validate(['password' => 'required|same:confirm_password']);

        $user_token = $request->input('token');
        $userResetPassword = User::query()->where('reset_password', $user_token)->first();
        if ($userResetPassword) {
            $userResetPassword?->update([
                'password' => bcrypt($request->input('password')),
                'reset_password' => null
            ]);
            return redirect()->route('user.login')->with('status_succeed', "Đổi mật khẩu thành công");
        }
        return redirect()->back()->with('status_failed', trans('messages.server_error'));
    }
}
