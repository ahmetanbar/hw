<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class deneme extends Model
{
    protected $table='users';

    public $primaryKey='id';

    public $timestamps=true;
}
