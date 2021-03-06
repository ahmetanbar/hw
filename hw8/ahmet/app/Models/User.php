<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\CrudTrait;

class User extends Model
{
    use CrudTrait;

    protected $fillable = [
        'name', 'surname','username','email', 'password', 'role',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    public function article()
    {
        return $this->hasMany('App\Models\Article','author_id');
    }

    public function comments()
    {
        return $this->hasMany('App\Models\Comment');
    }

}
