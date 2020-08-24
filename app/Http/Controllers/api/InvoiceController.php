<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\Counter;
use Illuminate\Support\Facades\DB;

class InvoiceController extends Controller
{
   
    public function index()
    {
        $invoices = Invoice::with('customer')->latest()->get();

        return response()->json([
            'invoices'  => $invoices
        ],200);
    }

   
    public function store(Request $request)
    {
        // $request->validate([
        //     'customer_id' => 'required|integer|exists:customers,id',
        //     'date' => 'required|date_format:Y-m-d',
        //     'due_date' => 'required|date_format:Y-m-d',
        //     'reference' => 'nullable|max:100',
        //     'total'     => 'required',
        //     'invoice_items' => 'required|array|min:1',
        //     'invoice_items.*.product_id' => 'required|integer',
        //     'invoice_items.*.unit_price' => 'required|numeric|min:0',
        //     'invoice_items.*.quantity' => 'required|integer|min:1'
        // ]);

        $counter = Counter::where('key', 'invoice')->first();
        $new_counter = $counter->prefix. $counter->value;

        $invoice = new Invoice();
        $invoice->customer_id = $request->customer_id;
        $invoice->date    =   $request->date;
        $invoice->counter_number = $new_counter;
        $invoice->total   =   $request->total;
        $invoice->save();
        
        foreach($request->invoice_items as $item) {
           $invoiceItem = new InvoiceItem();
           $invoiceItem->invoice_id = $invoice->id;
           $invoiceItem->product_id = $item['id'];
           $invoiceItem->unit_price = $item['unit_price'];
           $invoiceItem->quantity = $item['quantity'];
           $invoiceItem->save();

        }

        $counter->increment('value');

        // UPDATE INVENTORY ON INVOICE GENERATED

        foreach( $invoice->invoice_items as $item)
        {
            DB::table('inventories')->where('product_id',$item['product_id'])->update([
                'available_quantity' => DB::raw('available_quantity - ' . $item["quantity"]),
                'available_amount' => DB::raw('available_amount - ' . $item["unit_price"]),
            ]);

        }

        DB::table('transactions')->insert([
            'invoice_or_stock' => 'invoice',
            'number' => $invoice['counter_number'],
            'amount' => $invoice['total'],
            // 'create_at' => Carbon::now()
        ]);

        return [ 'message'=>'invoice created',
                    'invoice'  =>$invoice 
        ];
    }

    public function show($id)
    {
        $invoice = Invoice::with(['customer','invoice_items.product'])->findOrFail($id);
        // $customer_id = $invoice->customer_id;

        return response()->json([
            'invoice'   =>  $invoice,
        ],200);
    }

    public function daily_invoice_graph(){
        $invoices = Invoice::latest()->get();

        $target_invoices = [];


        foreach($invoices as $invoice)
        {
            $date = $invoice['date'];
            $total = $invoice['total'];

            if(array_key_exists($date,$target_invoices))
            {
                $old_total = $target_invoices[$date];
                $total += $old_total;
            }else{
                $total = $invoice['total'];
            }
            $target_invoices[$date] = $total;

        }
        return ['daily_sales' => $target_invoices];

    }


    public function update(Request $request, $id)
    {
        //
    }

   
    public function destroy($id)
    {
        //
    }
}
