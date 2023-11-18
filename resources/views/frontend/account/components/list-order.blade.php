<table
    class="table table-wishlist">
    <thead>
    <tr class="main-heading">
        <th class="pl-20">#</th>
        <th scope="col">{{trans('messages.profile.order_history.order_id')}}</th>
        <th scope="col">{{trans('messages.profile.order_history.date')}}</th>
        <th scope="col">{{trans('messages.profile.order_history.status')}}</th>
        <th scope="col">{{trans('messages.profile.order_history.total')}}</th>
        <th scope="col">{{trans('messages.profile.order_history.action')}}</th>
    </tr>
    </thead>
    <tbody>
    @foreach($orders as $index => $order)
        <tr class="pt-30">
            <td class="pl-20">{{$index + 1 }}</td>
            <td>{{$order->hash_order_id}}</td>
            <td>{{\Carbon\Carbon::parse($order->created_at)->format('d/m/Y H:i:s')}}</td>
            <td>
                {!! \App\Helpers\Common::checkOrderStatus($order->order_status) !!}
            </td>
            <td>
                {!! \App\Helpers\Common::getFormatNumberPrice($order->total_price) !!}
            </td>
            <td class="action text-center">
                <a href="#"
                   class="btn-small d-block action-view-order"
                   data-bs-toggle="modal"
                   data-bs-target="#modalOrderDetail{{$index}}"><i
                        class="d-inline-block fi-rs-eye"
                        style="margin-right: 2px"></i>{{trans('messages.profile.order_history.view')}}
                </a>
            </td>
            <!-- Modal view Order Detail -->
            <td>
                <div class="modal fade" id="modalOrderDetail{{$index}}"
                     tabindex="-1"
                     aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-xl">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-4 w-100 text-center"
                                    id="exampleModalLabel">
                                    {{trans('messages.profile.order_history.order_detail')}}
                                </h1>
                                <button type="button" class="btn-close"
                                        data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                @include('frontend.account.components.list-order-detail')
                            </div>
                            <div class="modal-footer">
                                <button type="button"
                                        class="btn btn-secondary"
                                        data-bs-dismiss="modal">{{trans('messages.common.close')}}
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </td>
        </tr>

    @endforeach
    </tbody>
</table>
