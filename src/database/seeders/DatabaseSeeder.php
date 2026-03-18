<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $user1 = User::factory()->create([
            'username' => 'テストてす子',
            'email' => 'test@example.com',
            'email_verified_at' => now(),
            'password' => bcrypt('test12345678'),
            'profile_image' => 'profile_images/profile.png',
            'postcode' => '123-4567',
            'address' => 'テスト住所',
            'building' => 'テスト建物'
        ]);
        $user2 = User::factory()->create([
            'username' => 'テストてす太郎',
            'email' => 'taro@example.com',
            'email_verified_at' => now(),
            'password' => bcrypt('taro12345678'),
            'profile_image' => 'profile_images/profile2.png',
            'postcode' => '123-4567',
            'address' => 'テスト住所',
            'building' => 'テスト建物'
        ]);

        $this->call([
            CategoriesTableSeeder::class,
            ConditionsTableSeeder::class,
            ProductsTableSeeder::class,
            CategoryProductTableSeeder::class,
            PurchaseTableSeeder::class,
            LikesTableSeeder::class,
            CommentsTableSeeder::class,
        ]);
    }
}
