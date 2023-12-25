@extends('frontend.layouts.master')
@section('modal')
    {{--    @include('frontend.partials.modal-pre-load')--}}
@endsection
@section('content')
    <div class="page-header breadcrumb-wrap">
        <div class="container">
            <div class="breadcrumb">
                <a href="index.html" rel="nofollow"><i class="fi-rs-home mr-5"></i>Home</a>
                <span></span> Vendors List
            </div>
        </div>
    </div>
    <div class="page-content pt-50">
        <div class="container">
            <div class="archive-header-2 text-center">
                <h1 class="display-2 mb-50">{{trans('messages.common.brand_list')}}</h1>
                <div class="row">
                    <div class="col-lg-5 mx-auto">
                        <div class="sidebar-widget-2 widget_search mb-50">
                            <div class="search-form">
                                <form action="" method="GET">
                                    <input name="search" type="text" placeholder="Search brands (by name or ID)..."/>
                                    <button type="submit"><i class="fi-rs-search"></i></button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mb-50">
                <div class="col-12 col-lg-8 mx-auto">
                    <div class="shop-product-fillter">
                        <div class="totall-product">
                            <p>We have <strong class="text-brand">{{!empty($brands) ? count($brands) : 0}}</strong>
                                vendors now</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row vendor-grid">
                @foreach($brands as $brand)
                    <div class="col-lg-3 col-md-6 col-12 col-sm-6">

                        <div class="vendor-wrap mb-40" style="height: calc(100% - 40px);">
                            <div class="vendor-img-action-wrap">
                                <div class="vendor-img">
                                    <a href="{{route('brands.detail',['slug' => $brand->slug])}}">
                                        <img class="default-img" src="{{asset('/storage/' . $brand->image)}}" alt=""/>
                                    </a>
                                </div>
                                <div class="product-badges product-badges-position product-badges-mrg">
                                    <span class="hot">Mall</span>
                                </div>
                            </div>
                            <div class="vendor-content-wrap">
                                <div class="d-flex justify-content-between align-items-end mb-30">
                                    <div>
                                        <h4 class="mb-5"><a
                                                href="{{route('brands.detail',['slug' => $brand->slug])}}">{{$brand->name}}</a>
                                        </h4>
                                        <div class="product-rate-cover">
                                            <div class="product-rate d-inline-block">
                                                <div class="product-rating" style="width: 90%"></div>
                                            </div>
                                            <span class="font-small ml-5 text-muted"> (4.0)</span>
                                        </div>
                                    </div>
                                    <div class="mb-10">
                                        <span
                                            class="font-small total-product">{{$brand->products()->count()}} products</span>
                                    </div>
                                </div>
                                <div class="vendor-info mb-30">
                                    <ul class="contact-infor text-muted">
                                        <li><img src="assets/imgs/theme/icons/icon-location.svg"
                                                 alt=""/><strong>Address: </strong> <span>{{$brand->address}}</span>
                                        </li>
                                        <li><img src="assets/imgs/theme/icons/icon-contact.svg" alt=""/><strong>Call
                                                Us:</strong><span>{{$brand->phone}}</span></li>
                                    </ul>
                                </div>
                                <a href="vendor-details-1.html" class="btn btn-xs">Visit Store <i
                                        class="fi-rs-arrow-small-right"></i></a>
                            </div>
                        </div>
                    </div>
                @endforeach


            </div>
            <div class="pagination-area mt-20 mb-20">
                {!! $brands->links('vendor.pagination.default') !!}
            </div>
        </div>
    </div>
@endsection
@section('addJs')
    <script src="{{asset('frontend/carts/carts.js')}}"></script>
@endsection
