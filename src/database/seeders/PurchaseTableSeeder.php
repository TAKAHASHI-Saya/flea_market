<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PurchaseTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('purchases')->insert([
            [
                'user_id' => 1,
                'product_id' => 7,
                'purchase_price' => 3500,
                'payment_method' => 'card',
                'postcode' => '333-2222',
                'address' => '住所変更',
                'building' => null,
            ],
            [
                'user_id' => 1,
                'product_id' => 10,
                'purchase_price' => 2500,
                'payment_method' => 'konbini',
                'postcode' => '444-2222',
                'address' => 'テスト住所変更',
                'building' => 'テスト建物',
            ],
            [
                'user_id' => 2,
                'product_id' => 9,
                'purchase_price' => 4000,
                'payment_method' => 'card',
                'postcode' => '111-2222',
                'address' => 'テスト住所変更',
                'building' => 'テスト建物',
            ],
        ]);
    }
}
