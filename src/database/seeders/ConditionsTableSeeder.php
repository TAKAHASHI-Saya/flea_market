<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ConditionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('conditions')->insert([
            ['condition_type' => '良好'],
            ['condition_type' => '目立った傷や汚れなし'],
            ['condition_type' => 'やや傷や汚れあり'],
            ['condition_type' => '状態が悪い'],
        ]);
    }
}
