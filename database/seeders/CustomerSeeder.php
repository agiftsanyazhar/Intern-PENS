<?php

namespace Database\Seeders;

use App\Models\Customer;
use Faker\Factory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $customers = [
            [
                'company_name' => 'Customer 1',
                'company_address' => Factory::create()->address . ' Cust 1',
                'company_email' => 'customer1@gmail.com',
                'company_phone' => Factory::create()->phoneNumber,
                'company_pic_name' => 'Customer PIC 1',
                'company_pic_address' => Factory::create()->address . ' PIC 1',
                'company_pic_email' => 'customerpic1@gmail.com',
                'company_pic_phone' => Factory::create()->phoneNumber,
            ],
            [
                'company_name' => 'Customer 2',
                'company_address' => Factory::create()->address . ' Cust 2',
                'company_email' => 'customer2@gmail.com',
                'company_phone' => Factory::create()->phoneNumber,
                'company_pic_name' => 'Customer PIC 2',
                'company_pic_address' => Factory::create()->address . ' PIC 2',
                'company_pic_email' => 'customerpic2@gmail.com',
                'company_pic_phone' => Factory::create()->phoneNumber,
            ],
            [
                'company_name' => 'Customer 3',
                'company_address' => Factory::create()->address . ' Cust 3',
                'company_email' => 'customer3@gmail.com',
                'company_phone' => Factory::create()->phoneNumber,
                'company_pic_name' => 'Customer PIC 3',
                'company_pic_address' => Factory::create()->address . ' PIC 3',
                'company_pic_email' => 'customerpic3@gmail.com',
                'company_pic_phone' => Factory::create()->phoneNumber,
            ],
        ];

        foreach ($customers as $customer) {
            Customer::create($customer);
        }
    }
}
