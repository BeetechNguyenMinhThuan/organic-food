@extends('frontend.layouts.master')
@section('modal')
    {{--    @include('frontend.partials.modal-pre-load')--}}
@endsection
@section('addCss')
    <style>
        .profile-pic {
            color: transparent;
            transition: all .3s ease;
            display: flex;
            align-items: center;
            position: relative;
            transition: all .3s ease;

            & input {
                display: none;
            }

            & img {
                position: absolute;
                object-fit: cover;
                width: 165px;
                height: 165px;
                box-shadow: 0 0 10px 0 rgba(255, 255, 255, .35);
                border-radius: 100px;
                z-index: 0;
            }

            .-label {
                cursor: pointer;
                height: 165px;
                width: 165px;
            }

            &:hover {
                .-label {
                    display: flex;
                    justify-content: center;
                    align-items: center;
                    background-color: rgba(0, 0, 0, .8);
                    z-index: 10000;
                    color: rgb(250, 250, 250);
                    transition: background-color .2s ease-in-out;
                    border-radius: 100px;
                }
            }

            & span {
                display: inline-flex;
                padding: .2em;
                height: 2em;
            }
        }

    </style>
@endsection
@section('content')
    <div class="page-header breadcrumb-wrap">
        <div class="container">
            <div class="breadcrumb">
                <a href="index.html" rel="nofollow"><i class="fi-rs-home mr-5"></i>Home</a>
                <span></span> Pages <span></span> My Account
            </div>
        </div>
    </div>
    <div class="page-content pt-150 pb-150">
        <div class="container">
            <div class="row">
                <div class="col-lg-10 m-auto">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="dashboard-menu">
                                <ul class="nav flex-column" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" id="dashboard-tab" data-bs-toggle="tab"
                                           href="#dashboard" role="tab" aria-controls="dashboard" aria-selected="false"><i
                                                class="fi-rs-settings-sliders mr-10"></i>{{trans('messages.profile.dashboard')}}
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="orders-tab" data-bs-toggle="tab" href="#orders"
                                           role="tab" aria-controls="orders" aria-selected="false"><i
                                                class="fi-rs-shopping-bag mr-10"></i>{{trans('messages.profile.history_orders')}}
                                        </a>
                                    </li>
                                    {{--                                    <li class="nav-item">--}}
                                    {{--                                        <a class="nav-link" id="track-orders-tab" data-bs-toggle="tab"--}}
                                    {{--                                           href="#track-orders" role="tab" aria-controls="track-orders"--}}
                                    {{--                                           aria-selected="false"><i--}}
                                    {{--                                                class="fi-rs-shopping-cart-check mr-10"></i>{{trans('messages.header.order_tracking')}}--}}
                                    {{--                                        </a>--}}
                                    {{--                                    </li>--}}
                                    <li class="nav-item">
                                        <a class="nav-link" id="address-tab" data-bs-toggle="tab" href="#address"
                                           role="tab" aria-controls="address" aria-selected="true"><i
                                                class="fi-rs-marker mr-10"></i>{{trans('messages.profile.my_address')}}
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="account-detail-tab" data-bs-toggle="tab"
                                           href="#account-detail" role="tab" aria-controls="account-detail"
                                           aria-selected="true"><i
                                                class="fi-rs-user mr-10"></i>{{trans('messages.profile.account_detail')}}
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('user.logout') }}"><i
                                                class="fi-rs-sign-out mr-10"></i>{{trans('messages.auth.logout')}}
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-md-9">
                            <div class="tab-content account dashboard-content pl-50">
                                <div class="tab-pane fade active show" id="dashboard" role="tabpanel"
                                     aria-labelledby="dashboard-tab">
                                    <div class="card">
                                        <div class="card-header">
                                            <h3 class="mb-0">{!!trans('messages.profile.hello',['name' => auth()->user()->fullname]) !!}</h3>
                                        </div>
                                        <div class="card-body">
                                            <p>
                                                {{trans('messages.profile.desc')}}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="orders" role="tabpanel" aria-labelledby="orders-tab">
                                    <div class="card">
                                        <div class="card-header">
                                            <h3 class="mb-0">{{trans('messages.profile.order_history.your_orders')}}</h3>
                                            <form action="" method="GET" class="mt-3">
                                                <div class="d-flex">
                                                    <input class="order_search" name="order_code"
                                                           placeholder="Tìm kiếm theo mã đơn hàng" type="text">
                                                    <button type="button" data-url="{{route('account.myOrder')}}"
                                                            class="btn btn-primary searchOrder">Tìm kiếm
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                        <div class="card-body">
                                            <div
                                                class="table-responsive shopping-summery list-profile-orders">
                                                @include('frontend.account.components.list-order')
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="track-orders" role="tabpanel"
                                     aria-labelledby="track-orders-tab">
                                    <div class="card">
                                        <div class="card-header">
                                            <h3 class="mb-0">Orders tracking</h3>
                                        </div>
                                        <div class="card-body contact-from-area">
                                            <p>To track your order please enter your OrderID in the box below and press
                                                "Track" button. This was given to you on your receipt and in the
                                                confirmation email you should have received.</p>
                                            <div class="row">
                                                <div class="col-lg-8">
                                                    <form class="contact-form-style mt-30 mb-50" action="#"
                                                          method="post">
                                                        <div class="input-style mb-20">
                                                            <label>Order ID</label>
                                                            <input name="order-id"
                                                                   placeholder="Found in your order confirmation email"
                                                                   type="text"/>
                                                        </div>
                                                        <div class="input-style mb-20">
                                                            <label>Billing email</label>
                                                            <input name="billing-email"
                                                                   placeholder="Email you used during checkout"
                                                                   type="email"/>
                                                        </div>
                                                        <button class="submit submit-auto-width" type="submit">Track
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="address" role="tabpanel" aria-labelledby="address-tab">
                                    <div class="row">
                                        <button type="submit"
                                                class="btn mb-20 ml-auto col-md-4"
                                                style="margin-left: auto" data-bs-toggle="modal"
                                                data-bs-target="#addShippingAddressModal">{{trans('messages.cart.add_address_delivery')}}
                                        </button>
                                        <!-- Modal Add Shipping Address -->
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
                                        <div class="table-responsive shopping-summery list-profile-address-shipping">
                                            @include('frontend.account.components.list-address')
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="account-detail" role="tabpanel"
                                     aria-labelledby="account-detail-tab">
                                    <div class="card">
                                        <div class="card-header">
                                            <h5>{{trans('messages.profile.account_detail')}}</h5>
                                        </div>
                                        <div class="card-body">
                                            <form method="post" action="{{route('account.updateAccount')}}"
                                                  enctype="multipart/form-data">
                                                @csrf
                                                <div class="row">
                                                    <div class="form-group upload-avatar">
                                                        <label for=""
                                                               class="font-weight-bold">{{trans('messages.profile.avatar')}}</label>
                                                        <div class="profile-pic">
                                                            <label class="-label" for="file">
                                                                <span class="glyphicon glyphicon-camera"></span>
                                                                <span>Change Image</span>
                                                            </label>
                                                            <input name="avatar" id="file" type="file"
                                                                   onchange="loadFile(event)"/>
                                                            <img
                                                                src="{{\App\Helpers\Common::getImage($user->avatar)}}"
                                                                id="output" width="200"/>
                                                        </div>
                                                        @error('avatar')
                                                        <div class="text-danger mt-1">
                                                            {{ $message }}
                                                        </div>
                                                        @enderror
                                                    </div>

                                                    <div class="form-group col-md-6">
                                                        <label>{{trans('messages.common.first_name')}}<span
                                                                class="required text-danger">*</span></label>
                                                        <input required value="{{$user->first_name}}"
                                                               class="form-control" name="first_name"
                                                               type="text"/>
                                                        @error('first_name')
                                                        <div class="text-danger mt-1">
                                                            {{ $message }}
                                                        </div>
                                                        @enderror
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <label>{{trans('messages.common.last_name')}}<span
                                                                class="required text-danger">*</span></label>
                                                        <input required value="{{$user->last_name}}"
                                                               class="form-control" name="last_name"/>
                                                        @error('last_name')
                                                        <div class="text-danger mt-1">
                                                            {{ $message }}
                                                        </div>
                                                        @enderror
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <label>Email<span class="required text-danger">*</span></label>
                                                        <input required value="{{$user->email}}" class="form-control"
                                                               name="email"
                                                               type="email"/>
                                                        @error('email')
                                                        <div class="text-danger mt-1">
                                                            {{ $message }}
                                                        </div>
                                                        @enderror
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <label>{{trans('messages.profile.phone_number')}}</label>
                                                        <input value="{{$user->phone}}" class="form-control"
                                                               name="phone"
                                                               type="text"/>
                                                        @error('phone')
                                                        <div class="text-danger mt-1">
                                                            {{ $message }}
                                                        </div>
                                                        @enderror
                                                    </div>
                                                    <div class="form-group col-md-12">
                                                        <label>{{trans('messages.profile.current_password')}}</label>
                                                        <input class="form-control" name="current_password"
                                                               type="password"/>
                                                        @error('current_password')
                                                        <div class="text-danger mt-1">
                                                            {{ $message }}
                                                        </div>
                                                        @enderror
                                                    </div>
                                                    <div class="form-group col-md-12">
                                                        <label>{{trans('messages.profile.new_password')}}</label>
                                                        <input class="form-control" name="new_password"
                                                               type="password"/>
                                                        @error('new_password')
                                                        <div class="text-danger mt-1">
                                                            {{ $message }}
                                                        </div>
                                                        @enderror
                                                    </div>
                                                    <div class="form-group col-md-12">
                                                        <label>{{trans('messages.profile.confirm_password')}}</label>
                                                        <input class="form-control" name="confirm_password"
                                                               type="password"/>
                                                        @error('confirm_password')
                                                        <div class="text-danger mt-1">
                                                            {{ $message }}
                                                        </div>
                                                        @enderror
                                                    </div>
                                                    <div class="col-md-12">
                                                        <button type="submit"
                                                                class="btn btn-fill-out submit font-weight-bold"
                                                                name="submit"
                                                                value="Submit">{{trans('messages.common.save')}}
                                                        </button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('addJs')
    <script>
        var loadFile = function (event) {
            var image = document.getElementById("output");
            image.src = URL.createObjectURL(event.target.files[0]);
        };
    </script>
    <script type="module" src="{{asset('frontend/profile/profile.js')}}"></script>
@endsection
