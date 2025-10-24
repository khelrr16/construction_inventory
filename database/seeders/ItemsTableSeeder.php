<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use League\Csv\Reader;
use Carbon\Carbon;

class ItemsTableSeeder extends Seeder
{
    public function run()
    {
        // Load the CSV
        $csv = Reader::createFromPath(database_path('seeders/items_new.csv'), 'r');
        $csv->setHeaderOffset(0); // first row is the header
        foreach ($csv as $record) {
            DB::table('items')->insert([
                'warehouse_id'    => $record['warehouse_id'],
                'category'    => $record['category'],
                'name'        => $record['name'],
                'description' => $record['description'],
                'cost'        => $record['cost'],
                'measure'     => $record['measure'],
                'stocks'      => $record['stocks'],
                'created_at'  => $record['created_at'] ?? Carbon::now(),
                'updated_at'  => $record['updated_at'] ?? Carbon::now(),
            ]);
        }
    }
}
