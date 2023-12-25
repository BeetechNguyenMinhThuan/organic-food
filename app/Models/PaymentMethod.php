<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentMethod extends Model
{
    use HasFactory;
    protected $table = "payment_method";
    protected $guarded = [];

    // Payment Method
    const COD = 1;
    const BANK_TRANSFER = 2;
    const VN_PAY = 3;
    const MOMO = 4;
}
