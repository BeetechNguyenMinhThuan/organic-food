<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;
use Nette\FileNotFoundException;

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
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class, 'product_id');
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'product_tags', 'product_id', 'tag_id');
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class, 'brand_id');
    }

    /**
     * Handle avatar product
     *
     * @return string
     */
//    protected function avatar(): Attribute
//    {
//        return Attribute::make(
//            get: fn($value) => file_exists("upload/product/{$value}") && !empty($value) ? "upload/product/{$value}" : "img/default.png",
//        );
//    }

    protected function price(): Attribute
    {
        return Attribute::make(
            set: fn($value) => implode("", explode(",", $value)),
        );
    }

    public function getPrice($value = '') {
        if($this->price != '') {
            return $this->formatPrice($this->price,$value);
        }else{
            return 'Liên hệ';
        }
    }

    public function formatPrice($price)
    {
        if ($price == 0) {
            return "Liên hệ";
        } else {
            return number_format($price) . '<sup>₫</sup>';
        }
    }

    public function getImage($id, $typeImage = 'avatar')
    {
        try {
            $user = $this::withTrashed()->find($id, [$typeImage . ' as image']);
            if (empty($user)) {
                return response()->file(base_path() . '/public/images/user-default.png');
            }

//            if (empty($user->image)){
//                if ($user->gender == GenderEnum::MALE){
//                    $image = response()->file(base_path() . '/public/images/default-male.jpg');
//                }else if ($user->gender == GenderEnum::FEMALE){
//                    $image = response()->file(base_path() . '/public/images/default-female.jpg');
//                }else{
//                    $image = response()->file(base_path() . '/public/images/user-default.png');
//                }
//            } else {
//            }
            return Storage::disk(FILESYSTEM)->response($user->image);
        } catch (FileNotFoundException $e) {
            return null;
        }
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