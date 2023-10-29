<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Menu extends Model
{
    use HasFactory, SoftDeletes;
    protected $guarded = [];
    const MENU_PARENT_ID = 0;

    /**
     * Get Parent of a menu
     *
     * @return BelongsTo
     */
    public function parent()
    {
        return $this->belongsTo(Menu::class, 'parent_id');
    }

    /**
     * Get all children of a menu
     *
     * @return HasMany
     */
    public function children()
    {
        return $this->hasMany(Menu::class, 'parent_id');
    }
}
