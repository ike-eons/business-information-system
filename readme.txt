php artisan passport:install
php artisan vendor:publish --tag=passport-components

//$customer = DB::table('customers')->where('id',$invoice['customer_id'])->first();
// $invoice_items = DB::table('invoice_items')->where('invoice_id',$invoice['id'])->get();
// $invoice_items = InvoiceItem::where('invoice_id','=',$invoice['id']);