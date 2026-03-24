<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LikesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('likes')->insert([
            [
                'user_id' => 1,
                'product_id' => 1,
            ],
            [
                'user_id' => 2,
                'product_id' => 4,
            ],
            [
                'user_id' => 1,
                'product_id' => 10,
            ],
        ]);
    }
}
