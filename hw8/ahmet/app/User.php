<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\CanResetPassword;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name', 'surname','username','email', 'password',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    public function article()
    {
        return $this->hasMany('App\Article','author_id');
    }
}
