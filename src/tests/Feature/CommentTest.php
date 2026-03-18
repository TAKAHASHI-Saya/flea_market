<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Product;
use App\Models\Comment;

class CommentTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_logged_in_user_can_post_comment()
    {
        $user = User::factory()->create();
        $product = Product::factory()->create();

        $this->actingAs($user);

        $response = $this->post("/item/{$product->id}/comment", [
            'comment' => 'テストコメント'
        ]);

        $response->assertStatus(302);

        $this->assertDatabaseHas('comments', [
            'user_id' => $user->id,
            'product_id' => $product->id,
            'comment' => 'テストコメント',
        ]);
    }

    public function test_guest_cannot_post_comment()
    {
        $product = Product::factory()->create();

        $response = $this->post("/item/{$product->id}/comment", [
            'comment' => 'テストコメント',
        ]);

        $response->assertRedirect('/login');
        $this->assertDatabaseMissing('comments', [
            'comment' => 'テストコメント',
        ]);
    }

    public function test_comment_is_required()
    {
        $user = User::factory()->create();
        $product = Product::factory()->create();

        $this->actingAs($user);

        $response = $this->post("/item/{$product->id}/comment", [
            'comment' => ''
        ]);

        $response->assertSessionHasErrors(['comment']);

        $this->assertDatabaseMissing('comments', [
            'product_id' => $product->id,
        ]);
    }

    public function test_comment_cannot_exceed_255_characters()
    {
        $user = User::factory()->create();
        $product = Product::factory()->create();

        $this->actingAs($user);

        $longComment = str_repeat('あ', 256);

        $response = $this->post("/item/{$product->id}/comment", [
            'comment' => $longComment
        ]);

        $response->assertSessionHasErrors(['comment']);

        $this->assertDatabaseMissing('comments', [
            'product_id' => $product->id,
        ]);
    }
}
