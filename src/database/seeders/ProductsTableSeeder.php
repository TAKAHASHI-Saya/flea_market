<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user1 = User::where('email', 'test@example.com')->first();
        $user2 = User::where('email', 'taro@example.com')->first();

        DB::table('products')->insert([
            [
                'user_id' => $user1->id,
                'condition_id' => 1,
                'product_name' => '腕時計',
                'product_image' => 'product_images/watch.jpg',
                'brand' => 'Rolax',
                'product_detail' => 'スタイリッシュなデザインのメンズ腕時計',
                'sales_price' => 15000,
                'status' => 0,
            ],
            [
                'user_id' => $user1->id,
                'condition_id' => 2,
                'product_name' => 'HDD',
                'product_image' => 'product_images/hdd.jpg',
                'brand' => '西芝',
                'product_detail' => '高速で信頼性の高いハードディスク',
                'sales_price' => 5000,
                'status' => 0,
            ],
            [
                'user_id' => $user1->id,
                'condition_id' => 3,
                'product_name' => '玉ねぎ3束',
                'product_image' => 'product_images/onion.jpg',
                'brand' => 'なし',
                'product_detail' => '新鮮な玉ねぎ3束のセット',
                'sales_price' => 300,
                'status' => 0,
            ],
            [
                'user_id' => $user1->id,
                'condition_id' => 4,
                'product_name' => '革靴',
                'product_image' => 'product_images/leather_shoes.jpg',
                'brand' => null,
                'product_detail' => 'クラシックなデザインの革靴',
                'sales_price' => 4000,
                'status' => 0,
            ],
            [
                'user_id' => $user2->id,
                'condition_id' => 1,
                'product_name' => 'ノートPC',
                'product_image' => 'product_images/laptop.jpg',
                'brand' => null,
                'product_detail' => '高性能なノートパソコン',
                'sales_price' => 45000,
                'status' => 1,
            ],
            [
                'user_id' => $user1->id,
                'condition_id' => 2,
                'product_name' => 'マイク',
                'product_image' => 'product_images/mic.jpg',
                'brand' => 'なし',
                'product_detail' => '高音質のレコーディング用マイク',
                'sales_price' => 8000,
                'status' => 0,
            ],
            [
                'user_id' => $user2->id,
                'condition_id' => 3,
                'product_name' => 'ショルダーバッグ',
                'product_image' => 'product_images/bag.jpg',
                'brand' => null,
                'product_detail' => 'おしゃれなショルダーバッグ',
                'sales_price' => 3500,
                'status' => 1,
            ],
            [
                'user_id' => $user1->id,
                'condition_id' => 4,
                'product_name' => 'タンブラー',
                'product_image' => 'product_images/tumbler.jpg',
                'brand' => 'なし',
                'product_detail' => '使いやすいタンブラー',
                'sales_price' => 500,
                'status' => 0,
            ],
            [
                'user_id' => $user1->id,
                'condition_id' => 1,
                'product_name' => 'コーヒーミル',
                'product_image' => 'product_images/coffee_grinder.jpg',
                'brand' => 'Starbacks',
                'product_detail' => '手動のコーヒーミル',
                'sales_price' => 4000,
                'status' => 0,
            ],
            [
                'user_id' => $user2->id,
                'condition_id' => 2,
                'product_name' => 'メイクセット',
                'product_image' => 'product_images/make-up_set.jpg',
                'brand' => null,
                'product_detail' => '便利なメイクアップセット',
                'sales_price' => 2500,
                'status' => 1,
            ],
        ]);
    }
}
