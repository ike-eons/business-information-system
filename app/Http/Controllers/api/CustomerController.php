<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Invoice;
use App\Models\Customer;
use App\Models\Product;

use Illuminate\Http\Response;
use Psy\Util\Json;

class CustomerController extends Controller
{
    
    public function index()
    {
        $customers = Customer::latest()->get();
        return response()->json([
            'customers' => $customers
        ]);
    }
    
    public function store(Request $request)
    {
        //validate customer data
        $request->validate([
            'firstname' =>  'required',
            'lastname'  => 'required',
            'phone'     => 'required| unique:customers',
            'shop_name' => 'required',
            'shop_address'  => 'required'
            
        ]);

        $customer = Customer::create([
            'firstname' => $request['firstname'],
            'lastname'  => $request['lastname'],
            'phone'     => $request['phone'],
            'shop_name' => $request['shop_name'],
            'shop_address'  => $request['shop_address']
        ]);
    
        return [ 'message'=>'customer created',
                'customer'  =>$customer 
            ];
    }

   
    public function show($id)
    {
        $customer = Customer::with(['invoices','payments'])->findOrFail($id);

        return ['customer'=>$customer];
    }

    public function get_products_from_invoice_items($id)
    {
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

        $new_array=[];

        foreach($target_products as $key=>$value)
        {
            $product = Product::find($key);
            $product_name = $product->name;

            $new_array[$product_name] = $value;
        }

        return response()->json([
            'target_products' => $new_array
        ]);
    }

    public function update(Request $request, $id)
    {
        $customer = Customer::findOrFail($id);

       //validate customer data
       $request->validate([
            'firstname' =>  'required',
            'lastname'  => 'required',
            'phone'     => 'required',
            'shop_name' => 'required',
            'shop_address'  => 'required'
        ]);

        $customer->update($request->all());

        return ['message'=>'customer updated'];
    }

    public function destroy($id)
    {
         $customer = Customer::findOrFail($id);
         $customer->delete();

         return response(null,Response::HTTP_NO_CONTENT);
    }
}
