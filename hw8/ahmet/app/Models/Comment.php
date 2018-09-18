<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\CrudTrait;

class Comment extends Model
{
    use CrudTrait;

    protected $table='comments';
    public $timestamps=true;

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function comment()
    {
        return $this->belongsTo('App\User');
    }
}
