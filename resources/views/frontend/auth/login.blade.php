@extends('frontend.layouts.master')
@section('modal')
    {{--    @include('frontend.partials.modal-pre-load')--}}
@endsection
@section('content')
    <div class="page-header breadcrumb-wrap">
        <div class="container">
            <div class="breadcrumb">
                <a href="index.html" rel="nofollow"><i class="fi-rs-home mr-5"></i>Home</a>
                <span></span> Pages <span></span> My Account
            </div>
        </div>
    </div>
    <div class="page-content pt-150 pb-150">
        <div class="container">
            <div class="row">
                <div class="col-xl-8 col-lg-10 col-md-12 m-auto">
                    <div class="row">
                        <div class="col-lg-6 pr-30 d-none d-lg-block">
                            <img class="border-radius-15" src="{{asset('frontend/assets/imgs/auth/login-1.png')}}"
                                 alt=""/>
                        </div>
                        <div class="col-lg-6 col-md-8">
                            <div class="login_wrap widget-taber-content background-white">
                                <div class="padding_eight_all bg-white">
                                    <div class="heading_s1">
                                        <h1 class="mb-5">{{trans('messages.auth.login')}}</h1>
                                        <p class="mb-30">{{trans('messages.auth.dont_have_account')}} <a
                                                    href="{{route('user.register')}}">{{trans('messages.auth.register_now')}}</a>
                                        </p>
                                    </div>
                                    <form method="post" action="{{route('user.doLogin')}}">
                                        @csrf
                                        <div class="form-group">
                                            <input type="text" required="" name="email"
                                                   placeholder="{{trans('messages.auth.your_email')}}*"/>
                                            @error('email')
                                            <div class="text-danger mt-1">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <input required="" type="password" name="password"
                                                   placeholder="{{trans('messages.auth.your_password')}} *"/>
                                            @error('password')
                                            <div class="text-danger mt-1">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>

                                        <div class="login_footer form-group mb-50">
                                            <div class="chek-form">
                                                <div class="custome-checkbox">
                                                    <input class="form-check-input" type="checkbox" name="remember_me"
                                                           id="exampleCheckbox1" value="1"/>
                                                    <label class="form-check-label" for="exampleCheckbox1"><span>{{trans('messages.auth.remember_me')}}</span></label>
                                                </div>
                                            </div>
                                            <a class="text-muted"
                                               href="{{route('user.forgotPassword')}}">{{trans('messages.auth.forgot_password')}}</a>
                                        </div>
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-heading btn-block hover-up"
                                                    name="login">{{trans('messages.auth.login')}}
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('addJs')
@endsection
