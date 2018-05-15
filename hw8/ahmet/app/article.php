<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class article extends Model
{
    protected $table='articles';
    protected $fillable=['auth_id','article','header','id','created_at','viewing','comments','category'];
}
