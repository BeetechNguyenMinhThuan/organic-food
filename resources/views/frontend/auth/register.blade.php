@extends('frontend.layouts.master')
@section('addCss')
    <style>
        .upload-avatar {
            margin: 10px 0;
        }

        #avatar {
            background-color: antiquewhite;
            height: 150px;
            width: 150px;
            border: 3px solid #3BB77E;
            border-radius: 50%;
            transition: background ease-out 200ms;
        }

        #preview {
            position: relative;
        }

        #image {
            display: none;
        }

        #preview #upload-button {
            padding: 11px;
            border-radius: 50%;
            border: none;
            cursor: pointer;
            background-color: #3BB77E;
            box-shadow: 0px 3px 5px -1px rgba(0, 0, 0, 0.2),
            0px 6px 10px 0px rgba(0, 0, 0, 0.14),
            0px 1px 18px 0px rgba(0, 0, 0, 0.12);
            transition: background-color ease-out 120ms;
            position: absolute;
            right: 72%;
            bottom: 0%;
        }

        #preview #upload-button:hover {
            background-color: rgba(61, 198, 134, 0.86);
        }
    </style>
@endsection
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
                <div class="col-xl-9 col-lg-10 col-md-12 m-auto">
                    <div class="row">
                        <div class="col-lg-6 col-md-12">
                            <div class="login_wrap widget-taber-content background-white">
                                <div class="padding_eight_all bg-white">
                                    <div class="heading_s1">
                                        <h1 class="mb-5">Create an Account</h1>
                                        <p class="mb-30">Already have an account? <a href="{{route('user.login')}}">Login</a>
                                        </p>
                                    </div>
                                    <form method="post" action="{{route('user.doRegister')}}"
                                          enctype="multipart/form-data">
                                        @csrf
                                        <div class="form-group">
                                            <label for="" class="font-weight-bold">First Name</label>
                                            <input type="text" required="" value="{{old('first_name')}}" name="first_name" placeholder="First name"/>
                                            @error('first_name')
                                            <div class="text-danger mt-1">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label for="" class="font-weight-bold">Last Name</label>
                                            <input type="text" required="" value="{{old('last_name')}}" name="last_name" placeholder="Last name"/>
                                            @error('last_name')
                                            <div class="text-danger mt-1">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="" class="font-weight-bold">Email</label>
                                            <input type="text" required="" value="{{old('email')}}" name="email" placeholder="Email"/>
                                            @error('email')
                                            <div class="text-danger mt-1">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="" class="font-weight-bold">Password</label>
                                            <input required="" type="password" name="password" placeholder="Password"/>
                                            @error('password')
                                            <div class="text-danger mt-1">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="" class="font-weight-bold">Confirm Password</label>
                                            <input required="" type="password" name="confirm_password"
                                                   placeholder="Confirm password"/>
                                            @error('confirm_password')
                                            <div class="text-danger mt-1">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                        <div class="form-group upload-avatar">
                                            <label for="" class="font-weight-bold">Upload Avatar</label>
                                            <input type="file" name="avatar" id="image" accept="image/*"/>
                                            <div id="preview">
                                                <div id="avatar"></div>
                                                <div
                                                    id="upload-button"
                                                    aria-labelledby="image"
                                                    aria-describedby="image"
                                                >
                                                    <svg xmlns="http://www.w3.org/2000/svg" color="white" width="20"
                                                         height="20" fill="currentColor" class="bi bi-upload"
                                                         viewBox="0 0 16 16">
                                                        <path
                                                            d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5z"/>
                                                        <path
                                                            d="M7.646 1.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1-.708.708L8.5 2.707V11.5a.5.5 0 0 1-1 0V2.707L5.354 4.854a.5.5 0 1 1-.708-.708l3-3z"/>
                                                    </svg>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="login_footer form-group mb-40 mt-50">
                                            <div class="chek-form">
                                                <div class="custome-checkbox">
                                                    <input class="form-check-input" type="checkbox" name="isReadTerm"
                                                           id="exampleCheckbox12" value="1"/>
                                                    <label class="form-check-label" for="exampleCheckbox12"><span>I agree to terms &amp; Policy.</span></label>
                                                    @error('isReadTerm')
                                                    <div class="text-danger mt-1">
                                                        {{ $message }}
                                                    </div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <a href="page-privacy-policy.html"><i
                                                    class="fi-rs-book-alt mr-5 text-muted"></i>Lean more</a>
                                        </div>
                                        <div class="form-group mb-30">
                                            <button type="submit"
                                                    class="btn btn-fill-out btn-block hover-up font-weight-bold"
                                            >Submit &amp; Register
                                            </button>
                                        </div>
                                        {{--                                        <p class="font-xs text-muted"><strong>Note:</strong>Your personal data will be--}}
                                        {{--                                            used to support your experience throughout this website, to manage access to--}}
                                        {{--                                            your account, and for other purposes described in our privacy policy</p>--}}
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 pl-30 d-none d-lg-block">
                            <img class="border-radius-15" src="{{asset('frontend/assets/imgs/auth/register2.png')}}"
                                 alt=""/>
                        </div>
                        {{--                        <div class="col-lg-6 pr-30 d-none d-lg-block">--}}
                        {{--                            <div class="card-login mt-115">--}}
                        {{--                                <a href="#" class="social-login facebook-login">--}}
                        {{--                                    <img src="assets/imgs/theme/icons/logo-facebook.svg" alt=""/>--}}
                        {{--                                    <span>Continue with Facebook</span>--}}
                        {{--                                </a>--}}
                        {{--                                <a href="#" class="social-login google-login">--}}
                        {{--                                    <img src="assets/imgs/theme/icons/logo-google.svg" alt=""/>--}}
                        {{--                                    <span>Continue with Google</span>--}}
                        {{--                                </a>--}}
                        {{--                                <a href="#" class="social-login apple-login">--}}
                        {{--                                    <img src="assets/imgs/theme/icons/logo-apple.svg" alt=""/>--}}
                        {{--                                    <span>Continue with Apple</span>--}}
                        {{--                                </a>--}}
                        {{--                            </div>--}}
                        {{--                        </div>--}}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('addJs')
    <script>
        const UPLOAD_BUTTON = document.getElementById("upload-button");
        const FILE_INPUT = document.querySelector("input[type=file]");
        const AVATAR = document.getElementById("avatar");

        UPLOAD_BUTTON.addEventListener("click", () => FILE_INPUT.click());

        FILE_INPUT.addEventListener("change", (event) => {
            const file = event.target.files[0];

            const reader = new FileReader();
            reader.readAsDataURL(file);

            reader.onloadend = () => {
                AVATAR.setAttribute("aria-label", file.name);
                AVATAR.style.background = `url(${reader.result}) center center/cover`;
            };
        });
    </script>
@endsection
