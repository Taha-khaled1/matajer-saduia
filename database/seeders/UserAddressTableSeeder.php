<?php

namespace Database\Seeders;

use App\Models\UserAddress;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserAddressTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
              UserAddress::create([
            'country' => 'مصر',
            'state' => 'California',
            'user_id' => 1,
            'city' => 'Los Angeles',
            'zip' => '90001',
            'address_1' => '123 Main Street',
            'address_2' => 'Apt 4',
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'phone' => '555-123-4567',
            'delivery_instruction' => 'Leave package by the door.',
            'default' => 1, // 1 means this address is the default for User 1
        ]);

        // User Address 2 (Belongs to User 2)
        UserAddress::create([
            'country' => 'الامارات',
            'state' => 'England',
            'user_id' => 2,
            'city' => 'London',
            'zip' => 'SW1A 1AA',
            'address_1' => '456 Park Road',
            'address_2' => null,
            'name' => 'Jane Smith',
            'email' => 'jane@example.com',
            'phone' => '44-20-1234-5678',
            'delivery_instruction' => null,
            'default' => 1, // 1 means this address is the default for User 2
        ]);

        // User Address 3 (Belongs to User 3)
        UserAddress::create([
            'country' => 'السعوديه',
            'state' => 'Ontario',
            'user_id' => 3,
            'city' => 'Toronto',
            'zip' => 'M5V 1K4',
            'address_1' => '789 Maple Avenue',
            'address_2' => 'Unit 10',
            'name' => 'Alex Johnson',
            'email' => 'alex@example.com',
            'phone' => '416-555-7890',
            'delivery_instruction' => 'Call before delivery.',
            'default' => 2, // 2 means this address is not the default for User 3
        ]);
    }
}