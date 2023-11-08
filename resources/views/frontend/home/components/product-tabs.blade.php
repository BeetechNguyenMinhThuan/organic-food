@php
    $categoriesList = $categories->take(5);
@endphp
<section class="product-tabs section-padding position-relative">
    <div class="container">
        <div class="section-title style-2 wow animate__animated animate__fadeIn">
            <h3>Popular Products</h3>
            <ul class="nav nav-tabs links" id="myTab" role="tablist">
                @foreach( $categoriesList as $key => $category)
                    <li class="nav-item" role="presentation">
                        <button class="nav-link nav-tab-product {{$key == 0 ? "active" : ""}}" id="nav-tab-{{$key}}"
                                data-bs-toggle="tab"
                                data-bs-target="#tab-{{$key}}"
                                type="button" data-index="{{$key}}" role="tab" aria-controls="tab-{{$key}}"
                                aria-selected="{{$key == 0 ? "true" : "false"}}">{{$category->name}}
                        </button>
                    </li>
                @endforeach
            </ul>

        </div>
        <!--End nav-tabs-->
        <div class="tab-content" id="myTabContent">
            @foreach( $categoriesList as $key => $category)
                <div class="tab-pane product-popular fade {{$key == 0 ? "show active" : ""}}" id="tab-{{$key}}"
                     role="tabpanel"
                     aria-labelledby="tab-{{$key}}">
                    <div class="row product-grid-4">
                        @foreach($category->products as $product)
                            <div class="col-lg-1-5 col-md-4 col-12 col-sm-6">
                                <div class="product-cart-wrap mb-30 wow animate__animated animate__fadeIn"
                                     data-wow-delay=".1s">
                                    <div class="product-img-action-wrap">
                                        <div class="product-img product-img-zoom">
                                            <a href="{{route('products.detail',['name'=>$product->slug])}}">
                                                <img class="default-img"
                                                     src="{{\App\Helpers\Common::getImage($product->avatar)}}" alt=""/>
                                            </a>
                                        </div>
                                        <div class="product-action-1">
                                            <a aria-label="Add To Wishlist" class="action-btn"
                                               href="shop-wishlist.html"><i
                                                    class="fi-rs-heart"></i></a>
                                            <a aria-label="Compare" class="action-btn" href="shop-compare.html"><i
                                                    class="fi-rs-shuffle"></i></a>
                                            <a aria-label="Quick view" class="action-btn" data-bs-toggle="modal"
                                               data-bs-target="#quickViewModal"><i class="fi-rs-eye"></i></a>
                                        </div>
                                        <div class="product-badges product-badges-position product-badges-mrg">
                                            <span class="hot">Hot</span>
                                        </div>
                                    </div>
                                    <div class="product-content-wrap">
                                        <div class="product-category">
                                            <a href="{{route('products.detail',['name'=>$product->slug])}}">{{optional($product->category)->name}}</a>
                                        </div>
                                        <h2>
                                            <a href="{{route('products.detail',['name'=>$product->slug])}}">{{$product->name}}</a>
                                        </h2>
                                        <div class="product-rate-cover">
                                            <div class="product-rate d-inline-block">
                                                <div class="product-rating" style="width: 90%"></div>
                                            </div>
                                            <span class="font-small ml-5 text-muted"> (4.0)</span>
                                        </div>
                                        <div>
                                                <span class="font-small text-muted">By <a
                                                        href="vendor-details-1.html">NestFood</a></span>
                                        </div>
                                        <div class="product-card-bottom">
                                            <div class="product-price">
                                                <span>{{number_format($product->sale_price)}} VNĐ</span>
                                                <span class="old-price">{{number_format($product->price)}} VNĐ</span>
                                            </div>
                                            <div class="add-cart">
                                                <a class="add button-add-to-cart"
                                                   data-url="{{ route('cart.add',['productId'=>$product->id])}}"
                                                   href="shop-cart.html"><i
                                                        class="fi-rs-shopping-cart mr-5"></i>Add </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        <!--end product card-->
                    </div>
                    <!--End product-grid-4-->
                </div>
            @endforeach

        </div>

        <!--En tab one-->

        <!--En tab two-->
    </div>
    <!--End tab-content-->
    </div>
</section>
