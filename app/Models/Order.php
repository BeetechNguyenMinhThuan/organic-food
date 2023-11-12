<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $guarded = [];

    // Payment Method
    const CREDIT = 01;
    const PAYMENT_ON_DELIVERY = 02;
    const BANK_TRANSFER = 03;


    // Delivery Method
    const PICK_STORE = 1;
    const PICK_SHIP = 2;

    // Status Order
    const DELIVERED = 1;
    const PENDING = 2;
    const CANCELLED = 3;
    const SHIPPED = 4;
    const COMPLETED = 5;

    public function paymentMethod(){
        return $this->belongsTo(PaymentMethod::class,'payment_method');
    }

    public function orderDetail(){
        return $this->hasMany(OrderDetail::class);
    }
    public function user(){
        return $this->belongsTo(User::class);
    }
    public function userAddress(){
        return $this->belongsTo(UserAddress::class,'user_address_id');
    }

}
