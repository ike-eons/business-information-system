<?php

namespace App\Models;

use App\Models\StockItem;
use App\Models\Distributor;
// use App\Traits\HasManyRelation;

use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    // use HasManyRelation;

    protected $table = 'stocks';
    


    protected $guarded = [];

    public function distributor()
    {
        return $this->belongsTo(Distributor::class);
    }

    public function stock_items()
    {
        return $this->hasMany(StockItem::class);
    }
}
