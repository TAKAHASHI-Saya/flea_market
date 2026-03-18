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
                'comment' => 'コメントのテスト',
            ],
            [
                'user_id' => 1,
                'product_id' => 1,
                'comment' => 'コメントのテストその２',
            ],
            [
                'user_id' => 1,
                'product_id' => 2,
                'comment' => 'コメントのテスト',
            ],
            [
                'user_id' => 1,
                'product_id' => 3,
                'comment' => 'コメントのテスト',
            ],
            [
                'user_id' => 1,
                'product_id' => 4,
                'comment' => 'コメントのテスト',
            ],
        ]);
    }
}
