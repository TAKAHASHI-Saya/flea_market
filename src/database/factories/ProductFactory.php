<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\Condition;


class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'product_name' =>$this->faker->word,
            'sales_price' =>$this->faker->numberBetween(1000, 10000),
            'status' => 0,
            'user_id' => User::factory(),
            'condition_id' => Condition::factory(),
            'product_detail' => $this->faker->sentence,
            'product_image' => 'dummy.jpg',
        ];
    }
}
