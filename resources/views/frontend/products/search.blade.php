@extends('frontend.layouts.master')
@section('modal')
    {{--    @include('frontend.partials.modal-pre-load')--}}
@endsection
@section('content')
    <div class="page-header breadcrumb-wrap">
        <div class="container">
            <div class="breadcrumb">
                <a href="index.html" rel="nofollow"><i class="fi-rs-home mr-5"></i>Home</a>
                <span></span> <a href="shop-grid-right.html">Products</a> <span></span> Search
            </div>
        </div>
    </div>
    <div class="container mb-30 mt-30">
        <div class="row">
            <div class="col-lg-12">
                <a class="shop-filter-toogle" href="#">
                    <span class="fi-rs-filter mr-5"></span>
                    Filters
                    <i class="fi-rs-angle-small-down angle-down"></i>
                    <i class="fi-rs-angle-small-up angle-up"></i>
                </a>
                <div class="shop-product-fillter-header">
                    <div class="row">
                        <div class="col-xl-3 col-lg-6 col-md-6 mb-lg-0 mb-md-2 mb-sm-2">
                            <div class="card">
                                <h5 class="mb-30">By Categories</h5>
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
                        <div class="col-xl-3 col-lg-6 col-md-6 mb-lg-0 mb-md-2 mb-sm-2">
                            <div class="card">
                                <h5 class="mb-30">By Brands</h5>
                                <div class="d-flex">
                                    <div class="custome-checkbox mr-80">
                                        @foreach($brands as $key => $brand)
                                            <input class="form-check-input" type="checkbox" name="brand"
                                                   id="exampleCheckbox{{$key+1}}" value=""/>
                                            <label class="form-check-label"
                                                   for="exampleCheckbox{{$key+1}}"><span>{{$brand->name}}</span></label>
                                        @endforeach

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-lg-6 col-md-6 mb-lg-0 mb-md-2 mb-sm-2">
                            <div class="card">
                                <h5 class="mb-30">By Tags</h5>
                                <div class="d-flex">
                                    <div class="custome-checkbox mr-80">
                                        @foreach($tags as $key => $tag)
                                            <input class="form-check-input" type="checkbox" name="tags"
                                                   id="exampleTag{{$key+1}}" value=""/>
                                            <label class="form-check-label"
                                                   for="exampleTag{{$key+1}}"><span>{{$tag->name}}</span></label>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-lg-6 col-md-6 mb-lg-0 mb-md-5 mb-sm-5">
                            <div class="card">
                                <h5 class="mb-10">By Price</h5>
                                <div class="sidebar-widget price_range range">
                                    <div class="price-filter mb-20">
                                        <div class="price-filter-inner">
                                            <div id="slider-range" class="mb-20"></div>
                                            <div class="d-flex justify-content-between">
                                                <div class="caption">From: <strong id="slider-range-value1"
                                                                                   class="text-brand"></strong></div>
                                                <div class="caption">To: <strong id="slider-range-value2"
                                                                                 class="text-brand"></strong></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="custome-checkbox">
                                        <input class="form-check-input" type="checkbox" name="checkbox"
                                               id="exampleCheckbox211" value=""/>
                                        <label class="form-check-label"
                                               for="exampleCheckbox211"><span>$0.00 - $20.00 </span></label>
                                        <br/>
                                        <input class="form-check-input" type="checkbox" name="checkbox"
                                               id="exampleCheckbox22" value=""/>
                                        <label class="form-check-label"
                                               for="exampleCheckbox22"><span>$20.00 - $40.00 </span></label>
                                        <br/>
                                        <input class="form-check-input" type="checkbox" name="checkbox"
                                               id="exampleCheckbox23" value=""/>
                                        <label class="form-check-label"
                                               for="exampleCheckbox23"><span>$40.00 - $60.00 </span></label>
                                        <br/>
                                        <input class="form-check-input" type="checkbox" name="checkbox"
                                               id="exampleCheckbox24" value=""/>
                                        <label class="form-check-label"
                                               for="exampleCheckbox24"><span>$60.00 - $80.00 </span></label>
                                        <br/>
                                        <input class="form-check-input" type="checkbox" name="checkbox"
                                               id="exampleCheckbox25" value=""/>
                                        <label class="form-check-label"
                                               for="exampleCheckbox25"><span>Over $100.00</span></label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="shop-product-fillter">
                    <div class="totall-product">
                        <p>We found <strong class="text-brand">{{count($products)}}</strong> items
                            for you!</p>
                    </div>
                    <div class="sort-by-product-area">
                        <div class="sort-by-cover mr-10">
                            <div class="sort-by-product-wrap">
                                <div class="sort-by">
                                    <span><i class="fi-rs-apps"></i>Show:</span>
                                </div>
                                <div class="sort-by-dropdown-wrap">
                                    <span> 50 <i class="fi-rs-angle-small-down"></i></span>
                                </div>
                            </div>
                            <div class="sort-by-dropdown">
                                <ul>
                                    <li><a class="active" href="#">50</a></li>
                                    <li><a href="#">100</a></li>
                                    <li><a href="#">150</a></li>
                                    <li><a href="#">200</a></li>
                                    <li><a href="#">All</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="sort-by-cover">
                            <div class="sort-by-product-wrap">
                                <div class="sort-by">
                                    <span><i class="fi-rs-apps-sort"></i>Sort by:</span>
                                </div>
                                <div class="sort-by-dropdown-wrap">
                                    <span> Featured <i class="fi-rs-angle-small-down"></i></span>
                                </div>
                            </div>
                            <div class="sort-by-dropdown">
                                <ul>
                                    <li><a class="active" href="#">Featured</a></li>
                                    <li><a href="#">Price: Low to High</a></li>
                                    <li><a href="#">Price: High to Low</a></li>
                                    <li><a href="#">Release Date</a></li>
                                    <li><a href="#">Avg. Rating</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row product-grid">
                    @if(!empty($products))
                        @foreach($products as $key => $product)
                            <div class="col-lg-1-5 col-md-4 col-12 col-sm-6">
                                <div class="product-cart-wrap mb-30">
                                    <div class="product-img-action-wrap">
                                        <div class="product-img product-img-zoom">
                                            <a href="{{route('products.detail',$product->slug)}}">
                                                <img class="default-img"
                                                     src="{{\App\Helpers\Common::getImage($product->avatar)}}"
                                                     alt=""/>
                                            </a>
                                        </div>
                                        <div class="product-action-1">
                                            <a aria-label="Quick view" class="action-btn small hover-up"
                                               data-bs-toggle="modal" data-bs-target="#quickViewModal{{$key}}"> <i
                                                    class="fi-rs-eye"></i></a>
                                            <a aria-label="Add To Wishlist" class="action-btn small hover-up"
                                               href="shop-wishlist.html"><i class="fi-rs-heart"></i></a>
                                            <a aria-label="Compare" class="action-btn small hover-up"
                                               href="shop-compare.html"><i class="fi-rs-shuffle"></i></a>
                                        </div>
                                        <div class="product-badges product-badges-position product-badges-mrg">
                                            <span class="hot">Save 15%</span>
                                        </div>
                                    </div>
                                    <div class="product-content-wrap">
                                        <div class="product-category">
                                            <a href="shop-grid-right.html">{{optional($product->category)->name}}</a>
                                        </div>
                                        <h2><a href="{{route('products.detail',$product->slug)}}">{{$product->name}}</a>
                                        </h2>
                                        <div class="product-rate d-inline-block">
                                            <div class="product-rating" style="width: 80%"></div>
                                        </div>
                                        <div class="product-price mt-10 mb-10">
                                            <span>{{number_format($product->sale_price)}} VNĐ</span>
                                            <span class="old-price">{{number_format($product->price)}} VNĐ</span>
                                        </div>
                                        <a href="shop-cart.html" class="btn w-100 hover-up"><i
                                                class="fi-rs-shopping-cart mr-5"></i>Add To Cart</a>
                                    </div>
                                </div>
                                @include('frontend.products.modal-quick-view',['item'=>$product,'key'=>$key])
                            </div>
                        @endforeach

                        <!--end product card-->

                </div>
                <!--product grid-->
                <div class="pagination-area mt-20 mb-20">
                    {!! $products->links('vendor.pagination.default') !!}
                </div>
                @endif
            </div>
        </div>
    </div>
@endsection
@section('addJs')
@endsection
