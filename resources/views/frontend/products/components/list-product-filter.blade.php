<div class="row product-grid list-product-item">
    @if($categoryBySlug->products->isNotEmpty())
        <div class="totall-product mb-4">
            <p>{!! trans('messages.filter.total_pro_filter',['quantity' =>$products->count()]) !!}</p>

        </div>
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
                        </div>
                        <div class="product-badges product-badges-position product-badges-mrg">
                            @if($product->sale_status)
                                <span class="hot">Save {{$product->discount}}%</span>
                            @endif

                        </div>
                    </div>
                    <div class="product-content-wrap">
                        <div class="product-category">
                            <a href="shop-grid-right.html">{{optional($product->category)->name}}</a>
                        </div>
                        <h2><a href="{{route('products.detail',$product->slug)}}">{{$product->name}}
                                / {{$product->weight}}</a>
                        </h2>
                        <div class="product-rate d-inline-block">
                            <div class="product-rating" style="width: 80%"></div>
                        </div>
                        <div class="product-price mt-10 mb-10">
                            <span>{!!$product->formatPrice()!!}</span>
                            @if($product->sale_status)
                                <span
                                    class="old-price">{!!$product->getBasePrice()!!}</span>
                            @endif
                        </div>
                        <a href="shop-cart.html"
                           data-url="{{ route('cart.add',['productId'=>$product->id])}}"
                           class="btn add button-add-to-cart w-100 hover-up"><i
                                class="fi-rs-shopping-cart mr-5"></i>{{trans('messages.common.add')}}
                        </a>
                    </div>
                </div>
                @include('frontend.products.modal-quick-view',['item'=>$product,'key'=>$key])
            </div>
        @endforeach
        <!--product grid-->
        <div class="pagination-area mt-20 mb-20">
            {!! $products->links('vendor.pagination.default') !!}
        </div>
    @endif
</div>
