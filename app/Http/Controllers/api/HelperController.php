<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Invoice;
use App\Models\Product;
use App\Models\Customer;

class HelperController extends Controller
{
    public function index($id)
    {
        //get_products_from_invoice_items
        $customer = Customer::findOrFail($id);
        $invoices = Invoice::where('customer_id', $customer['id'])->get();
        $products = Product::all();

        $target_products = [];

        foreach($invoices as $invoice)
        {
            foreach($invoice->invoice_items as $item)
            {
                $id = $item['product_id'];
                $quantity = $item['quantity'];
                if(array_key_exists($id,$target_products))
                {
                    $old_quantity = $target_products[$id];
                    $quantity += $old_quantity;
                }else{
                    $quantity = $item['quantity'];
                }
                $target_products[$id] = $quantity;
            }
            
        }

        return ['message'=>'ok'];

        // return ['target_products' => $target_products];
    }
}
