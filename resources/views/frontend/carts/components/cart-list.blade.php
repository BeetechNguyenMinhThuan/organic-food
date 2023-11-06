<div class="container mb-80 cart-product-list">
    <div class="row">
        <div class="col-lg-8 mb-40">
            <div class="d-flex justify-content-between">
                <h6 class="text-body">There are <span class="text-brand">{{count($carts)}}</span> products in your cart</h6>
                <h6 class="text-body"><a href="{{route('cart.allDelete')}}" class="text-muted"><i class="fi-rs-trash mr-5"></i>Clear Cart</a>
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
                        <th class="pl-20" scope="col" colspan="2">Product</th>
                        <th scope="col">Unit Price</th>
                        <th scope="col">Quantity</th>
                        <th scope="col">Subtotal</th>
                        <th scope="col" class="end">Remove</th>
                    </tr>
                    </thead>
                    <tbody>
                    @php
                        $totalPrice = 0
                    @endphp
                    @foreach($carts as $productId => $cart)
                        @php
                            $totalPrice+= $cart['product']->price * $cart['quantity'];
                        @endphp
                        <tr class="pt-30">
                            <td class="image product-thumbnail pt-40 pl-20"><img
                                    src="{{asset("/storage/". $cart['product']->avatar)}}"
                                    alt="#"></td>
                            <td class="product-des product-name">
                                <h6 class="mb-5"><a class="product-name mb-10 text-heading"
                                                    href="{{route('products.detail',$cart['product']->slug)}}">{{$cart['product']->name}}</a>
                                </h6>
                            </td>
                            <td class="price" data-title="Price">
                                <h4 class="text-body">{!! $cart['product']->getPrice() !!}</h4>
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
                                <h4 class="text-brand">{{number_format($cart['product']->price * $cart['quantity'])}}
                                    <sup>₫</sup></h4>
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
            <div class="border p-md-4 cart-totals ml-30">
                <div class="table-responsive">
                    <table class="table no-border">
                        <tbody>
                        <tr>
                            <td class="cart_total_label">
                                <h6 class="text-muted">Subtotal</h6>
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
                        <tr>
                            <td class="cart_total_label">
                                <h6 class="text-muted">Apply Coupon</h6>
                            </td>
                            <td class="d-flex">
                                <input class="font-medium mr-15 coupon" name="coupon_name"
                                       placeholder="Enter Your Coupon">
                                <button class="btn checkCoupon"><i class="fi-rs-label"></i></button>
                            </td>
                        </tr>

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
                                <h6 class="text-muted">Total</h6>
                            </td>
                            <td class="cart_total_amount">
                                <h4 class="text-brand text-end">{{number_format($totalPrice)}} <sup>₫</sup></h4>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <a href="#" class="btn mb-20 w-100">Proceed To CheckOut<i class="fi-rs-sign-out ml-15"></i></a>
            </div>
        </div>
    </div>
</div>
