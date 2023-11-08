@extends('frontend.layouts.master')
@section('modal')
{{--    @include('frontend.partials.modal-pre-load')--}}
@endsection
@section('content')
    @include('frontend.home.components.slider')
    @include('frontend.home.components.popular-categories')
    @include('frontend.home.components.banner')
    @include('frontend.home.components.product-tabs')
    @include('frontend.home.components.best-sales')
{{--    @include('frontend.home.components.deals')--}}
    @include('frontend.home.components.featured')
@endsection
@section('addJs')
    <script src="{{asset('frontend/home/home.js')}}"></script>
@endsection
