@extends('frontend.layouts.master')
@section('css_library')
    @include('common.partials.style-library', ['datepicker' => true, 'clockpicker' => true])
@stop
@section('modal')
    {{--    @include('frontend.partials.modal-pre-load') --}}
@endsection
@section('addCss')
    <link rel="stylesheet" href="{{ asset('frontend/carts/cart.css') }}">
@endsection
@section('content')
    <div class="page-header breadcrumb-wrap">
        <div class="container">
            <div class="breadcrumb">
                <a href="index.html" rel="nofollow"><i class="fi-rs-home mr-5"></i>Home</a>
                <span></span> Shop
                <span></span> Cart
            </div>
        </div>
    </div>
    <div class="container mt-50">
        <h1 class="heading-2 mb-10">{{trans('messages.cart.cart')}}</h1>
    </div>
    @include('frontend.alerts.alert')
    @if (!empty($carts))
        <form method="POST" class="checkOutCartForm" action="{{route('payment.checkout')}}">
            @csrf
            <div class="container mb-80 cart-pick-payment">
                <div class="row">
                    <div class="card">
                        <div class="card-body d-flex align-items-center">
                            <h5 class="card-title mr-50">{{trans('messages.cart.customer_want')}}</h5>
                            <ul class="nav nav-tabs links action_method" id="myTab" role="tablist">
                                <li class="nav-item d-flex tab-store align-items-center" role="presentation">
                                    <input data-bs-toggle="tab"
                                           data-bs-target="#tab-one"
                                           type="radio" checked name="delivery_method" value="1"
                                           class="shipping-account form-check-input">
                                    <button class="nav-link active" id="nav-tab-one" style="padding-left: 0"
                                            data-bs-toggle="tab"
                                            data-bs-target="#tab-one" type="button" role="tab" aria-controls="tab-one"
                                            aria-selected="true">{{trans('messages.cart.pick_store')}}
                                    </button>
                                </li>
                                <li class="nav-item d-flex tab-ship align-items-center" role="presentation">
                                    <input type="radio" name="delivery_method" data-bs-toggle="tab" value="2"
                                           data-bs-target="#tab-two"
                                           class="shipping-account form-check-input">
                                    <button class="nav-link" id="nav-tab-two" data-bs-toggle="tab"
                                            data-bs-target="#tab-two" style="padding-left: 0"
                                            type="button" role="tab" aria-controls="tab-two"
                                            aria-selected="false">{{trans('messages.cart.pick_ship')}}
                                    </button>
                                </li>
                            </ul>
                        </div>
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="tab-one" role="tabpanel"
                                 aria-labelledby="tab-one">
                                <div class="pick_store row">
                                    <div class="align-items-center d-flex gap-4">
                                        <div class="img_store col-lg-1">
                                            <img src="{{ asset('frontend/assets/imgs/carts/ico_store.png') }}" alt="">
                                        </div>
                                        <div class="col-lg-3">
                                            <input class="form-control pick_store_date" type="text"
                                                   name="pick_store_date"
                                                   id="pick_store_date"
                                                   data-picker="date-picker-shipping"
                                                   placeholder="{{trans('messages.cart.pick_date')}}">
                                        </div>
                                        <div class="date col-lg-3">
                                            <input class="form-control shipping_hour pick_store_hour" type="text"
                                                   name="pick_store_hour"
                                                   placeholder="{{trans('messages.cart.pick_ship')}}">
                                        </div>
                                    </div>
                                </div>
                                <!--End product-grid-4-->
                            </div>
                            <!--En tab one-->
                            <div class="tab-pane fade" id="tab-two" role="tabpanel" aria-labelledby="tab-two">
                                <div class="pick_ship row">
                                    <div class="align-items-center d-flex gap-4">
                                        <div class="img_store col-lg-1">
                                            <img width="50px"
                                                 src="{{ asset('frontend/assets/imgs/carts/ico_deliver.png') }}"
                                                 alt="">
                                        </div>
                                        <div class="col-lg-3">
                                            <input class="form-control pick_ship_date" type="text" name="pick_ship_date"
                                                   id="pick_ship_date"
                                                   data-picker="date-picker-shipping"
                                                   placeholder="{{trans('messages.cart.pick_ship')}}">
                                        </div>
                                        <div class="date col-lg-3">
                                            <input class="form-control shipping_hour pick_ship_hour" type="text"
                                                   name="pick_ship_hour"
                                                   placeholder="{{trans('messages.cart.pick_hour')}}">
                                        </div>
                                    </div>
                                </div>
                                @guest
                                    <div class="info_ship pl-20">
                                        <div class="row align-items-center">
                                            <div class="col-lg-4">
                                                <h5>{{trans('messages.cart.info_delivery')}}</h5>
                                            </div>
                                            <div class="col-lg-3">
                                                <p>{{trans('messages.cart.not_register')}} <a class="register_now"
                                                                                              href="{{ route('user.register') }}">{{trans('messages.cart.register_now')}}</a>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                @endguest
                                @auth
                                    <div class="info_ship row">
                                        <div class="row align-items-center">
                                            <div class="col-lg-4">
                                                <h5>{{trans('messages.cart.info_delivery')}}</h5>
                                            </div>
                                        </div>
                                        <p class="text-center">{{trans('messages.cart.delivery_different')}} <a
                                                href="javascript:void(0)"
                                                data-bs-toggle="modal"
                                                data-bs-target="#addShippingAddressModal">{{trans('messages.cart.add_address_delivery')}}</a>
                                        </p>
                                        <div class="list-address">
                                            @include('frontend.carts.components.user-shipping-address')
                                        </div>
                                        <!-- Modal -->
                                        <div class="modal fade" id="addShippingAddressModal" tabindex="-1"
                                             aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h1 class="modal-title fs-4 w-100 text-center"
                                                            id="exampleModalLabel">
                                                            {{trans('messages.cart.info_pick_item')}}
                                                        </h1>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                                aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="row shipping-address-form"
                                                             data-url="{{route('account.addShippingAddress')}}">
                                                            <div class="col-md-6">
                                                                <div class="input-style mb-20">
                                                                    <input class="shipping_firstname"
                                                                           name="shipping_firstname"
                                                                           placeholder="{{trans('messages.common.first_name')}}"
                                                                           type="text">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="input-style mb-20">
                                                                    <input class="shipping_lastname"
                                                                           name="shipping_lastname"
                                                                           placeholder="{{trans('messages.common.last_name')}}"
                                                                           type="text">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-12">
                                                                <div class="input-style mb-20">
                                                                    <input class="shipping_phone"
                                                                           name="shipping_phone"
                                                                           placeholder="{{trans('messages.common.phone_number')}}"
                                                                           type="text">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-12">
                                                                <div class="input-style mb-20">
                                                                    <input class="shipping_address"
                                                                           name="shipping_address"
                                                                           placeholder="{{trans('messages.common.address')}}"
                                                                           type="text">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                                data-bs-dismiss="modal">{{trans('messages.common.close')}}
                                                        </button>
                                                        <button type="button"
                                                                class="btn btn-primary addShippingAddress">{{trans('messages.common.save')}}
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endauth


                                <!--End product-grid-4-->
                            </div>
                            <div class="payment-method ship-note row">
                                <div class="header-bar">
                                    <h5>Chọn phương thức thanh toán</h5>
                                </div>
                                <div class="col-md-12 message-note">
                                    <ul class="links d-flex flex-column gap-3" id="myTab" role="tablist">
                                        @foreach($paymentMethod as $method)
                                            <li class="nav-item d-flex tab-store align-items-center"
                                                role="presentation">
                                                <p>
                                                    <label style="color: #253D4E">
                                                        <input
                                                            type="radio" name="payment_method"
                                                            value="{{$method->id}}"
                                                            class="form-check-input">
                                                        @if($method->image)
                                                            <img height="20px"
                                                                 src="{{asset($method->image)}}"
                                                                 alt="">
                                                        @endif
                                                        {{$method->description}}
                                                    </label>
                                                </p>
                                            </li>

                                        @endforeach
                                        </li>
                                    </ul>

                                </div>
                            </div>
                            <div class="ship-note row">
                                <div class="header-bar">
                                    <h5>Ghi chú</h5>
                                </div>
                                <div class="col-md-12 message-note">
                                    <div class="textarea-style">
                                            <textarea class="form-control" name="note-shipping"
                                                      placeholder="{{trans('messages.cart.note_desc')}}"></textarea>
                                    </div>

                                </div>
                            </div>

                            <!--End tab-content-->
                        </div>
                    </div>
                </div>
                @include('frontend.carts.components.cart-list')
            </div>

        </form>

    @elseif(empty($carts) && !session('success'))
        <div class="mb-60">
            <p class="text-center">{{trans('messages.cart.cart_empty')}}</p>
        </div>
    @endif
@endsection
@section('js_library')
    @include('common.partials.script-library', [
        'datepicker' => true,
        'datetimepicker' => true,
        'clockpicker' => true,
    ])
@stop
@section('addJs')
    <script type="module" src="{{ asset('frontend/carts/carts.js') }}"></script>
@endsection
