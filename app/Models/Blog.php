<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function handleStatus()
    {
        $html = '<span class="badge badge-outline-danger badge-pill">Danger</span>';
        if ($this->status == 1) {
            $html = '<span class="badge badge-success-lighten badge-pill">Active</span>';
        }
        return $html;
    }
}
