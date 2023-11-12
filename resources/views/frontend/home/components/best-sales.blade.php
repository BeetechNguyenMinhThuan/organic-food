<section class="section-padding pb-5 mb-20">
    <div class="container">
        <div class="section-title wow animate__animated animate__fadeIn">
            <h3 class="">Daily Best Sells</h3>
        </div>
        <div class="row">
            <div class="col-lg-3 d-none d-lg-flex wow animate__animated animate__fadeIn">
                <div class="banner-img style-2">
                    <div class="banner-text">
                        <h2 class="mb-100">Bring nature into your home</h2>
                        <a href="shop-grid-right.html" class="btn btn-xs">Shop Now <i
                                class="fi-rs-arrow-small-right"></i></a>
                    </div>
                </div>
            </div>
            <div class="col-lg-9 col-md-12 wow animate__animated animate__fadeIn" data-wow-delay=".4s">
                <div class="tab-content" id="myTabContent-1">
                    <div class="tab-pane fade show active" id="tab-one-1" role="tabpanel"
                         aria-labelledby="tab-one-1">
                        <div class="carausel-4-columns-cover arrow-center position-relative">
                            <div class="slider-arrow slider-arrow-2 carausel-4-columns-arrow"
                                 id="carausel-4-columns-arrows"></div>
                            <div class="carausel-4-columns carausel-arrow-center" id="carausel-4-columns">
                                @foreach($products as $product)
                                    <div class="product-cart-wrap d-flex flex-column justify-content-between">
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
                                                   data-bs-toggle="modal" data-bs-target="#quickViewModal"> <i
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
                                                <a href="{{route('products.detail',$product->slug)}}">{{optional($product->category)->name}}</a>
                                            </div>
                                            <h2>
                                                <a href="{{route('products.detail',$product->slug)}}">{{$product->name}}</a>
                                            </h2>
                                            <div class="product-rate d-inline-block">
                                                <div class="product-rating" style="width: 80%"></div>
                                            </div>
                                            <div class="product-price mt-10 mb-10">
                                                <span>{!!$product->formatPrice()!!}</span>
                                                <span class="old-price">{!! $product->formatPrice() !!}</span>
                                            </div>
                                            <a href="shop-cart.html"
                                               data-url="{{ route('cart.add',['productId'=>$product->id])}}"
                                               class="btn w-100 hover-up button-add-to-cart"><i
                                                    class="fi-rs-shopping-cart mr-5"></i>Add To Cart</a>
                                        </div>
                                    </div>
                                @endforeach
                                <!--End product Wrap-->
                            </div>
                        </div>
                    </div>
                    <!--End tab-pane-->
                </div>
                <!--End tab-content-->
            </div>
            <!--End Col-lg-9-->
        </div>
    </div>
</section>
