<div class="container mb-80 mt-80 cart-product-list">
    <div class="row">
        <div class="col-lg-8 mb-40">
            <div class="d-flex justify-content-between">
                <h6 class="text-body">
                    {{trans('messages.cart.total_product_cart',['quantity' => count($carts) ])}}
                </h6>
                <h6 class="text-body"><a href="{{route('cart.allDelete')}}" class="text-muted"><i
                            class="fi-rs-trash mr-5"></i>{{trans('messages.cart.clear_cart')}}</a>
                </h6>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-8">
            <div class="table-responsive shopping-summery">
                <table class="table table-wishlist cart-update-list" data-url="{{route('cart.update')}}">
                    <thead>
                    <tr class="main-heading">
                        <th class="pl-20" scope="col" colspan="2">{{trans('messages.common.product')}}</th>
                        <th scope="col">{{trans('messages.cart.unit_price')}}</th>
                        <th scope="col">{{trans('messages.common.quantity')}}</th>
                        <th scope="col">{{trans('messages.cart.sub_total')}}</th>
                        <th scope="col" class="end">{{trans('messages.common.remove')}}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @php
                        $totalPrice = 0
                    @endphp
                    @foreach($carts as $productId => $cart)
                        @php
                            $totalPrice+= $cart['product']->getPrice() * $cart['quantity'];
                        @endphp
                        <tr class="pt-30">
                            <td class="image product-thumbnail pt-40 pl-20"><img
                                    src="{{asset("/storage/". $cart['product']->avatar)}}"
                                    alt="#"></td>
                            <td class="product-des product-name">
                                <h6 class="mb-5"><a class="product-name mb-10 text-heading"
                                                    href="{{route('products.detail',$cart['product']->slug)}}">{{$cart['product']->name}}</a>
                                    <p>{{$cart['product']->weight}}</p>
                                </h6>
                            </td>
                            <td class="price" data-title="Price">
                                <h4 class="text-body">{!! $cart['product']->formatPrice() !!}</h4>
                            </td>
                            <td class="text-center detail-info" data-title="Stock">
                                <div class="detail-extralink mr-15">
                                    <div class="detail-qty border radius">
                                        <a href="#"
                                           class="qty-down cart-qty-down"><i
                                                class="fi-rs-angle-small-down"></i></a>
                                        <input type="number" name="quantity" class="qty-val cart-product-qty"
                                               data-id="{{$productId}}"
                                               value="{{$cart ? $cart['quantity'] : ""}}" min="1">
                                        <a href="#"
                                           class="qty-up cart-qty-up"><i
                                                class="fi-rs-angle-small-up"></i></a>
                                    </div>
                                </div>
                            </td>
                            <td class="price" data-title="Price">
                                <h4 class="text-brand"> {!! $cart['product']->handleCalculatePriceCart($cart['product']->getPrice() * $cart['quantity']) !!}
                            </td>
                            <td class="action text-center" data-title="Remove"><a href="#" data-id="{{$productId}}"
                                                                                  class="text-body delete-cart-product"><i
                                        class="fi-rs-trash"></i></a></td>
                        </tr>

                    @endforeach

                    </tbody>
                </table>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="border p-md-4 cart-totals">
                <div class="table-responsive">
                    <table class="table no-border">
                        <tbody>
                        <tr>
                            <td class="cart_total_label">
                                <h6 class="text-muted">{{trans('messages.cart.sub_total')}}</h6>
                            </td>
                            <td class="cart_total_amount">
                                <h4 class="text-brand text-end">{{number_format($totalPrice)}} <sup>₫</sup></h4>
                            </td>
                        </tr>
                        <tr>
                            <td scope="col" colspan="2">
                                <div class="divider-2 mt-10 mb-10"></div>
                            </td>
                        </tr>
{{--                        <tr>--}}
{{--                            <td class="cart_total_label">--}}
{{--                                <h6 class="text-muted">{{trans('messages.cart.apply_coupon')}}</h6>--}}
{{--                            </td>--}}
{{--                            <td class="d-flex">--}}
{{--                                <input class="font-medium mr-15 coupon discount_name" name="discount_name"--}}
{{--                                       placeholder="{{trans('messages.cart.enter_coupon')}}">--}}
{{--                                <button data-url="{{route('cart.checkDiscountCode')}}" type="button" class="btn checkDiscount"><i class="fi-rs-label"></i></button>--}}
{{--                            </td>--}}
{{--                        </tr>--}}

                        {{--                                <tr>--}}
                        {{--                                    <td class="cart_total_label">--}}
                        {{--                                        <h6 class="text-muted">Shipping</h6>--}}
                        {{--                                    </td>--}}
                        {{--                                    <td class="cart_total_amount">--}}
                        {{--                                        <h5 class="text-heading text-end">Free</h4</td>--}}
                        {{--                                </tr>--}}

                        <tr>
                            <td scope="col" colspan="2">
                                <div class="divider-2 mt-10 mb-10"></div>
                            </td>
                        </tr>
                        <tr>
                            <td class="cart_total_label">
                                <h6 class="text-muted">{{trans('messages.cart.total')}}</h6>
                            </td>
                            <td class="cart_total_amount">
                                <h4 class="text-brand text-end">{{number_format($totalPrice)}} <sup>₫</sup></h4>
                                <input type="hidden" value="{{$totalPrice}}" class="totalPriceBase">
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <button name="redirect" type="submit" class="btn mb-20 w-100">{{trans('messages.cart.checkout')}}<i
                        class="fi-rs-sign-out ml-15"></i></button>
            </div>
        </div>
    </div>
</div>
