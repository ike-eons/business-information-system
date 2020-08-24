<?php

use Illuminate\Database\Seeder;
use App\Models\Customer;

class CustomersTableSeeder extends Seeder
{
    
    protected $customers = [
        [
            'id'    => 1,
            'firstname' =>  'Ben',
            'lastname'  =>  'Yeboah',
            'phone'     => '0558780011',
            'shop_name' =>  'B-Yagola Shop',
            'shop_address'  => 'Sego-Lane, Adum-Kumasi'
        ],
        [
            'id'    => 2,
            'firstname' =>  'Gladys',
            'lastname'  =>  'Obour',
            'phone'     => '0202280034',
            'shop_name' =>  'Mama Stone\'s Shop',
            'shop_address'  => 'Central Market, Kejetia-Kumasi'
        ]
    ];

    public function run()
    {
        foreach($this->customers as $index => $customer)   
        {
            $result = Customer::create($customer);
            if(!$result)
                {
                    $this->command->info("Insert Failed at record $index.");
                    return;
                }
        }
        $this->command->info('Inserted'.count($this->customers).'records');
    }
}
