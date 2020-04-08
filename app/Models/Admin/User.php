<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    public $guarded= ['password'];
    public function posts()
    {
        return $this->hasMany(post::class);
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }
}
