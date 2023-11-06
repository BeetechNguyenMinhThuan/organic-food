@extends('frontend.layouts.master')
@section('modal')
    {{--    @include('frontend.partials.modal-pre-load')--}}
@endsection
@section('content')
    <div class="page-header breadcrumb-wrap">
        <div class="container">
            <div class="breadcrumb">
                <a href="index.html" rel="nofollow"><i class="fi-rs-home mr-5"></i>Home</a>
                <span></span> <a href="shop-grid-right.html">Vegetables & tubers</a> <span></span> Seeds of Change
                Organic
            </div>
        </div>
    </div>
    <div class="container mb-30">
        <div class="row">
            <div class="col-xl-11 col-lg-12 m-auto">
                <div class="row">
                    <div class="col-xl-9">
                        <div class="product-detail accordion-detail">
                            <div class="row mb-50 mt-30">
                                <div class="col-md-6 col-sm-12 col-xs-12 mb-md-0 mb-sm-5">
                                    <div class="detail-gallery">
                                        <span class="zoom-icon"><i class="fi-rs-search"></i></span>
                                        <!-- MAIN SLIDES -->
                                        <div class="product-image-slider">
                                            <figure class="border-radius-10">
                                                <img src="{{asset('/storage/'.$product->avatar)}}"
                                                     alt="product image"/>
                                            </figure>
                                            @foreach($product->images as $image)
                                                <figure class="border-radius-10">
                                                    <img src="{{asset('/storage/'.$image->image_path)}}"
                                                         alt="product image"/>
                                                </figure>
                                            @endforeach

                                        </div>
                                        <!-- THUMBNAILS -->
                                        <div class="slider-nav-thumbnails">
                                            <div>
                                                <img height="100px" width="250px"
                                                     src="{{asset('/storage/'.$product->avatar)}}"
                                                     alt="product image"/>
                                            </div>
                                            @foreach($product->images as $image)
                                                <div>
                                                    <img height="100px" width="250px"
                                                         src="{{asset('/storage/'.$image->image_path)}}"
                                                         alt="product image"/>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                    <!-- End Gallery -->
                                </div>
                                <div class="col-md-6 col-sm-12 col-xs-12">
                                    <div class="detail-info pr-30 pl-30">
                                        <span class="stock-status out-stock"> Sale Off </span>
                                        <h2 class="title-detail">{{$product->name}}</h2>
                                        <div class="product-detail-rating">
                                            <div class="product-rate-cover text-end">
                                                <div class="product-rate d-inline-block">
                                                    <div class="product-rating" style="width: 90%"></div>
                                                </div>
                                                <span class="font-small ml-5 text-muted"> (32 reviews)</span>
                                            </div>
                                        </div>
                                        <div class="clearfix product-price-cover">
                                            <div class="product-price primary-color float-left">
                                                <span
                                                    class="current-price text-brand">{!! $product->getPrice() !!}</span>
                                                <span>
                                                        <span class="save-price font-md color3 ml-15">26% Off</span>
                                                        <span class="old-price font-md ml-15">$52</span>
                                                    </span>
                                            </div>
                                        </div>
                                        <div class="short-desc mb-30">
                                            <p class="font-lg">{!! $product->description !!}</p>
                                        </div>
                                        <div class="detail-extralink mb-50">
                                            <form action="{{ route('cart.add',['productId'=>$product->id])}}"
                                                  method="GET" class="d-flex">
                                                <div class="detail-qty border radius">
                                                    <a href="#" class="qty-down"><i class="fi-rs-angle-small-down"></i></a>
                                                    <input type="text" name="quantity" class="qty-val" value="1"
                                                           min="1">
                                                    <a href="#" class="qty-up"><i class="fi-rs-angle-small-up"></i></a>
                                                </div>
                                                <div class="product-extra-link2">
                                                    <button
                                                        data-url="{{ route('cart.add',['productId'=>$product->id])}}"
                                                        type="submit" class="button button-add-to-cart"><i
                                                            class="fi-rs-shopping-cart"></i>Add to cart
                                                    </button>
                                                    <a aria-label="Add To Wishlist" class="action-btn hover-up"
                                                       href="shop-wishlist.html"><i class="fi-rs-heart"></i></a>
                                                    <a aria-label="Compare" class="action-btn hover-up"
                                                       href="shop-compare.html"><i class="fi-rs-shuffle"></i></a>
                                                </div>
                                            </form>
                                        </div>
                                        <div class="font-xs">
                                            <ul class="float-start">
                                                <li class="mb-5">SKU: <a href="#">{{$product->sku}}</a></li>
                                                <li class="mb-5">Tags:
                                                    @foreach($product->tags as $tag)
                                                        <a href="#" rel="tag">{{$tag->name}}</a>,
                                                    @endforeach
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <!-- Detail Info -->
                                </div>
                            </div>
                            <div class="product-info">
                                <div class="tab-style3">
                                    <ul class="nav nav-tabs text-uppercase">
                                        <li class="nav-item">
                                            <a class="nav-link active" id="Description-tab" data-bs-toggle="tab"
                                               href="#Description">Description</a>
                                        </li>
                                        @if($product->brand)
                                            <li class="nav-item">
                                                <a class="nav-link" id="Vendor-info-tab" data-bs-toggle="tab"
                                                   href="#Vendor-info">Brand</a>
                                            </li>
                                        @endif

                                        <li class="nav-item">
                                            <a class="nav-link" id="Reviews-tab" data-bs-toggle="tab" href="#Reviews">Reviews
                                                (3)</a>
                                        </li>
                                    </ul>
                                    <div class="tab-content shop_info_tab entry-main-content">
                                        <div class="tab-pane fade show active" id="Description">
                                            <div class="">
                                                {!! $product->description !!}
                                            </div>
                                        </div>
                                        @if($product->brand)
                                            <div class="tab-pane fade" id="Vendor-info">
                                                <div class="vendor-logo d-flex mb-30">
                                                    <img src="{{asset('/storage/'. optional($product->brand)->image)}}"
                                                         alt=""/>
                                                    <div class="vendor-name ml-15">
                                                        <h6>
                                                            <a href="vendor-details-2.html">{{optional(optional($product->brand))->name}}</a>
                                                        </h6>
                                                        <div class="product-rate-cover text-end">
                                                            <div class="product-rate d-inline-block">
                                                                <div class="product-rating" style="width: 90%"></div>
                                                            </div>
                                                            <span
                                                                class="font-small ml-5 text-muted"> (32 reviews)</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <ul class="contact-infor mb-50">
                                                    <li><img src="assets/imgs/theme/icons/icon-location.svg"
                                                             alt=""/><strong>Address: </strong>
                                                        <span>{{optional($product->brand)->address}}</span>
                                                    </li>
                                                    <li><img src="assets/imgs/theme/icons/icon-contact.svg"
                                                             alt=""/><strong>Contact
                                                            Seller:</strong><span>{{optional($product->brand)->phone}}</span>
                                                    </li>
                                                </ul>

                                                <p>{{optional($product->brand)->description}}</p>
                                            </div>
                                        @endif
                                        <div class="tab-pane fade" id="Reviews">
                                            <!--Comments-->
                                            <div class="comments-area">
                                                <div class="row">
                                                    <div class="col-lg-8">
                                                        <h4 class="mb-30">Customer questions & answers</h4>
                                                        <div class="comment-list">
                                                            <div
                                                                class="single-comment justify-content-between d-flex mb-30">
                                                                <div class="user justify-content-between d-flex">
                                                                    <div class="thumb text-center">
                                                                        <img src="assets/imgs/blog/author-2.png"
                                                                             alt=""/>
                                                                        <a href="#" class="font-heading text-brand">Sienna</a>
                                                                    </div>
                                                                    <div class="desc">
                                                                        <div
                                                                            class="d-flex justify-content-between mb-10">
                                                                            <div class="d-flex align-items-center">
                                                                                <span class="font-xs text-muted">December 4, 2022 at 3:12 pm </span>
                                                                            </div>
                                                                            <div class="product-rate d-inline-block">
                                                                                <div class="product-rating"
                                                                                     style="width: 100%"></div>
                                                                            </div>
                                                                        </div>
                                                                        <p class="mb-10">Lorem ipsum dolor sit amet,
                                                                            consectetur adipisicing elit. Delectus,
                                                                            suscipit exercitationem accusantium
                                                                            obcaecati quos voluptate nesciunt facilis
                                                                            itaque modi commodi dignissimos sequi
                                                                            repudiandae minus ab deleniti totam officia
                                                                            id incidunt? <a href="#"
                                                                                            class="reply">Reply</a></p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div
                                                                class="single-comment justify-content-between d-flex mb-30 ml-30">
                                                                <div class="user justify-content-between d-flex">
                                                                    <div class="thumb text-center">
                                                                        <img src="assets/imgs/blog/author-3.png"
                                                                             alt=""/>
                                                                        <a href="#" class="font-heading text-brand">Brenna</a>
                                                                    </div>
                                                                    <div class="desc">
                                                                        <div
                                                                            class="d-flex justify-content-between mb-10">
                                                                            <div class="d-flex align-items-center">
                                                                                <span class="font-xs text-muted">December 4, 2022 at 3:12 pm </span>
                                                                            </div>
                                                                            <div class="product-rate d-inline-block">
                                                                                <div class="product-rating"
                                                                                     style="width: 80%"></div>
                                                                            </div>
                                                                        </div>
                                                                        <p class="mb-10">Lorem ipsum dolor sit amet,
                                                                            consectetur adipisicing elit. Delectus,
                                                                            suscipit exercitationem accusantium
                                                                            obcaecati quos voluptate nesciunt facilis
                                                                            itaque modi commodi dignissimos sequi
                                                                            repudiandae minus ab deleniti totam officia
                                                                            id incidunt? <a href="#"
                                                                                            class="reply">Reply</a></p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="single-comment justify-content-between d-flex">
                                                                <div class="user justify-content-between d-flex">
                                                                    <div class="thumb text-center">
                                                                        <img src="assets/imgs/blog/author-4.png"
                                                                             alt=""/>
                                                                        <a href="#" class="font-heading text-brand">Gemma</a>
                                                                    </div>
                                                                    <div class="desc">
                                                                        <div
                                                                            class="d-flex justify-content-between mb-10">
                                                                            <div class="d-flex align-items-center">
                                                                                <span class="font-xs text-muted">December 4, 2022 at 3:12 pm </span>
                                                                            </div>
                                                                            <div class="product-rate d-inline-block">
                                                                                <div class="product-rating"
                                                                                     style="width: 80%"></div>
                                                                            </div>
                                                                        </div>
                                                                        <p class="mb-10">Lorem ipsum dolor sit amet,
                                                                            consectetur adipisicing elit. Delectus,
                                                                            suscipit exercitationem accusantium
                                                                            obcaecati quos voluptate nesciunt facilis
                                                                            itaque modi commodi dignissimos sequi
                                                                            repudiandae minus ab deleniti totam officia
                                                                            id incidunt? <a href="#"
                                                                                            class="reply">Reply</a></p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <h4 class="mb-30">Customer reviews</h4>
                                                        <div class="d-flex mb-30">
                                                            <div class="product-rate d-inline-block mr-15">
                                                                <div class="product-rating" style="width: 90%"></div>
                                                            </div>
                                                            <h6>4.8 out of 5</h6>
                                                        </div>
                                                        <div class="progress">
                                                            <span>5 star</span>
                                                            <div class="progress-bar" role="progressbar"
                                                                 style="width: 50%" aria-valuenow="50" aria-valuemin="0"
                                                                 aria-valuemax="100">50%
                                                            </div>
                                                        </div>
                                                        <div class="progress">
                                                            <span>4 star</span>
                                                            <div class="progress-bar" role="progressbar"
                                                                 style="width: 25%" aria-valuenow="25" aria-valuemin="0"
                                                                 aria-valuemax="100">25%
                                                            </div>
                                                        </div>
                                                        <div class="progress">
                                                            <span>3 star</span>
                                                            <div class="progress-bar" role="progressbar"
                                                                 style="width: 45%" aria-valuenow="45" aria-valuemin="0"
                                                                 aria-valuemax="100">45%
                                                            </div>
                                                        </div>
                                                        <div class="progress">
                                                            <span>2 star</span>
                                                            <div class="progress-bar" role="progressbar"
                                                                 style="width: 65%" aria-valuenow="65" aria-valuemin="0"
                                                                 aria-valuemax="100">65%
                                                            </div>
                                                        </div>
                                                        <div class="progress mb-30">
                                                            <span>1 star</span>
                                                            <div class="progress-bar" role="progressbar"
                                                                 style="width: 85%" aria-valuenow="85" aria-valuemin="0"
                                                                 aria-valuemax="100">85%
                                                            </div>
                                                        </div>
                                                        <a href="#" class="font-xs text-muted">How are ratings
                                                            calculated?</a>
                                                    </div>
                                                </div>
                                            </div>
                                            <!--comment form-->
                                            <div class="comment-form">
                                                <h4 class="mb-15">Add a review</h4>
                                                <div class="product-rate d-inline-block mb-30"></div>
                                                <div class="row">
                                                    <div class="col-lg-8 col-md-12">
                                                        <form class="form-contact comment_form" action="#"
                                                              id="commentForm">
                                                            <div class="row">
                                                                <div class="col-12">
                                                                    <div class="form-group">
                                                                        <textarea class="form-control w-100"
                                                                                  name="comment" id="comment" cols="30"
                                                                                  rows="9"
                                                                                  placeholder="Write Comment"></textarea>
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-6">
                                                                    <div class="form-group">
                                                                        <input class="form-control" name="name"
                                                                               id="name" type="text"
                                                                               placeholder="Name"/>
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-6">
                                                                    <div class="form-group">
                                                                        <input class="form-control" name="email"
                                                                               id="email" type="email"
                                                                               placeholder="Email"/>
                                                                    </div>
                                                                </div>
                                                                <div class="col-12">
                                                                    <div class="form-group">
                                                                        <input class="form-control" name="website"
                                                                               id="website" type="text"
                                                                               placeholder="Website"/>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <button type="submit" class="button button-contactForm">
                                                                    Submit Review
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
                            <div class="row mt-60">
                                <div class="col-12">
                                    <h2 class="section-title style-1 mb-30">Related products</h2>
                                </div>
                                <div class="col-12">
                                    <div class="row related-products">
                                        @foreach($productRelated as $key => $item)
                                            <div class="col-lg-3 col-md-4 col-12 col-sm-6">
                                                <div class="product-cart-wrap hover-up">
                                                    <div class="product-img-action-wrap">
                                                        <div class="product-img product-img-zoom">
                                                            <a href="{{route('products.detail',$item->slug)}}"
                                                               tabindex="0">
                                                                <img width="300px" height="200px" class="default-img"
                                                                     src="{{asset('/storage/'.$item->avatar)}}" alt=""/>
                                                            </a>
                                                        </div>
                                                        <div class="product-action-1">
                                                            <a aria-label="Quick view" class="action-btn small hover-up"
                                                               data-bs-toggle="modal"
                                                               data-bs-target="#quickViewModal{{$key}}"><i
                                                                    class="fi-rs-search"></i></a>
                                                            <a aria-label="Add To Wishlist"
                                                               class="action-btn small hover-up"
                                                               href="shop-wishlist.html"
                                                               tabindex="0"><i class="fi-rs-heart"></i></a>
                                                            <a aria-label="Compare" class="action-btn small hover-up"
                                                               href="shop-compare.html" tabindex="0"><i
                                                                    class="fi-rs-shuffle"></i></a>
                                                        </div>
                                                        <div
                                                            class="product-badges product-badges-position product-badges-mrg">
                                                            <span class="hot">Hot</span>
                                                        </div>
                                                    </div>
                                                    <div class="product-content-wrap">
                                                        <h2><a href="{{route('products.detail',$item->slug)}}"
                                                               tabindex="0">{{$item->name}}</a></h2>
                                                        <div class="rating-result" title="90%">
                                                            <span> </span>
                                                        </div>
                                                        <div class="product-price">
                                                            <span>$238.85 </span>
                                                            <span class="old-price">{!! $item->getPrice() !!}</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            @include('frontend.products.modal-quick-view',['item' =>$item,'key' =>$key])

                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 primary-sidebar sticky-sidebar mt-30">
                        @if($product->brand)
                            <div class="sidebar-widget widget-vendor mb-30 bg-grey-9 box-shadow-none">
                                <h5 class="section-title style-3 mb-20">Brand</h5>
                                <div class="vendor-logo d-flex mb-30">
                                    <img src="{{asset('/storage/'. optional($product->brand)->image)}}" alt=""/>
                                    <div class="vendor-name ml-15">
                                        <h6>
                                            <a href="vendor-details-2.html">{{optional($product->brand)->name}}</a>
                                        </h6>
                                    </div>
                                </div>
                                <ul>
                                    <li class="hr"><span></span></li>
                                </ul>
                                <div class="brand-content">
                                    {!! optional($product->brand)->description !!}
                                </div>
                            </div>

                        @endif
                        <div class="sidebar-widget widget-category-2 mb-30">
                            <h5 class="section-title style-1 mb-30">Category</h5>
                            <ul>
                                @foreach($categories as $category)
                                    <li>
                                        <a href="{{route('products.listProduct',['slug'=>$category->slug])}}"> <img
                                                src="{{asset('/storage/'.$category->avatar)}}"
                                                alt=""/>{{$category->name}}</a><span
                                            class="count">{{$category->products()->count()}}</span>
                                    </li>
                                @endforeach

                            </ul>
                        </div>
                        <!-- Fillter By Price -->
                        <div class="sidebar-widget price_range range mb-30">
                            <h5 class="section-title style-1 mb-30">Fill by price</h5>
                            <div class="price-filter">
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
                            <div class="list-group">
                                <div class="list-group-item mb-10 mt-10">
                                    <label class="fw-900">Color</label>
                                    <div class="custome-checkbox">
                                        <input class="form-check-input" type="checkbox" name="checkbox"
                                               id="exampleCheckbox1" value=""/>
                                        <label class="form-check-label"
                                               for="exampleCheckbox1"><span>Red (56)</span></label>
                                        <br/>
                                        <input class="form-check-input" type="checkbox" name="checkbox"
                                               id="exampleCheckbox2" value=""/>
                                        <label class="form-check-label"
                                               for="exampleCheckbox2"><span>Green (78)</span></label>
                                        <br/>
                                        <input class="form-check-input" type="checkbox" name="checkbox"
                                               id="exampleCheckbox3" value=""/>
                                        <label class="form-check-label"
                                               for="exampleCheckbox3"><span>Blue (54)</span></label>
                                    </div>
                                    <label class="fw-900 mt-15">Item Condition</label>
                                    <div class="custome-checkbox">
                                        <input class="form-check-input" type="checkbox" name="checkbox"
                                               id="exampleCheckbox11" value=""/>
                                        <label class="form-check-label" for="exampleCheckbox11"><span>New (1506)</span></label>
                                        <br/>
                                        <input class="form-check-input" type="checkbox" name="checkbox"
                                               id="exampleCheckbox21" value=""/>
                                        <label class="form-check-label"
                                               for="exampleCheckbox21"><span>Refurbished (27)</span></label>
                                        <br/>
                                        <input class="form-check-input" type="checkbox" name="checkbox"
                                               id="exampleCheckbox31" value=""/>
                                        <label class="form-check-label"
                                               for="exampleCheckbox31"><span>Used (45)</span></label>
                                    </div>
                                </div>
                            </div>
                            <a href="shop-grid-right.html" class="btn btn-sm btn-default"><i
                                    class="fi-rs-filter mr-5"></i> Fillter</a>
                        </div>
                        <!-- Product sidebar Widget -->
                        <div class="banner-img wow fadeIn mb-lg-0 animated d-lg-block d-none">
                            <img src="{{asset('frontend/assets/imgs/banner/6.png')}}" alt=""/>
                            <div class="banner-text">
                                <span>Oganic</span>
                                <h4>
                                    Save 17% <br/>
                                    on <span class="text-brand">Oganic</span><br/>
                                    Juice
                                </h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('addJs')
    <script src="{{asset('frontend/detail/detail.js')}}"></script>
@endsection
