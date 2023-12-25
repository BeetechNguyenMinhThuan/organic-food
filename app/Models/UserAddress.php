<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserAddress extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function getFullNameAttribute()
    {
        return $this->attributes['receiver_first_name'] . ' ' . $this->attributes['receiver_last_name'];
    }
}
