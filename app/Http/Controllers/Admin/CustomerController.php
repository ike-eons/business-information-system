<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Customer;

class CustomerController extends Controller
{
    

    public function store(Request $request)
    {
        
    }

    public function update(Request $request, $id)
    {
        $customer = Customer::findOrFail($id);

       //validate customer data
       $request->validate([
            'firstname' =>  'required',
            'lastname'  => 'required',
            'phone'     => 'required| unique:customers',
            'shop_name' => 'required',
            'shop_address'  => 'required'
        ]);

        $subject->update($request->all());

        return ['message'=>'customer updated'];
    }

    public function destroy($id)
    {
         $customer = Customer::findOrFail($id);
         $customer->delete();

        return ['message' => 'customer deleted'];
    }
}
