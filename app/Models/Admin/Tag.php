<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    public $guarded = [];

    public function posts()
    {
        return $this->belongsToMany(Tag::class);
    }
}
