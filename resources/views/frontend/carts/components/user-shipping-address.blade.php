@if(!empty($cartShippingAddress) && $cartShippingAddress->isNotEmpty())
    <div class="box-log">
        <div class="list-account-shipping">
            <input type="hidden" name="user_address_id" value=""/>
            @foreach($cartShippingAddress as $address)
                <div class="form-check shipping-address-item" data-address="{{$address->id}}">
                    <label for="" class="form-check-label">
                        <input type="radio" name="shipping-account"
                               class="shipping-account form-check-input">
                        <div class="text-name">
                            <i class="fa fa-user" aria-hidden="true"></i>
                            <span
                                class="pl-10">{{$address->receiver_first_name . " " .$address->receiver_last_name}}</span>
                        </div>
                        <div class="text-address">
                            <i class="fa fa-map-marker" aria-hidden="true"></i>
                            <span class="pl-10">{{$address->address}}</span>
                        </div>
                        <div class="text-phone">
                            <i class="fa fa-phone" aria-hidden="true"></i>
                            <span class="pl-10">{{$address->phone_number}}</span>
                        </div>
                        <div class="edit-info">
                            <i class="fa fa-pencil" aria-hidden="true"></i>
                            <a href="" class="add-address-shipping">{{trans('messages.common.edit')}}</a>
                        </div>
                    </label>
                </div>
            @endforeach
        </div>
    </div>
@endif
