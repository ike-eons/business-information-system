<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Product;

class Inventory extends Model
{
    protected $table = 'inventories';

    protected $guarded = [];

    public function product()
    {
       return $this->belongsTo(Product::class);
    }
}
