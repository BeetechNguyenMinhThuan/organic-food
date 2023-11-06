@extends('frontend.layouts.master')
@section('modal')
    {{--    @include('frontend.partials.modal-pre-load')--}}
@endsection
@section('content')
    <div class="page-header breadcrumb-wrap">
        <div class="container">
            <div class="breadcrumb">
                <a href="index.html" rel="nofollow"><i class="fi-rs-home mr-5"></i>Home</a>
                <span></span> Shop
                <span></span> Cart
            </div>
        </div>
    </div>
    <div class="container mt-50">
        <h1 class="heading-2 mb-10">Your Cart</h1>
    </div>
    @if(!empty($carts))
        <div class="container mb-80">
            <h1>Cho nay danh cho thanh toan va dia chi giao hang</h1>
        </div>
        @include("frontend.carts.components.cart-list")
    @else
        <div class="mb-60">
            <p class="text-center">Your cart is empty!</p>
        </div>
    @endif
@endsection
@section('addJs')
    <script src="{{asset('frontend/carts/carts.js')}}"></script>
@endsection
