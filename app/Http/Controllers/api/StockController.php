<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Stock;
use App\Models\Counter;
use App\Models\StockItem;
use Illuminate\Support\Facades\DB;

class StockController extends Controller
{
    
    public function index()
    {
        $stocks = Stock::with('distributor')->latest()->get();

        return response()->json([
            'stocks'    =>  $stocks
        ],200);
    }

    public function load_stock_form()
    {
        $counter = Counter::where('key', 'stock')->first();

        $form = [
            'number' => $counter->prefix . $counter->value,
            'distributor_id' => null,
            'date' => date('Y-m-d'),
            'total'=> 0,
            'reference' => null,
            'stock_items' => [
                [
                    'product_id' => null,
                    // 'product' => null,
                    'unit_price' => 0,
                    'quantity' => 1
                ]
            ]
        ];

        return response()
            ->json(['form' => $form]);
    }


    public function store(Request $request)
    {
        // $request->validate([
        //     'distributor_id' => 'required|integer|exists:distributors,id',
        //     'date' => 'required|date_format:Y-m-d',
        //     'reference' => 'required|nullable|max:30',
        //     'total'     => 'required',
        //     'stock_items' => 'required|array|min:1',
        //     'stock_items.*.product_id' => 'required|integer|exists:products,id',
        //     'stock_items.*.unit_price' => 'required|numeric|min:0',
        //     'stock_items.*.quantity' => 'required|integer|min:1'
        // ]);

        $counter = Counter::where('key', 'stock')->first();
        $new_counter = $counter->prefix. $counter->value;

        $stock = new Stock();
        $stock->distributor_id = $request->distributor_id;
        $stock->date    =   $request->date;
        $stock->reference  =  $request->reference;
        $stock->counter_number = $new_counter;
        $stock->total   =   $request->total;
        $stock->save();
        
        foreach($request->stock_items as $item) {
           $stockItem = new StockItem();
           $stockItem->stock_id = $stock->id;
           $stockItem->product_id = $item['id'];
           $stockItem->unit_price = $item['unit_price'];
           $stockItem->quantity = $item['quantity'];
           $stockItem->save();

        }

        $counter->increment('value');

        // UPDATE INVENTORY ON CURRENT STOCK
        foreach( $stock->stock_items as $item)
        {
            DB::table('inventories')->where('product_id',$item['product_id'])->update([
                'available_quantity' => DB::raw('available_quantity + ' . $item["quantity"]),
                'available_amount' => DB::raw('available_amount + ' . $item["unit_price"]),
            ]);
            
        }

        // UPDATE TRANSACTION TABLE
        DB::table('transactions')->insert([
            'invoice_or_stock' => 'stock',
            'number'    =>  $stock['counter_number'],
            'amount'    => $stock['total'],
            'date'      => $stock['date']
        ]);

        return response()
            ->json(['saved' => true, 'id' => $stock->id],200);

    }

    public function show($id)
    {
        $stock = Stock::with(['distributor','stock_items.product'])
                        ->findOrFail($id);

        return response()->json([
            'stock'   =>  $stock,
        ],200);
    }

    public function stock_graph(){
        $stocks = Stock::all();

        $target_stocks = [];


        foreach($stocks as $stock)
        {
            $date = $stock['date'];
            $total = $stock['total'];

            if(array_key_exists($date,$target_stocks))
            {
                $old_total = $target_stocks[$date];
                $total += $old_total;
            }else{
                $total = $stock['total'];
            }
            $target_stocks[$date] = $total;

        }
        return ['stock_intake' => $target_stocks];

    }

    public function update(Request $request, $id)
    {
        $stock = Stock::findOrFail($id);

        $request->validate([
            'distributor_id' => 'required|integer|exists:distributors,id',
            'date' => 'required|date',
            'reference' => 'nullable|max:100',
            'total' =>  'required|numeric|min:0',
            'stock_items' => 'required|array|min:1',
            'stock_items.*.id' => 'sometimes|required|integer|exists:stock_stock_items,id,stock_id,'.$stock->id,
            'stock_items.*.product_id' => 'required|integer|exists:products,id',
            'stock_items.*.unit_price' => 'required|numeric|min:0',
            'stock_items.*.quantity' => 'required|integer|min:1'
        ]);

        $stock->fill($request->except('stock_items'));

        // $stock->sub_total = collect($request->stock_items)->sum(function($stock_item) {
        //     return $stock_item['quantity'] * $stock_item['unit_price'];
        // });

        $stock = DB::transaction(function() use ($stock, $request) {
            // custom method from app/Helper/HasManyRelation
            $stock->updateHasMany([
                'stock_items' => $request->stock_items
            ]);

            return $stock;
        });

        return response()
            ->json(['saved' => true, 'id' => $stock->id]);
    }

    public function destroy($id)
    {
        //find stock
        $stock = Stock::findOrFail($id);

        //delete stock from delete
        $stock->stock_items()->delete();

        //delete stock
        $stock->delete();

        return response()
            ->json(['deleted' => true]);
    }
}
