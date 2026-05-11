<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CreditPlanSeeder extends Seeder
{
    public function run()
    {
        DB::table('credit_plans')->insert([
            [
                'name' => 'single',
                'price' => 500, // 5$
                'currency' => 'usd',
                'credits' => 1,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'pack_3',
                'price' => 1200, // 12$
                'currency' => 'usd',
                'credits' => 3,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'pack_5',
                'price' => 1900, // 19$
                'currency' => 'usd',
                'credits' => 5,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
