<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Inventory;
use App\Models\Transaction;

class InventoryController extends Controller
{
    public function index()
    {
        $inventories = Inventory::all();

        $total_inventory = 0;
        $total_quantity = 0;

        foreach($inventories as $inventory)
        {
            $total_inventory += $inventory->available_amount;
            $total_quantity += $inventory->available_quantity;
        }

        return [
            'total_quantity' => $total_quantity,
            'total_inventory' => $total_inventory 
        ];

    }

    public function all()
    {
        $inventories = Inventory::with(['product'])->get();

        return ['inventories' => $inventories];
    }

    public function transactions()
    {
        $transactions = Transaction::latest()->get();
        return ['transactions'=>$transactions];
    }
}
