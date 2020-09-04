<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::prefix('/user')->group( function(){
    Route::post('/login','api\v1\LoginController@login');
    // Route::middleware('auth:api')->get('/all','Admin\UserController@login');
    Route::group(['middleware' => ['auth:api'] ], function () {

        Route::get('/all','Admin\UserController@index');
        Route::get('/currentUser','Admin\UserController@currentUser');
        Route::get('/inventory', 'API\InventoryController@index');
        Route::get('/all_inventory', 'API\InventoryController@all');
        Route::get('/transactions', 'API\InventoryController@transactions');
        Route::get('/customer_products/{id}',
                    'API\CustomerController@get_products_from_invoice_items');
        Route::get('/stock_graph','API\StockController@stock_graph');
        Route::get('/daily_invoice_graph','API\InvoiceController@daily_invoice_graph');


        Route::apiResources([
            'brands'        =>  'API\BrandController',
            'customers'     =>  'API\CustomerController',
            'categories'    =>  'API\CategoryController',
            'products'      =>  'API\ProductController',
            'stocks'        =>  'API\StockController',
            'invoices'      =>  'API\InvoiceController',
            'distributors'  =>  'API\DistributorController'
        ]);

        // Route::get('load_stock_form','API\StockController@load_stock_form');
        // Route::get('load_invoice_form','API\InvoiceController@load_invoice_form');

    });
});
