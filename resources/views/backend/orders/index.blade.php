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
                        <li class="breadcrumb-item active">Products</li>
                    </ol>
                </div>
                <h4 class="page-title">Orders</h4>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row mb-2">
                        <div class="col-lg-8">
                            <form class="form-inline">
                                <div class="form-group mb-2">
                                    <label for="inputPassword2" class="sr-only">Search</label>
                                    <input type="search" class="form-control" id="inputPassword2"
                                           placeholder="Search...">
                                </div>
                                <div class="form-group mx-sm-3 mb-2">
                                    <label for="status-select" class="mr-2">Status</label>
                                    <select class="custom-select" id="status-select">
                                        <option selected>Choose...</option>
                                        <option value="1">Paid</option>
                                        <option value="2">Awaiting Authorization</option>
                                        <option value="3">Payment failed</option>
                                        <option value="4">Cash On Delivery</option>
                                        <option value="5">Fulfilled</option>
                                        <option value="6">Unfulfilled</option>
                                    </select>
                                </div>
                            </form>
                        </div>
                        <div class="col-lg-4">
                            <div class="text-lg-right">
                                <button type="button" class="btn btn-light mb-2">Export</button>
                            </div>
                        </div><!-- end col-->
                    </div>

                    <div class="table-responsive">
                        <table class="table table-centered mb-0">
                            <thead class="thead-light">
                            <tr>
                                <th>Order ID</th>
                                <th>Shipping Date</th>
                                <th>Total</th>
                                <th>Payment Method</th>
                                <th>Delivery Method</th>
                                <th>Order Status</th>
                                <th style="width: 125px;">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($orders as $key=> $order)
                                <tr>
                                    <td><a href="{{route('admin.orders.detail',['id' => $order->id])}}"
                                           class="text-body font-weight-bold">{{$order->hash_order_id}}</a></td>
                                    <td>
                                        {{$order->shipping_date . " " . $order->shipping_hours}}
                                    </td>
                                    <td>
                                        {!! \App\Helpers\Common::getFormatNumberPrice($order->total_price) !!}
                                    </td>
                                    <td>
                                        <h5>{{$order->paymentMethod->name}}</h5>
                                    </td>
                                    <td>
                                        @if($order->delivery_method === \App\Models\Order::PICK_STORE)
                                            <h5>Đến lấy tại cửa hàng</h5>
                                        @else
                                            <h5>Giao hàng</h5>
                                        @endif
                                    </td>
                                    <td>
                                        {!! \App\Helpers\Common::checkOrderStatus($order->order_status) !!}

                                    </td>
                                    <td>
                                        <a href="{{route('admin.orders.detail',['id' => $order->id])}}" class="action-icon"> <i
                                                class="mdi mdi-eye"></i></a>
                                    </td>
                                </tr>

                            @endforeach


                            </tbody>
                        </table>
                    </div>
                </div> <!-- end card-body-->
            </div> <!-- end card-->
        </div> <!-- end col -->
    </div>

@endsection
