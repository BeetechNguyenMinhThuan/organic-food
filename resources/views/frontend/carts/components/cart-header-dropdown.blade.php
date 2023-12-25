@php
    $carts = \Illuminate\Support\Facades\Session::get('carts');
    $totalPrice = 0;
    $totalQuantity = 0;
    if (!empty($carts)){
        foreach ($carts as $cart){
            $totalQuantity += $cart['quantity'];
        }
    }
@endphp
<div class="header-action-icon-2 header-cart-list" data-url="{{route('cart.delete')}}">
    <a class="mini-cart-icon" href="{{route('cart.show')}}">
        <img alt="Nest" src="{{asset('frontend/assets/imgs/theme/icons/icon-cart.svg')}}"/>
         <span class="pro-count blue">{{$totalQuantity}}</span>
    </a>
    <a href="{{route('cart.show')}}"><span class="lable">{{ trans('messages.header.cart') }}</span></a>

    @if(!empty($carts))
        <div class="cart-dropdown-wrap cart-dropdown-hm2 cart-header-wrap">
            <ul>
                @foreach($carts as $productId => $cart)
                    @php
                        $totalPrice+= $cart['product']->getPrice() * $cart['quantity'];
                    @endphp
                    <li>
                        <div class="shopping-cart-img">
                            <a href="{{route('products.detail',$cart['product']->slug)}}"><img alt="Nest"
                                                                                               src="{{asset("/storage/". $cart['product']->avatar)}}"/></a>
                        </div>
                        <div class="shopping-cart-title">
                            <h4>
                                <a href="{{route('products.detail',$cart['product']->slug)}}">{{$cart['product']->name}}</a>
                            </h4>
                            <h4><span>{{$cart['quantity']}} × </span>{!! $cart['product']->formatPrice() !!}</h4>
                        </div>
                        <div class="shopping-cart-delete">
                            <a data-id="{{$productId}}" class="delete-cart-product" href="#"><i
                                    class="fi-rs-cross-small"></i></a>
                        </div>
                    </li>
                @endforeach

            </ul>
            <div class="shopping-cart-footer">
                <div class="shopping-cart-total">
                    <h4>Total <span>{{number_format($totalPrice)}} <sup>₫</sup></span></h4>
                </div>
                <div class="shopping-cart-button justify-content-center">
                    <a href="{{route('cart.show')}}" class="outline">View cart</a>
                </div>
            </div>
        </div>
    @endif

</div>

