<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\CrudTrait;

class Article extends Model
{
    use CrudTrait;

    protected $fillable = [
        'author_id', 'header','article','category_id',
    ];


    public function comments()
    {
        return $this->hasMany('App\Models\Comment');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User','author_id');
    }

    public function category()
    {
        return $this->belongsTo('App\Models\Category','category_id');
    }
}
