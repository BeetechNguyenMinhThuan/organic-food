@extends('backend.layouts.master')
@section('addJs')
@endsection
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Hyper</a></li>
                        <li class="breadcrumb-item"><a href="javascript: void(0);">eCommerce</a></li>
                        <li class="breadcrumb-item active">Order Details</li>
                    </ol>
                </div>
                <h4 class="page-title">Order Details</h4>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title mb-3">Items from {{$order->hash_order_id}}</h4>

                    <div class="table-responsive">
                        <table class="table mb-0">
                            <thead class="thead-light">
                            <tr>
                                <th>Avatar</th>
                                <th>Name</th>
                                <th>Quantity</th>
                                <th>Price</th>
                                <th>Sub total</th>
                                <th>Total</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($orderDetail as $orderItem)
                                <tr>
                                    <td>
                                        <img class="rounded-circle" height="100px" width="100px"
                                             src="{{asset('/storage/' . $orderItem->product->avatar)}}" alt="">
                                    </td>
                                    <td>
                                        {{$orderItem->product->name}}
                                    </td>
                                    <td>{{$orderItem->quantity}}</td>
                                    <td>{!! \App\Helpers\Common::getFormatNumberPrice($orderItem->price) !!}</td>
                                    <td>{!! \App\Helpers\Common::getFormatNumberPrice($orderItem->sub_total) !!}</td>
                                    <td>{!! \App\Helpers\Common::getFormatNumberPrice($orderItem->total_price) !!}</td>
                                </tr>

                            @endforeach

                            </tbody>
                        </table>
                    </div>
                    <!-- end table-responsive -->

                </div>
            </div>
        </div> <!-- end col -->

        <div class="col-lg-4">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title mb-3">Order Summary</h4>

                    <div class="table-responsive">
                        <table class="table mb-0">
                            <thead class="thead-light">
                            <tr>
                                <th>Description</th>
                                <th>Price</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>Grand Total :</td>
                                <td>{!! \App\Helpers\Common::getFormatNumberPrice($order->sub_total) !!}</td>
                            </tr>
                            <tr>
                                <td>Shipping Charge :</td>
                                <td>{!! \App\Helpers\Common::getFormatNumberPrice($order->ship_fee) !!}</td>
                            </tr>

                            <tr>
                                <th>Total :</th>
                                <th>{!! \App\Helpers\Common::getFormatNumberPrice($order->total_price) !!}</th>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <!-- end table-responsive -->

                </div>
            </div>
        </div> <!-- end col -->
    </div>
    <!-- end row -->


    <div class="row">
        <div class="col-lg-3">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title mb-3">Thông tin người đặt hàng</h4>
                    <div class="info-user mb-2 d-flex align-items-center">
                        <img class="rounded-circle" height="40px" width="40px"
                             src="{{asset('/storage/' . $order->user->avatar)}}" alt="">
                        <h5 class="pl-2">{{$order->user->fullname}}</h5>
                    </div>
                    <p>Email: {{$order->user->email}}</p>

                    <address class="mb-0 font-14 address-lg">
                        Address: {{$order->user->address}}</br>
                        <abbr title="Phone">Phone: {{$order->user->phone}} <br/>
                    </address>
                </div>
            </div>
        </div> <!-- end col -->
        <div class="col-lg-3">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title mb-3">Thông tin vận chuyển hàng</h4>
                    <div class="info-user mb-2 d-flex align-items-center">
                        <strong class="pr-1">Tên người nhận: </strong>
                        <h5 class="">{{$order->userAddress->fullname}}</h5>
                    </div>
                    <div class="note_shipping">
                        <strong> Ghi chú:</strong>
                        <span>{{$order->user_comment}}</span>
                    </div>
                    <address class="mb-0 font-14 address-lg">
                        <strong>Address:</strong> {{$order->userAddress->address}}</br>
                        <abbr title="Phone"><strong>Phone:</strong> {{$order->userAddress->phone_number}} <br/>
                    </address>
                </div>
            </div>
        </div> <!-- end col -->

        <div class="col-lg-3">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title mb-3">Thông tin thanh toán</h4>

                    <ul class="list-unstyled mb-0">
                        <li>
                            <p class="mb-2"><span
                                    class="font-weight-bold mr-2">Payment Type:</span> {{$order->paymentMethod->name}}
                            </p>
                            <p class="mb-2"><span class="font-weight-bold mr-2">Payment Type:</span>
                                {{$order->delivery_method === \App\Models\Order::PICK_STORE ? "Đến lấy tại cửa hàng" : "Giao hàng"}}
                            </p>
                        </li>
                    </ul>

                </div>
            </div>
        </div> <!-- end col -->
        @if($order->delivery_method === \App\Models\Order::PICK_SHIP)
            <div class="col-lg-3">
                <div class="card">
                    <div class="card-body">
                        <h4 class="header-title mb-3">Delivery Info</h4>

                        <div class="text-center">
                            <i class="mdi mdi-truck-fast h2 text-muted"></i>
                            <h5><b>UPS Delivery</b></h5>
                            <p class="mb-1"><b>Order ID :</b> xxxx235</p>
                            <p class="mb-0"><b>Payment Mode :</b> COD</p>
                        </div>
                    </div>
                </div>
            </div> <!-- end col -->
        @endif
    </div>
    <!-- end row -->

@endsection
