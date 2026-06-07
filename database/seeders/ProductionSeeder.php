<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Production;

class ProductionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('productions')->insert([
            [
                'name' => '製品A',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => '製品B',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => '製品C',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => '製品D',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
