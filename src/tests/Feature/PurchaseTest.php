<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Product;
use App\Models\Purchase;

class PurchaseTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_user_can_purchase_product()
    {
        $user = User::factory()->create();
        $product = Product::factory()->create([
            'status' => 0
        ]);

        $this->actingAs($user);

        session([
            'purchase_data' => [
                'product_id' => $product->id,
                'purchase_price' => 1000,
                'payment_method' => 'card',
                'postcode' => '123-4567',
                'address' => 'テスト住所',
                'building' => 'テスト建物',
            ]
        ]);

        $response = $this->get(route('purchase.success', $product->id));

        $response->assertRedirect(route('product'));

        $this->assertDatabaseHas('purchases', [
            'user_id' => $user->id,
            'product_id' => $product->id,
        ]);
    }

    public function test_purchased_product_is_marked_as_sold()
    {
        $user = User::factory()->create();
        $product = Product::factory()->create([
            'status' => 0
        ]);

        $this-> actingAs($user);

        session([
            'purchase_data' => [
                'product_id' => $product->id,
                'purchase_price' => 1000,
                'payment_method' => 'card',
                'postcode' => '123-4567',
                'address' => 'テスト住所',
                'building' => 'テスト建物',
            ]
        ]);

        $this->get(route('purchase.success', $product->id));

        $response = $this->get(route('product'));

        $response->assertSee('sold');
    }

    public function test_purchased_product_appears_in_mypage()
    {
        $user = User::factory()->create();
        $product = Product::factory()->create();

        $this->actingAs($user);

        session([
            'purchase_data' => [
                'product_id' => $product->id,
                'purchase_price' => 1000,
                'payment_method' => 'card',
                'postcode' => '123-4567',
                'address' => 'テスト住所',
                'building' => 'テスト建物',
            ]
        ]);

        $this->get(route('purchase.success', $product->id));

        $response = $this->get('/mypage?page=buy');

        $response->assertSee($product->product_name);
    }

    public function test_payment_method_is_reflected_on_purchase_page()
    {
        $user = User::factory()->create();
        $product = Product::factory()->create();

        $this->actingAs($user);

        $response = $this->post(route('purchase.checkout', $product->id), [
            'purchase_price' => 1000,
            'payment_method' => 'card',
            'postcode' => '123-4567',
            'address' => 'テスト住所',
            'building' => 'テスト建物',
        ]);

        $this->assertEquals('card', session('purchase_data.payment_method'));
    }

    public function test_shipping_address_is_reflected_on_purchase_page()
    {
        $user = User::factory()->create();
        $product = Product::factory()->create();

        $this->actingAs($user);

        $this->post("/purchase/change_address/{$product->id}", [
            'postcode' => '111-1111',
            'address' => '新しい住所',
            'building' => '新しい建物',
        ]);

        $response = $this->get("/purchase/{$product->id}");

        $response->assertSee('111-1111');
        $response->assertSee('新しい住所');
        $response->assertSee('新しい建物');
    }

    public function test_shipping_address_is_saved_in_purchase()
    {
        $user = User::factory()->create();
        $product = Product::factory()->create();

        $this->actingAs($user);

        session([
            'purchase_data' => [
                'product_id' => $product->id,
                'purchase_price' => 1000,
                'payment_method' => 'card',
                'postcode' => '999-9999',
                'address' => '保存用住所',
                'building' => '保存用建物',
            ]
        ]);

        $this->get(route('purchase.success', $product->id));

        $this->assertDatabaseHas('purchases', [
            'product_id' => $product->id,
            'postcode' => '999-9999',
            'address' => '保存用住所',
            'building' => '保存用建物',
        ]);
    }
}
