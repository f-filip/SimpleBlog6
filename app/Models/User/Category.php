<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'category';

    public $guarded=[];
    
    public function posts()
    {
        return $this->hasMany(Post::class);
    }
}
