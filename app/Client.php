<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $table='clients';

    public function products()
    {
        return $this->hasMany('App\Product');
    }

    public function invoice()
    {
        return $this->hasMany('App\Invoice');
    }

    public function task()
    {
        return $this->hasMany('App\Task');
    }
}
