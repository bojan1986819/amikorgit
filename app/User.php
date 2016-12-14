<?php

namespace App;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class User extends Model implements Authenticatable
{
    use \Illuminate\Auth\Authenticatable;
    public function posts()
    {
        return $this->hasMany('App\Post');
    }

    public function products()
    {
        return $this->hasMany('App\Product');
    }

    public function isAdmin()
    {
        return $this->admin; // this looks for an admin column in your users table
    }
}
