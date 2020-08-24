<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $table = 'customers';

    protected $fillable = ['firstname','lastname','phone','shop_name','shop_address'];

    protected $appends = ['fullname'];

    public function getFullnameAttribute()
    {
        return $this->attributes['firstname']. ' - '.$this->attributes['lastname'];
    }

    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }
}
