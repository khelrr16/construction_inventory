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
        User::factory(10)->create();

        User::factory()->create([
            'name' => 'Odd Mint',
            'email' => 'admin@gmail.com',
            'contact_number' => '09911223344',
            'role' => 'admin',
            'password' => 'asdjklasdjkl',
        ]);

        User::factory()->create([
            'name' => 'War Care',
            'email' => 'worker@gmail.com',
            'contact_number' => '09911223344',
            'role' => 'site_worker',
            'password' => 'asdjklasdjkl',
        ]);

        User::factory()->create([
            'name' => 'Claire Erk',
            'email' => 'clerk@gmail.com',
            'contact_number' => '09911223344',
            'role' => 'inventory_clerk',
            'password' => 'asdjklasdjkl',
        ]);

        User::factory()->create([
            'name' => 'Dry Bear',
            'email' => 'driver@gmail.com',
            'contact_number' => '09911223344',
            'role' => 'driver',
            'password' => 'asdjklasdjkl',
        ]);

        Warehouse::factory(3)->create();
        $this->call(ItemsTableSeeder::class);
        
        // Item::factory(50)->create();
        // Vehicle::factory(3)->create();
        
    }
}
