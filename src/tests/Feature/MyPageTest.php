<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Product;
use App\Models\Purchase;

class MyPageTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_user_profile_information_is_displayed()
    {
        $user = User::factory()->create([
            'username' => 'テストユーザー',
        ]);

        $sellProduct = Product::factory()->create([
            'user_id' => $user->id,
            'product_name' => '出品商品'
        ]);

        $buyProduct = Product::factory()->create([
            'product_name' => '購入商品'
        ]);

        Purchase::create([
            'user_id' => $user->id,
            'product_id' => $buyProduct->id,
            'purchase_price' => 1000,
            'payment_method' => 'card',
            'postcode' => '123-4567',
            'address' => '住所',
            'building' => '建物',
        ]);

        $this->actingAs($user);

        $response = $this->get('/mypage?page=sell');
        $response->assertSee('出品商品');

        $response = $this->get('/mypage?page=buy');
        $response->assertSee('購入商品');

        $response->assertSee('テストユーザー');
    }

    public function test_profile_edit_form_has_initial_values()
    {
        $user = User::factory()->create([
            'username' => '初期ユーザー',
            'postcode' => '111-1111',
            'address' => '初期住所',
            'building' => '初期建物',
        ]);

        $this->actingAs($user);

        $response = $this->get(route('edit.mypage'));

        $response->assertSee('初期ユーザー');
        $response->assertSee('111-1111');
        $response->assertSee('初期住所');
        $response->assertSee('初期建物');
    }
}
