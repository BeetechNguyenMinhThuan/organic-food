<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductReview extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function handleStatus()
    {
        $routeName = route('admin.comment.changeStatus',['productId' => $this->product_id,'commentId' => $this->comment_id]);
        $html = "<a href='$routeName' class='btn btn-danger'>Bỏ duyệt</a>";
        if ($this->status == 1) {
            $html = "<a href='$routeName' class='btn btn-success'>Duyệt</a>";
        }
        return $html;
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function product(){
        return $this->belongsTo(Product::class);
    }

    public function childrenComment(){
        return $this->hasMany(ProductReview::class,'parent_comment');
    }

    public function admin(){
        return $this->belongsTo(Admin::class,'censorship_user_id');

    }
}
