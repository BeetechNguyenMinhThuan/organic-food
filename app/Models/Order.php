<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $guarded = [];

    // Delivery Method
    const PICK_STORE = 1;
    const PICK_SHIP = 2;

    // Status Order
    const DELIVERED = 1;
    const PENDING = 2;
    const CANCELLED = 3;
    const SHIPPED = 4;
    const COMPLETED = 5;

    public function paymentMethod()
    {
        return $this->belongsTo(PaymentMethod::class, 'payment_method');
    }

    public function orderDetail()
    {
        return $this->hasMany(OrderDetail::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function userAddress()
    {
        return $this->belongsTo(UserAddress::class, 'user_address_id');
    }

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }

    public function formatDeliveryMethod()
    {

        $time = Carbon::parse($this->shipping_date)->format('d/m/Y') . " " . $this->shipping_hours;
        if ($this->delivery_method === Order::PICK_STORE) {
            return "Đến lấy tại cửa hàng" . "( $time )";
        }
        return "Giao hàng" . "( $time )";
    }

}
