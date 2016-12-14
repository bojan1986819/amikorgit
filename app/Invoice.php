<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
class Invoice extends Model
{

    public function products()
    {
        return $this->hasMany(InvoiceProduct::class);
    }
}
