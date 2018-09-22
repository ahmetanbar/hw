<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\CrudTrait;

class Category extends Model
{
    use CrudTrait;

    protected $fillable = [
        'name'
    ];

    public function article()
    {
        return $this->hasMany('App\Models\Article','category_id');
    }

}
