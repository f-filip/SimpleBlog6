<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    public $guarded = [];

    public function posts()
    {
        return $this->belongsToMany(Tag::class);
    }
}
