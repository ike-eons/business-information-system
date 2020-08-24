<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\Invoice;
use App\Models\Inventory;

class DashboardController extends Controller
{
    public function index(){
        $customers = count(Customer::all());
        $invoices = count(Invoice::all());

        $inventories = Inventory::all();

        $total_inventory = 0;
        $total_quantity = 0;

        foreach($inventories as $inventory)
        {
            $total_inventory += $inventory->available_amount;
            $total_quantity += $inventory->available_quantity;
        }

        return[
            'customers' => $customers,
            'invoices' => $invoices,
            'total_quantity' => $total_quantity,
            'total_inventory' => $total_inventory 
        ];
    }
    
}
