<table class="table table-wishlist cart-update-list">
    <thead>
    <tr class="main-heading">
        <th class="pl-20">#</th>
        <th scope="col">{{trans('messages.common.address')}}</th>
        <th scope="col">{{trans('messages.profile.receiver_name')}}</th>
        <th scope="col">{{trans('messages.profile.phone_number')}}</th>
        <th scope="col">{{trans('messages.common.action')}}</th>
    </tr>
    </thead>
    <tbody>
    @foreach($addressDelivery as $index => $address)
        <tr class="pt-30">
            <td class="pl-20">{{$index + 1 }}</td>
            <td>{{$address->address}}</td>
            <td>{{$address->fullname}}</td>
            <td>{{$address->phone_number}}</td>
            <td class="action text-center" data-title="Remove"><a href="#"
                                                                  data-url="{{route('account.deleteShippingAddress',['id' =>$address->id ])}}"
                                                                  data-id="{{$address->id}}"
                                                                  class="text-body delete-address-shipping"><i
                        class="fi-rs-trash"></i></a></td>
        </tr>

    @endforeach

    </tbody>
</table>
