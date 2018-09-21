<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\CrudTrait;

class Article extends Model
{
    use CrudTrait;

    protected $fillable = [
        'author_id', 'header','article','category',
    ];


    public function comments()
    {
        return $this->hasMany('App\Comment');
    }

    public function user()
    {
        return $this->belongsTo('App\User','author_id');
    }
}
