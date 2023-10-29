<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $guarded = [];

    const CATEGORY_PARENT_ID = 0;

    /**
     * Get Parent of a category
     *
     * @return BelongsTo
     */
    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    /**
     * Get all children of a category
     *
     * @return HasMany
     */
    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    public function products(){
        return $this->hasMany(Product::class,'category_id');
    }
}
