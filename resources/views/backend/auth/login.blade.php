@extends('backend.auth.master')
@section('content')
    <div class="row justify-content-center">
        <div class="col-lg-5">
            <div class="card">

                <!-- Logo -->
                <div class="card-header pt-4 pb-4 text-center bg-primary">
                    <a href="{{route('login')}}">
                        <span><img src="{{ asset('frontend/assets/imgs/home/logo-vip.png') }}" height="160px" alt="" ></span>
                    </a>
                </div>

                <div class="card-body p-4">

                    <div class="text-center w-75 m-auto">
                        <h4 class="text-dark-50 text-center mt-0 font-weight-bold">Sign In</h4>
                        <p class="text-muted mb-4">Enter your email address and password to access admin panel.</p>
                    </div>

                    <form action="{{route('doLogin')}}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="email">Email address</label>
                            <input class="form-control" type="email" name="email" id="email" required="" placeholder="Enter your email">
                        </div>

                        <div class="form-group">
                            <label for="password">Password</label>
                            <div class="input-group input-group-merge">
                                <input type="password" id="password" class="form-control" placeholder="Enter your password" name="password">
                                <div class="input-group-append" data-password="false">
                                    <div class="input-group-text">
                                        <span class="password-eye"></span>
                                    </div>
                                </div>
                            </div>
                            <a href="pages-recoverpw.html" class="text-muted float-right"><small>Forgot your password?</small></a>

                        </div>

                        <div class="form-group mb-3">
                            <div class="custom-control custom-checkbox">
                                <input name="remember_me" type="checkbox" class="custom-control-input" id="checkbox-signin">
                                <label class="custom-control-label" for="checkbox-signin">Remember me</label>
                            </div>
                        </div>

                        <div class="form-group mb-0 text-center">
                            <button class="btn btn-primary" type="submit"> Log In </button>
                        </div>

                    </form>
                </div> <!-- end card-body -->
            </div>
            <!-- end card -->

            <div class="row mt-3">
                <div class="col-12 text-center">
                    <p class="text-muted">Don't have an account? <a href="pages-register.html" class="text-muted ml-1"><b>Sign Up</b></a></p>
                </div> <!-- end col -->
            </div>
            <!-- end row -->

        </div> <!-- end col -->
    </div>
@endsection
