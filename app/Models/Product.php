<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    /**
     * Get Category of Product
     *
     * @return BelongsTo
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Handle avatar product
     *
     * @return string
     */
    protected function avatar(): Attribute
    {
        return Attribute::make(
            get: fn($value) => file_exists("upload/product/{$value}") && !empty($value) ? "upload/product/{$value}" : "img/default.png",
        );
    }

    protected function price(): Attribute
    {
        return Attribute::make(
            set: fn($value) => implode("", explode(",", $value)),
        );
    }

    /**
     * Get orders of product
     *
     * @return BelongsToMany
     */
//    public function orders()
//    {
//        return $this->belongsToMany(Order::class, 'order_detail')->withPivot('quantity', 'price');
//    }
}
