<?php

namespace Database\Seeders;

use App\Models\Item;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use App\Models\Vehicle;
use App\Models\Warehouse;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Odd Mint',
            'email' => 'admin@gmail.com',
            'contact_number' => '09123456781',
            'role' => 'admin',
            'password' => 'asdjklasdjkl',
        ]);

        User::factory()->create([
            'name' => 'War Care',
            'email' => 'worker@gmail.com',
            'contact_number' => '09123456782',
            'role' => 'site_worker',
            'password' => 'asdjklasdjkl',
        ]);

        User::factory()->create([
            'name' => 'Claire Erk',
            'email' => 'clerk@gmail.com',
            'contact_number' => '09123456783',
            'role' => 'inventory_clerk',
            'password' => 'asdjklasdjkl',
        ]);

        User::factory()->create([
            'name' => 'Dry Bear',
            'email' => 'driver@gmail.com',
            'contact_number' => '09123456784',
            'role' => 'driver',
            'password' => 'asdjklasdjkl',
        ]);

        User::factory(10)->create();

        //Warehouse----------------------------------------------------------
        Warehouse::factory()->create([
            'name' => 'Blooming Star',
            'house' => 'Blk 15 Lot 3 Bagong pag-asa street',
            'barangay' => 'United Bayanihan',
            'city' => 'San Pedro',
            'province' => 'Laguna',
            'zipcode'=> '4023',
            'status' => 'active',
        ]);

        Warehouse::factory()->create([
            'name' => 'RPN Hardware and Construction',
            'house' => 'Unit 12B Casim Compound',
            'barangay' => 'Talon Uno',
            'city' => 'las piñas',
            'province' => 'Metro Manila',
            'zipcode' => '1747',
            'status' => 'active',
        ]);

        Warehouse::factory()->create([
            'name' => '24 Orient',
            'house' => 'Blk 17 Lot 8',
            'barangay' => 'Pasong Camachile',
            'city' => 'General Trias',
            'province' => 'Cavite',
            'zipcode' => '4107',
            'status' => 'active'
        ]);

        Warehouse::factory()->create([
            'name' => 'FG Home Builders and Construction Supply',
            'house' => '446V+WGP',
            'barangay' => 'San Antonio',
            'city' => 'Santo Tomas',
            'province' => 'Batangas',
            'zipcode' => '4234',
            'status' => 'active',
        ]);


        //Vehicle----------------------------------------------------------
        Vehicle::factory()->create([
            'type' => 'Truck',
            'brand' => 'Isuzu',
            'color' => 'White',
            'model' => 'NQR75L',
            'plate_number' => 'NGR75',
            'registered_by' => 1,
            'status' => 'active',
        ]);

        Vehicle::factory()->create([
            'type' => 'Truck',
            'brand' => 'Fuso',
            'color' => 'White',
            'model' => 'Canter FE71',
            'plate_number' => 'HTO5658',
            'registered_by' => 1,
            'status' => 'active',
        ]);

        Vehicle::factory()->create([
            'type' => 'Truck',
            'brand' => 'Fuso',
            'color' => 'White',
            'model' => 'Canter FE73',
            'plate_number' => 'HTO2268',
            'registered_by' => 1,
            'status' => 'active',
        ]);

        Vehicle::factory()->create([
            'type' => 'Truck',
            'brand' => 'Fuso',
            'color' => 'Gray',
            'model' => 'Canter FE74',
            'plate_number' => 'JLK1381',
            'registered_by' => 1,
            'status' => 'active',
        ]);

        //
        $this->call(ItemsTableSeeder::class);
        
    }
}
