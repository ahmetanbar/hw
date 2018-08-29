<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class articles extends Model
{
    public $timestamps=true;


    public function comments()
    {
        return $this->hasMany('Comment');
    }

    public function author()
    {
        return $this->hasOne('App\User');
    }

}
