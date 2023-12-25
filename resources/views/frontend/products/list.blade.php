@extends('frontend.layouts.master')
@section('modal')
    {{--    @include('frontend.partials.modal-pre-load')--}}
@endsection
@section('content')
    <div class="page-header breadcrumb-wrap">
        <div class="container">
            <div class="breadcrumb">
                <a href="index.html" rel="nofollow"><i class="fi-rs-home mr-5"></i>Home</a>
                <span></span> <a href="shop-grid-right.html">Products</a> <span></span> {{ $categoryBySlug->name }}
            </div>
        </div>
    </div>
    <div class="container mb-30 mt-30">
        <div class="row">
            <div class="col-lg-12">
                <a class="shop-filter-toogle" href="#">
                    <span class="fi-rs-filter mr-5"></span>
                    {{trans('messages.filter.filter')}}
                    <i class="fi-rs-angle-small-down angle-down"></i>
                    <i class="fi-rs-angle-small-up angle-up"></i>
                </a>
                <div class="shop-product-fillter-header">
                    <a class="btn-reset" href="{{route('products.listProduct',['slug' => $categoryBySlug->slug])}}">
                        <i class="fa fa-refresh mr-5" aria-hidden="true"></i>
                        {{trans('messages.common.reset')}}

                    </a>
                    <div class="row">
                        <div class="col-xl-4 col-lg-6 col-md-6 mb-lg-0 mb-md-2 mb-sm-2">
                            <div class="card">
                                <h5 class="mb-30">{{trans('messages.header.all_categories')}}</h5>
                                <div class="categories-dropdown-wrap font-heading">
                                    <ul>
                                        @foreach($categories as $category)
                                            <li>
                                                <a href="{{route('products.listProduct',['slug'=>$category->slug])}}">
                                                    <img
                                                        src="{{asset('/storage/'.$category->avatar)}}"
                                                        alt=""/>{{$category->name}}</a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-4 col-lg-6 col-md-6 mb-lg-0 mb-md-2 mb-sm-2">
                            <div class="card">
                                <h5 class="mb-30">{{trans('messages.header.brands')}}</h5>
                                <div class="d-flex">
                                    <div class="custome-checkbox mr-80">
                                        @foreach($brands as $key => $brand)
                                            <input class="form-check-input filter-brand" type="checkbox" name="brand"
                                                   id="exampleCheckbox{{$key+1}}" value="{{$brand->id}}"/>
                                            <label class="form-check-label"
                                                   for="exampleCheckbox{{$key+1}}"><span>{{$brand->name}}</span></label>
                                        @endforeach

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-4 col-lg-6 col-md-6 mb-lg-0 mb-md-2 mb-sm-2">
                            <div class="card">
                                <h5 class="mb-30">{{trans('messages.filter.tags')}}</h5>
                                <div class="d-flex">
                                    <div class="custome-checkbox mr-80">
                                        @foreach($tags as $key => $tag)
                                            <input class="form-check-input filter-tag" type="checkbox" name="tags"
                                                   id="exampleTag{{$key+1}}" value="{{$tag->id}}"/>
                                            <label class="form-check-label"
                                                   for="exampleTag{{$key+1}}"><span>{{$tag->name}}</span></label>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 d-flex">
                            <div class="shop-product-fillter">
                                <div class="sort-by-product-area">
                                    <div class="sort-by-cover">
                                        <div class="sort-by-product-wrap">
                                            <div class="sort-by-dropdown-wrap">
                                                <span class="default-price"> {{ trans('messages.filter.price') }} </span><i
                                                    class="fi-rs-angle-small-down"></i>
                                            </div>
                                        </div>
                                        <div class="sort-by-dropdown">
                                            <ul>
                                                <li><a class="low-to-high-price order-price"
                                                       data-price="{{\App\Models\Product::ORDER_PRICE_LOW_TO_HIGH}}"
                                                       href="javascript:0">{{ trans('messages.common.low_to_high') }}</a>
                                                </li>
                                                <li><a class="high-to-low-price order-price"
                                                       data-price="{{\App\Models\Product::ORDER_PRICE_HIGH_TO_LOW}}"
                                                       href="javascript:0">{{ trans('messages.common.high_to_low') }}</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2 mb-50" style="margin-left: auto">
                                <button
                                    data-url="{{route('products.filterCategory',['categoryId' => $categoryBySlug->id])}}"
                                    class="btnFilterProduct btn w-100">{{trans('messages.filter.filter')}}
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="list-product-filter">
                    @include('frontend.products.components.list-product-filter')
                </div>
            </div>
        </div>
    </div>
@endsection
@section('addJs')
@endsection
