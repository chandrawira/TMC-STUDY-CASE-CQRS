<?php

namespace Database\Seeders;

use App\Models\ApiKey;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        ApiKey::factory(1)->create(); //create API sample data
        Category::factory(10)->create();
        Product::factory(1000)->create();
    }
}
