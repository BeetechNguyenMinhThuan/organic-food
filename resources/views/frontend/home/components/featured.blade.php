<section class="section-padding mb-30">
    <div class="container">
        <div class="row">
            <div class="col-xl-3 col-lg-4 col-md-6 mb-sm-5 mb-md-0 wow animate__animated animate__fadeInUp"
                 data-wow-delay="0">
                <h4 class="section-title style-1 mb-30 animated animated">Top Selling</h4>
                <div class="product-list-small animated animated">
                    @foreach($products->take(3) as $key => $product)
                        <article class="row align-items-center hover-up">
                            <figure class="col-md-4 mb-0">
                                <a href="{{route('products.detail',$product->slug)}}"><img
                                        src="{{asset('/storage/'. $product->avatar)}}"
                                        alt=""/></a>
                            </figure>
                            <div class="col-md-8 mb-0">
                                <h6>
                                    <a href="{{route('products.detail',['name'=>$product->slug])}}">{{$product->name}}</a>
                                </h6>
                                <div class="product-rate-cover">
                                    <div class="product-rate d-inline-block">
                                        <div class="product-rating" style="width: 90%"></div>
                                    </div>
                                    <span class="font-small ml-5 text-muted"> (4.0)</span>
                                </div>
                                <div class="product-price">
                                    <span>{!!$product->getPrice()!!}</span>
                                    <span
                                        class="old-price">{{number_format($product->price)}}<sup>₫</sup></span>
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>
            </div>
            <div class="col-xl-3 col-lg-4 col-md-6 mb-sm-5 mb-md-0 wow animate__animated animate__fadeInUp"
                 data-wow-delay="0">
                <h4 class="section-title style-1 mb-30 animated animated">Trending Products</h4>
                <div class="product-list-small animated animated">
                    @foreach($products->skip(3)->take(3) as $key => $product)
                        <article class="row align-items-center hover-up">
                            <figure class="col-md-4 mb-0">
                                <a href="{{route('products.detail',$product->slug)}}"><img
                                        src="{{asset('/storage/'. $product->avatar)}}"
                                        alt=""/></a>
                            </figure>
                            <div class="col-md-8 mb-0">
                                <h6>
                                    <a href="{{route('products.detail',['name'=>$product->slug])}}">{{$product->name}}</a>
                                </h6>
                                <div class="product-rate-cover">
                                    <div class="product-rate d-inline-block">
                                        <div class="product-rating" style="width: 90%"></div>
                                    </div>
                                    <span class="font-small ml-5 text-muted"> (4.0)</span>
                                </div>
                                <div class="product-price">
                                    <span>{!!$product->getPrice()!!}</span>
                                    <span
                                        class="old-price">{{number_format($product->price)}}<sup>₫</sup></span>
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>
            </div>
            <div class="col-xl-3 col-lg-4 col-md-6 mb-sm-5 mb-md-0 wow animate__animated animate__fadeInUp"
                 data-wow-delay="0">
                <h4 class="section-title style-1 mb-30 animated animated">Recently added</h4>
                <div class="product-list-small animated animated">
                    @foreach($products->skip(6)->take(3) as $key => $product)
                        <article class="row align-items-center hover-up">
                            <figure class="col-md-4 mb-0">
                                <a href="{{route('products.detail',$product->slug)}}"><img
                                        src="{{asset('/storage/'. $product->avatar)}}"
                                        alt=""/></a>
                            </figure>
                            <div class="col-md-8 mb-0">
                                <h6>
                                    <a href="{{route('products.detail',['name'=>$product->slug])}}">{{$product->name}}</a>
                                </h6>
                                <div class="product-rate-cover">
                                    <div class="product-rate d-inline-block">
                                        <div class="product-rating" style="width: 90%"></div>
                                    </div>
                                    <span class="font-small ml-5 text-muted"> (4.0)</span>
                                </div>
                                <div class="product-price">
                                    <span>{!!$product->getPrice()!!}</span>
                                    <span
                                        class="old-price">{{number_format($product->price)}}<sup>₫</sup></span>
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>
            </div>
            <div class="col-xl-3 col-lg-4 col-md-6 mb-sm-5 mb-md-0 wow animate__animated animate__fadeInUp"
                 data-wow-delay="0">
                <h4 class="section-title style-1 mb-30 animated animated">Top Rated</h4>
                <div class="product-list-small animated animated">
                    @foreach($products->skip(9)->take(3) as $key => $product)
                        <article class="row align-items-center hover-up">
                            <figure class="col-md-4 mb-0">
                                <a href="{{route('products.detail',$product->slug)}}"><img
                                        src="{{asset('/storage/'. $product->avatar)}}"
                                        alt=""/></a>
                            </figure>
                            <div class="col-md-8 mb-0">
                                <h6>
                                    <a href="{{route('products.detail',['name'=>$product->slug])}}">{{$product->name}}</a>
                                </h6>
                                <div class="product-rate-cover">
                                    <div class="product-rate d-inline-block">
                                        <div class="product-rating" style="width: 90%"></div>
                                    </div>
                                    <span class="font-small ml-5 text-muted"> (4.0)</span>
                                </div>
                                <div class="product-price">
                                    <span>{!!$product->getPrice()!!}</span>
                                    <span
                                        class="old-price">{{number_format($product->price)}}<sup>₫</sup></span>
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>
            </div>

        </div>
    </div>
</section>
