<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    public function comments()
    {
        return $this->hasMany('App\Comment');
    }

    public function user()
    {
        return $this->belongsTo('App\User','author_id');
    }

    public function category()
    {
        return $this->belongsTo('App\Models\Category','category_id');
    }
}
