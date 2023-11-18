@php
    $orderDetail = $order->orderDetail;
@endphp
<div class="card">
    <div class="card-body">
        <h4 class="header-title mb-3">{{trans('messages.profile.order_history.order_hash')}} {{$order->hash_order_id}}</h4>

        <div class="table-responsive">
            <table class="table mb-0">
                <thead class="thead-light">
                <tr>
                    <th class="pl-20" scope="col">{{trans('messages.common.product')}}</th>
                    <th scope="col">{{trans('messages.common.quantity')}}</th>
                    <th scope="col">{{trans('messages.cart.unit_price')}}</th>
                    <th scope="col">{{trans('messages.cart.sub_total')}}</th>
                    <th scope="col">{{trans('messages.cart.total')}}</th>
                </tr>
                </thead>
                <tbody>
                @foreach($orderDetail as $orderItem)
                    <tr>
                        <td class="pl-20 d-flex align-items-center gap-3">
                            <img class="rounded-circle" height="100px" width="100px"
                                 src="{{asset('/storage/' . $orderItem->product->avatar)}}" alt="">
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
        <h4 class="mt-20" style="float: right">{{trans('messages.cart.total')}}: <strong
                class="text-brand">{!!\App\Helpers\Common::getFormatNumberPrice($order->total_price) !!}</strong></h4>
        <!-- end table-responsive -->
    </div>
</div>
