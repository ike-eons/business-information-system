<?php

use Illuminate\Database\Seeder;

use App\Models\Product;

class ProductTableSeeder extends Seeder
{
    protected $products = [
    
        [
            'id'                =>  1,
            'brand_id'          =>  1,
            'category_id'       =>  1,
            'description'       =>  'Carnation tea creamer',
            'name'              =>  'Carnation TC 24*160g',
            'weight'            =>  160,
            'carton_quantity'   =>  24,
            'stock_price'       =>  54.38,
            'sales_price'       => 55
        ],
        [
            'id'                =>  2,
            'brand_id'          =>  1,
            'category_id'       =>  3,
            'description'       =>  'Cerelac Fruit mix tin',
            'name'              =>  'Cerelac 3Frt 12*400g',
            'weight'            =>  400,
            'carton_quantity'   =>  12,
            'stock_price'       =>  147.12,
            'sales_price'       =>  148.00
            
        ],
        [
            'id'                =>  3,
            'brand_id'          =>  1,
            'category_id'       =>  3,
            'description'       =>  'Cerelac fruit sachet',
            'name'              =>  'Cerelac 3Frt 80*50g',
            'weight'            =>  50,
            'carton_quantity'   =>  80,
            'stock_price'       =>  122.58,
            'sales_price'       => 123
            
        ],
        [
            'id'                =>  4,
            'brand_id'          =>  1,
            'category_id'       =>  3,
            'description'       =>  'Cerelac Biscuity Tin',
            'name'              =>  'Cerelac Biscuity 12*400g',
            'weight'            =>  50,
            'carton_quantity'   =>  80,
            'stock_price'       =>  139.2,
            'sales_price'       => 140.00,
        ],
        [
            'id'                =>  5,
            'brand_id'          =>  1,
            'category_id'       =>  3,
            'description'       =>  'Cerelac Biscuity Sachet',
            'name'              =>  'Cerelac Biscuity 80*50g',
            'weight'            =>  400,
            'carton_quantity'   =>  12,
            'stock_price'       =>  139.18,
            'sales_price'       => 140,
        ],
        [
            'id'                =>  6,
            'brand_id'          =>  1,
            'category_id'       =>  3,
            'description'        =>  'Cerelac Maize Tin',
            'name'              =>  'Cerelac Maize 12* 400g            ',
            'weight'            =>  26,
            'carton_quantity'   =>  120,
            'stock_price'       =>  178.00,
            'sales_price'       => 179.00,
        ],
        [
            'id'                =>  7,
            'brand_id'          =>  1,
            'category_id'       =>  3,
            'description'       =>  'Cerelac Maize sachet',
            'name'              =>  'Cerelac Maize 80*50g            ',
            'weight'            =>  50,
            'carton_quantity'   =>  80,
            'stock_price'       =>  122.49,
            'sales_price'       =>  123,
        ],
        [
            'id'                =>  8,
            'brand_id'          =>  1,
            'category_id'       =>  3,
            'description'       =>  'Cerelac Millet Tin',
            'name'              =>  'Cerelac Millet 12*400g            ',
            'weight'            =>  400,
            'carton_quantity'   =>  12,
            'stock_price'       =>  139.18,
            'sales_price'       =>  140.00,
        ],
        [
            'id'                =>  9,
            'brand_id'          =>  1,
            'category_id'       =>  3,
            'description'       =>  'Cerelac Millet Sachet     ',
            'name'              =>  'Cerelac Millet 80*50g            ',
            'weight'            =>  50,
            'carton_quantity'   =>  80,
            'stock_price'       =>  122.49,
            'sales_price'       =>  123
        ],
        [
            'id'                =>  10,
            'brand_id'          =>  1,
            'category_id'       =>  3,
            'description'               =>  '',
            'name'              =>  'Cerelac Rice 12*400g ',
            'weight'            =>  400,
            'carton_quantity'   =>  12,
            'stock_price'       =>  140.06,
            'sales_price'       => 141.00,
        ],
        [
            'id'                =>  11,
            'brand_id'          =>  1,
            'category_id'       =>  3,
            'description'               =>  '',
            'name'              =>  'Cerelac Rice 80*50g',
            'weight'            =>  50,
            'carton_quantity'   =>  80,
            'stock_price'       =>  122.58,
            'sales_price'       =>  123.00,
        ],
        [
            'id'                =>  12,
            'brand_id'          =>  1,
            'category_id'       =>  3,
            'description'               =>  '',
            'name'              =>  'Cerelac Wheat 12*400g ',
            'weight'            =>  400,
            'carton_quantity'   =>  12,
            'stock_price'       =>  139.18,
            'sales_price'       => 140.00
        ],
        [
            'id'                =>  13,
            'brand_id'          =>  1,
            'category_id'       =>  3,
            'description'               =>  '',
            'name'              =>  'Cerelac Wheat 80*50g',
            'weight'            =>  50,
            'carton_quantity'   =>  80,
            'stock_price'       =>  122.49,
            'sales_price'       => 123
        ],
        [
            'id'                =>  14,
            'brand_id'          =>  1,
            'category_id'       =>  2,
            'description'       =>  'Chocolim Big size 1kg',
            'name'              =>  'Chocolim 12*1kg',
            'weight'            =>  1000,
            'carton_quantity'   =>  12,
            'stock_price'       =>  225,
            'sales_price'       => 256.00,
        ],
        [
            'id'                =>  15,
            'brand_id'          =>  1,
            'category_id'       =>  2,
            'description'       =>  'Chocolim Medium size 500g',
            'name'              =>  'Chocolim 20*500g            ',
            'weight'            =>  500,
            'carton_quantity'   =>  20,
            'stock_price'       =>  190.95,
            'sales_price'       => 191
        ],
        [
            'id'                =>  16,
            'brand_id'          =>  1,
            'category_id'       =>  1,
            'description'       =>  '',
            'name'              =>  'Ideal  24* 390g Orig ',
            'weight'            =>  390,
            'carton_quantity'   =>  24,
            'stock_price'       =>  171.33,
            'sales_price'       => 172
        ],
        [
            'id'                =>  17,
            'brand_id'          =>  1,
            'category_id'       =>  1,
            'description'               =>  '',
            'name'              =>  'Ideal Diary Delight 12*10*26g ',
            'weight'            =>  26,
            'carton_quantity'   =>  120,
            'stock_price'       =>  378.00,
            'sales_price'       => 379.00
        ],
        [
            'id'                =>  18,
            'brand_id'          =>  1,
            'category_id'       =>  1,
            'description'       =>  'Ideal Milk small size',
            'name'              =>  'Ideal Milk 24*160g            ',
            'weight'            =>  160,
            'carton_quantity'   =>  24,
            'stock_price'       =>  86.90,
            'sales_price'       => 87
        ],
        [
            'id'                =>  19,
            'brand_id'          =>  1,
            'category_id'       =>  1,
            'description'               =>  '',
            'name'              =>  'Ideal Milky Choco 8*10*37g ',
            'weight'            =>  37,
            'carton_quantity'   =>  80,
            'stock_price'       =>  84.27,
            'sales_price'       =>  85
        ],
        [
            'id'                =>  20,
            'brand_id'          =>  1,
            'category_id'       =>  1,
            'description'               =>  '',
            'name'              =>  'Ideal Value 24*390g  ',
            'weight'            =>  600,
            'carton_quantity'   =>  24,
            'stock_price'       =>  141.71,
            'sales_price'       =>  142
        ],
        [
            'id'                =>  21,
            'brand_id'          =>  1,
            'category_id'       =>  1,
            'description'               =>  '',
            'name'              =>  'Ideal Value 24*390g',
            'weight'            =>  390,
            'carton_quantity'   =>  24,
            'stock_price'       =>  141.71,
            'sales_price'       =>  142
        ],
        [
            'id'                =>  22,
            'brand_id'          =>  1,
            'category_id'       =>  1,
            'description'               =>  '',
            'name'              =>  'Lactogen 1 24*400g',
            'weight'            =>  400,
            'carton_quantity'   =>  24,
            'stock_price'       =>  535.79,
            'sales_price'       => 536
        ],
        [
            'id'                =>  23,
            'brand_id'          =>  1,
            'category_id'       =>  1,
            'description'               =>  '',
            'name'              =>  'Lactogen 2 24*400g',
            'weight'            =>  400,
            'carton_quantity'   =>  24,
            'stock_price'       =>  535.79,
            'sales_price'       => 536
        ],
        [
            'id'                =>  24,
            'brand_id'          =>  1,
            'category_id'       =>  4,
            'description'               =>  '',
            'name'              =>  'Maggi Chicken Tab 24(60*10g)      ',
            'weight'            =>  10,
            'carton_quantity'   =>  24,
            'stock_price'       =>  247.34,
            'sales_price'       =>  248
        ],
        [
            'id'                =>  25,
            'brand_id'          =>  1,
            'category_id'       =>  4,
            'description'               =>  '',
            'name'              =>  'Maggi Dedeede 24(60*10g)            ',
            'weight'            =>  10,
            'carton_quantity'   =>  24,
            'stock_price'       =>  311.65,
            'sales_price'       =>  312
        ],
        [
            'id'                =>  26,
            'brand_id'          =>  1,
            'category_id'       =>  4,
            'description'               =>  '',
            'name'              =>  'Maggi Shrimp Tab 24(60*10g)            ',
            'weight'            =>  10,
            'carton_quantity'   =>  24,
            'stock_price'       =>  234.43,
            'sales_price'       =>  235
        ],
        [
            'id'                =>  27,
            'brand_id'          =>  1,
            'category_id'       =>  4,
            'description'               =>  '',
            'name'              =>  'Maggi Tablet 24(60*10g)            ',
            'weight'            =>  10,
            'carton_quantity'   =>  24,
            'stock_price'       =>  247.34,
            'sales_price'       =>  248
        ],
        [
            'id'                =>  28,
            'brand_id'          =>  1,
            'category_id'       =>  2,
            'description'               =>  '',
            'name'              =>  'Milo 12*800g
            ',
            'weight'            =>  800,
            'carton_quantity'   =>  12,
            'stock_price'       =>  268.51,
            'sales_price'       =>  269
        ],
        [
            'id'                =>  29,
            'brand_id'          =>  1,
            'category_id'       =>  2,
            'description'               =>  '',
            'name'              =>  'Milo 30*10*20g            ',
            'weight'            =>  20,
            'carton_quantity'   =>  30,
            'stock_price'       =>  172.12,
            'sales_price'       =>  173
        ],
        [
            'id'                =>  30,
            'brand_id'          =>  1,
            'category_id'       =>  2,
            'description'               =>  '',
            'name'              =>  'Milo 40*200g            ',
            'weight'            =>  200,
            'carton_quantity'   =>  40,
            'stock_price'       =>  279.56,
            'sales_price'       =>  280
        ],
        [
            'id'                =>  31,
            'brand_id'          =>  1,
            'category_id'       =>  2,
            'description'               =>  '',
            'name'              =>  'Milo 12*1kg       ',
            'weight'            =>  1000,
            'carton_quantity'   =>  12,
            'stock_price'       =>  301.10,
            'sales_price'       =>  302
        ],
        [
            'id'                =>  32,
            'brand_id'          =>  1,
            'category_id'       =>  2,
            'description'               =>  '',
            'name'              =>  'Milo All in One 10*20*40g            ',
            'weight'            =>  40,
            'carton_quantity'   =>  20,
            'stock_price'       =>  246,
            'sales_price'       =>  247
        ],
        [
            'id'                =>  33,
            'brand_id'          =>  1,
            'category_id'       =>  5,
            'description'               =>  '',
            'name'              =>  'Milo Energy Cube 40(50*2.75g) ',
            'weight'            =>  2.75,
            'carton_quantity'   =>  40,
            'stock_price'       =>  159.14            ,
            'sales_price'       =>  247
        ],
        [
            'id'                =>  34,
            'brand_id'          =>  2,
            'category_id'       =>  5,
            'description'               =>  '',
            'name'              =>  'Milo RTD( Energy Drink)24*235ml',
            'weight'            =>  23.5,
            'carton_quantity'   =>  24,
            'stock_price'       =>  78.45           ,
            'sales_price'       =>  79
        ],
       
        
    ];


    public function run()
    {
         foreach ($this->products as $index => $product)
        {
            $result = Product::create($product);
            if (!$result) {
                $this->command->info("Insert failed at record $index.");
                return;
            }
            InventoryTableSeeder::setInventory($product['id'],0,0.00);
        }
        $this->command->info('Inserted '.count($this->products). ' records');
    }
}
