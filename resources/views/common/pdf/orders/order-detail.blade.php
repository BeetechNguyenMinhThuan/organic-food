<!DOCTYPE html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8"/>
    <title>Nest - Multipurpose eCommerce HTML Template</title>
    <meta http-equiv="x-ua-compatible" content="ie=edge"/>
    <meta name="description" content=""/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <meta property="og:title" content=""/>
    <meta property="og:type" content=""/>
    <meta property="og:url" content=""/>
    <meta property="og:image" content=""/>
    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="{{asset('frontend/assets/imgs/theme/favicon.svg')}}"/>
    <link rel="stylesheet" href="{{asset('frontend/assets/css/main.css?v=5.3')}}"/>

</head>
<style>
    * {
        font-family: DejaVu Sans !important;
    }
</style>

<body>
<div class="invoice invoice-content invoice-3">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="d-flex justify-content-between">
                    <h3 class="text-center mb-2"> Hoá đơn {{$order->hash_order_id}} </h3>
                    <p>{{\Carbon\Carbon::now('Asia/Ho_Chi_Minh')->format('d/m/Y H:i:s')}}</p>
                </div>
                <div class="invoice-inner">
                    <div class="invoice-info" id="invoice_wrapper">
                        <div class="invoice-header">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="invoice-name">
                                    </div>
                                </div>
                                <div class="col-sm-6  text-end">
                                    <div class="invoice-numb">
                                        <h4 class="invoice-header-1 mb-10 mt-20">Invoice No: <span
                                                class="text-heading">{{$order->hash_order_id}}</span>
                                        </h4>
                                        <h6>Invoice Date: <span
                                                class="text-heading">{{\Carbon\Carbon::parse($order->created_at)->format('d/m/Y H:i:s')}}</span>
                                        </h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="invoice-top">
                            <div class="row">
                                <div class="col-lg-4 col-md-6">
                                    <div class="invoice-number">
                                        <h4 class="invoice-title-1 mb-10">Hoá đơn từ: </h4>
                                        <p class="invoice-addr-1">
                                            <strong>OrganicFood.com</strong> <br/>
                                            Hà Nội<br>
                                            <abbr title="Phone">Phone:</abbr> (+123) 456-7890<br>
                                            <abbr title="Email">Email: </abbr>contact@organicfood.com<br>
                                        </p>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-6">
                                    <div class="invoice-number">
                                        <h4 class="invoice-title-1 mb-10">Hoá đơn tới: </h4>
                                        <p class="invoice-addr-1">
                                            <strong>{{$order->user->fullname}}</strong> <br/>
                                            {{--                                            Madalinskiego 8<br>--}}
                                            {{--                                            71-101 Szczecin, Poland<br>--}}
                                            <abbr title="Phone">Phone:</abbr>{{$order->user->phone}}<br>
                                            <abbr title="Email">Email: </abbr>{{$order->user->email}}<br>
                                        </p>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-6">
                                    <div class="invoice-number">
                                        <h4 class="invoice-title-1 mb-10">Tổng quát:</h4>
                                        <p class="invoice-addr-1">
                                            <strong>Thời gian thanh
                                                toán:</strong> {{\Carbon\Carbon::parse($order->created_at)->format('d/m/Y H:i:s')}}
                                            <br/>
                                            <strong>Due Data:</strong> Aug 27, 2022<br/>
                                            <strong>Phương thức thanh
                                                toán</strong>
                                            <span>{{$order->paymentMethod->name}}</span><br/>
                                            <strong>
                                                Hình thức nhận hàng: <br>
                                            </strong>
                                            <span>{{$order->formatDeliveryMethod()}}</span>
                                        @if($order->payment)
                                            <p>
                                                <strong>
                                                    Mã ngân hàng: <span>{{$order->payment->bank_code}}</span>
                                                </strong>
                                            </p>
                                            <p>
                                                <strong>
                                                    Mã giao dịch tại VNPAY: {{$order->payment->vnpay_code}}
                                                </strong>
                                            </p>
                                        @endif
                                        <strong>Trạng thái: </strong> <span
                                            class="text-brand">{!! \App\Helpers\Common::checkOrderStatus($order->order_status) !!}</span>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="invoice-center">
                            <div class="table-responsive">
                                <table class="table table-striped invoice-table">
                                    <thead class="bg-active">
                                    <tr>
                                        <th>{{trans('messages.common.product')}}</th>
                                        <th class="text-center">{{trans('messages.cart.unit_price')}}</th>
                                        <th class="text-center">{{trans('messages.common.quantity')}}</th>
                                        <th class="text-right">{{trans('messages.cart.sub_total')}}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @php
                                        $listOrder = $order->orderDetail;
                                    @endphp
                                    @foreach($listOrder as $orderDetail)
                                        <tr>
                                            <td>
                                                <div class="item-desc-1">
                                                    <span>{{$orderDetail->product->name}}</span>
                                                    <small>SKU: {{$orderDetail->product->sku}}</small>
                                                </div>
                                            </td>
                                            <td class="text-center">{!! $orderDetail->product->formatPrice() !!}</td>
                                            <td class="text-center">{{$orderDetail->quantity}}</td>
                                            <td class="text-right">{!! \App\Helpers\Common::getFormatNumberPrice($orderDetail->sub_total) !!}</td>
                                        </tr>

                                    @endforeach
                                    <tr>
                                        <td colspan="3"
                                            class="text-end f-w-600">{{trans('messages.cart.sub_total')}}</td>
                                        <td class="text-right">{!! \App\Helpers\Common::getFormatNumberPrice($order->sub_total) !!}</td>
                                    </tr>
                                    {{--                                    <tr>--}}
                                    {{--                                        <td colspan="3" class="text-end f-w-600">Tax</td>--}}
                                    {{--                                        <td class="text-right">$85.99</td>--}}
                                    {{--                                    </tr>--}}
                                    <tr>
                                        <td colspan="3"
                                            class="text-end f-w-600">{{trans('messages.cart.total')}}</td>
                                        <td class="text-right f-w-600">{!! \App\Helpers\Common::getFormatNumberPrice($order->total_price) !!}</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="invoice-bottom">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div>
                                        <h3 class="invoice-title-1">Important Note</h3>
                                        <ul class="important-notes-list-1">
                                            <li>All amounts shown on this invoice are in US dollars</li>
                                            <li>finance charge of 1.5% will be made on unpaid balances after 30 days.
                                            </li>
                                            <li>Once order done, money can't refund</li>
                                            <li>Delivery might delay due to some external dependency</li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-offsite">
                                    <div class="text-end">
                                        <p class="mb-0 text-13">Thank you for your business</p>
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
<!-- Vendor JS-->
<script src="{{asset('frontend/assets/js/vendor/modernizr-3.6.0.min.js')}}"></script>
<script src="{{asset('frontend/assets/js/vendor/jquery-3.6.0.min.js')}}"></script>

</body>

</html>
