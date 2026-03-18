<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use App\Models\Category;
use App\Models\Condition;
use App\Models\Product;
use App\Models\Like;


class ProductTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_all_products_are_displayed()
    {
        $condition = Condition::factory()->create();

        $products = Product::factory()->count(3)->create([
            'condition_id' => $condition->id
        ]);

        $response = $this->get('/');

        $response->assertStatus(200);

        foreach($products as $product){
            $response->assertSee($product->product_name);
        }
    }

    public function test_sold_label_is_displayed_for_purchased_product()
    {
        $condition = Condition::factory()->create();

        $product = Product::factory()->create([
            'status' => 1,
            'condition_id' => $condition->id
        ]);

        $response = $this->get('/');
        $response->assertSee('sold');
    }

    public function test_user_does_not_see_own_products()
    {
        $condition = Condition::factory()->create();

        $loginUser = User::factory()->create();

        $otherUser = User::factory()->create();
        $otherProduct = Product::factory()->create([
            'user_id' => $otherUser->id,
            'condition_id' => $condition->id,
            'product_name' => '腕時計',
        ]);

        $ownProduct = Product::factory()->create([
            'user_id' => $loginUser->id,
            'condition_id' => $condition->id,
            'product_name' => 'HDD',
        ]);

        $response = $this->actingAs($loginUser)->get('/');

        $response->assertStatus(200);
        $response->assertDontSee('HDD');
        $response->assertSee('腕時計');
    }

    public function test_mylist_displays_only_liked_products_and_shows_sold_label()
    {
        $user = User::factory()->create();

        $product1 = Product::factory()->create(['status' => 0]);
        $product2 = Product::factory()->create(['status' => 1]);

        Like::factory()->create(['user_id' => $user->id, 'product_id' => $product1->id]);
        Like::factory()->create(['user_id' => $user->id, 'product_id' => $product2->id]);

        $response = $this->actingAs($user)->get('/?tab=mylist');

        $response->assertStatus(200);
        $response->assertSee($product1->product_name);
        $response->assertSee($product2->product_name);
        $response->assertSee('sold');
    }

    public function test_myList_is_empty_for_guests()
    {
        $product = Product::factory()->create([
            'product_name' => '腕時計'
        ]);

        $response = $this->get('/?tab=mylist');

        $response->assertStatus(200);
        $response->assertDontSee('腕時計');
    }

    public function test_product_search_by_name()
    {
        $matchingProduct = Product::factory()->create([
            'product_name' => '腕時計'
        ]);
        $otherProduct = Product::factory()->create([
            'product_name' => 'ノートPC'
        ]);

        $response = $this->get('/?keyword=時');

        $response->assertStatus(200);
        $response->assertSee('腕時計');
        $response->assertDontSee('ノートPC');
    }

    public function test_search_keyword_is_preserved_in_mylist(){
        $user = User::factory()->create();
        $owner = User::factory()->create();

        $matchingProduct = Product::factory()->create([
            'product_name' => '腕時計',
            'user_id' => $owner->id,
        ]);
        $otherProduct = Product::factory()->create([
            'product_name' => 'ノートPC',
            'user_id' => $owner->id,
        ]);

        Like::factory()->create([
            'user_id' => $user->id,
            'product_id' => $matchingProduct->id,
        ]);
        Like::factory()->create([
            'user_id' => $user->id,
            'product_id' => $otherProduct->id,
        ]);

        $response = $this->actingAs($user)->get('/?tab=mylist&keyword=時');

        $response->assertStatus(200);
        $response->assertSee('腕時計');
        $response->assertDontSee('ノートPC');
    }

    public function test_product_detail_displays_all_required_information()
    {
        $user = User::factory()->create();
        $product = Product::factory()->create([
            'product_name' => 'テスト商品',
            'brand' => 'テストブランド',
            'product_detail' => '商品説明文',
            'sales_price' => 5000,
            'status' => 1,
            'product_image' => 'dummy.jpg'
        ]);

        $condition = Condition::factory()->create(['condition_type' => '良好']);
        $product->condition()->associate($condition)->save();

        $category1 = Category::factory()->create(['category_name' => '家電']);
        $category2 = Category::factory()->create(['category_name' => 'ファッション']);
        $product->categories()->attach([$category1->id, $category2->id]);

        $response = $this->get('/item/'.$product->id);

        $response->assertStatus(200);
        $response->assertSee('テスト商品');
        $response->assertSee('テストブランド');
        $response->assertSee('5000');
        $response->assertSee('商品説明文');
        $response->assertSee('良好');
        $response->assertSee('家電');
        $response->assertSee('ファッション');
        $response->assertSee('sold');
    }

    public function a_user_can_create_a_product()
    {
        Storage::fake('public');

        $user = User::factory()->create();
        $this->actingAs($user);

        $category = Category::factory()->create();
        $condition = Condition::factory()->create();

        $image = UploadedFile::fake()->image('product.jpg');

        $response = $this->post(route('sell.submit'), [
            'product_name' => 'テスト商品',
            'brand' => 'テストブランド',
            'product_detail' => 'テスト詳細',
            'sales_price' => 3000,
            'condition_type' => $condition->id,
            'categories' => [$category->id],
            'product_image' => $image,
        ]);

        $response->assertRedirect(route('mypage'));

        $this->assertDatabaseHas('products', [
            'product_name' => 'テスト商品',
            'brand' => 'テストブランド',
            'product_detail' => 'テスト詳細',
            'sales_price' => 3000,
            'user_id' => $user->id,
            'condition_id' => $condition->id,
        ]);

        $product = Product::first();

        $this->assertDatabaseHas('category_product', [
            'product_id' => $product->id,
            'category_id' => $category->id,
        ]);

        Storage::disk('public')->assertExists($product->product_image);
    }
}
