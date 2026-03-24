<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CommentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('comments')->insert([
            [
                'user_id' => 1,
                'product_id' => 1,
                'comment' => '保管用のケースは付属していますか？',
            ],
            [
                'user_id' => 1,
                'product_id' => 2,
                'comment' => '容量はどのくらいですか？',
            ],
            [
                'user_id' => 2,
                'product_id' => 6,
                'comment' => '接続端子の種類はありますか？',
            ],
        ]);
    }
}
