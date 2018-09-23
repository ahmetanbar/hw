<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    public function article()
    {
        return $this->hasMany('App\Models\Article','category_id');
    }
}
