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
                <div class="col-xl-4 col-lg-6 col-md-12 m-auto">
                    <div class="login_wrap widget-taber-content background-white">
                        <div class="padding_eight_all bg-white">
                            <div class="heading_s1">
                                <img class="border-radius-15"
                                     src="{{asset('frontend/assets/imgs/page/forgot_password.svg')}}" alt=""/>
                                <h2 class="mb-15 mt-15">Forgot your password?</h2>
                                <p class="mb-30">Not to worry, we got you! Let’s get you a new password. Please enter
                                    your email address or your Username.</p>
                            </div>
                            <form action="{{route('user.doForgotPassword')}}" method="post">
                                @csrf
                                <div class="form-group">
                                    <input type="email" class="@error('email') is-invalid @enderror"
                                           name="email" placeholder="Email *"/>
                                    @error('email')
                                    <div class="text-danger mt-1">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <div class="login_footer form-group">
                                    <div class="chek-form">
                                        <input type="text" required="" name="security_code"
                                               placeholder="Security code *"/>
                                        @error('security_code')
                                        <div class="text-danger mt-1">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                    @php
                                        $securityCode = \App\Helpers\Common::generateCode();
                                    @endphp
                                    <input type="hidden" class=""
                                           name="security_code_generate" value="{{implode("",$securityCode)}}"
                                           placeholder="Username or Email *"/>
                                    <span class="security-code">
                                            <b class="text-new">{{$securityCode[0]}}</b>
                                            <b class="text-hot">{{$securityCode[1]}}</b>
                                            <b class="text-sale">{{$securityCode[2]}}</b>
                                            <b class="text-best">{{$securityCode[3]}}</b>
                                    </span>

                                </div>

                                <div class="form-group">
                                    <button type="submit" class="btn btn-heading btn-block hover-up" name="login">Reset
                                        password
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('addJs')
@endsection
