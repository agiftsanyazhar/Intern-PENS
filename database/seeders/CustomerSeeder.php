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
        $customers = [];
        for ($i = 0; $i < 10000; $i++) {
            $customers[] = [
                'company_name' => 'Customer ' . $i,
                'company_address' => fake()->address . ' Customer ' . $i,
                'company_email' => 'customer' . $i . '@gmail.com',
                'company_phone' => fake()->phoneNumber,
                'company_pic_name' => 'Customer PIC ' . $i,
                'company_pic_address' => fake()->address . ' Customer PIC ' . $i,
                'company_pic_email' => 'customer-pic' . $i . '@gmail.com',
                'company_pic_phone' => fake()->phoneNumber,
            ];
        }

        foreach ($customers as $customer) {
            Customer::create($customer);
        }
    }
}
