<?php

namespace App\Models;

use App\Models\Product;

use Illuminate\Database\Eloquent\Model;

class StockItem extends Model
{
    protected $fillable = [
        'product_id', 'unit_price', 'quantity'
    ];
    
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
