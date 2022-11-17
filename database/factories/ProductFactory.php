<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

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
            'sku' =>    $this->faker->regexify('[A-Z]{2}-[0-9]{3}-[0-9]{2}-[0-9]{5}'),
            'name' => strtoupper($this->faker->words(1,true)),
            'price' => $this->faker->randomDigit(),
            'stock' => $this->faker->numberBetween(0,100),
            'category_id' => Category::all()->random()->id,
            'createdAt' => $this->faker->unixTime()
        ];
    }
}
