<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Item;
use App\Models\User;
use Faker\Factory;
use Illuminate\Database\Seeder;

class TestCategoryItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Factory::create();
        $user = User::first();
        $parentCategoryArray = [
            [
                'user_id' => $user->id,
                'parent_category_id' => null,
                'name' => 'Food',
                'discount' => 10,
            ],
            [
                'user_id' => $user->id,
                'parent_category_id' => null,
                'name' => 'Beverages',
                'discount' => 0,
            ],
            [
                'user_id' => $user->id,
                'parent_category_id' => 1,
                'name' => 'Desserts',
                'discount' => 0,
            ],
            [
                'user_id' => $user->id,
                'parent_category_id' => 1,
                'name' => 'Main Course',
                'discount' => 0,
            ],
            [
                'user_id' => $user->id,
                'parent_category_id' => 2,
                'name' => 'Soft Drinks',
                'discount' => 0,
            ],
            [
                'user_id' => $user->id,
                'parent_category_id' => 2,
                'name' => 'Alcoholic',
                'discount' => 0,
            ],
            [
                'user_id' => $user->id,
                'parent_category_id' => 3,
                'name' => 'Cake',
                'discount' => 0,
            ],
            [
                'user_id' => $user->id,
                'parent_category_id' => 3,
                'name' => 'Ice Cream',
                'discount' => 12,
            ],
            [
                'user_id' => $user->id,
                'parent_category_id' => 4,
                'name' => 'Pasta',
                'discount' => 0,
            ],
            [
                'user_id' => $user->id,
                'parent_category_id' => 4,
                'name' => 'Pizza',
                'discount' => 0,
            ],
        ];

        collect($parentCategoryArray)->each(fn ($value) => Category::create($value));

        $product = [
            [
                'category_id' => 7,
                'name' => 'Chocolate Cake',
                'price' => $faker->numberBetween(1, 200),
                'dicount' => 5,
                'user_id' => $user->id,
            ],
            [
                'category_id' => 7,
                'name' => '	Vanilla Cake',
                'price' => $faker->numberBetween(1, 200),
                'dicount' => 0,
                'user_id' => $user->id,
            ],
            [
                'category_id' => 7,
                'name' => 'Strawberry Cake',
                'price' => $faker->numberBetween(1, 200),
                'dicount' => 2,
                'user_id' => $user->id,
            ],
            [
                'category_id' => 8,
                'name' => '	Chocolate Ice Cream',
                'price' => $faker->numberBetween(1, 200),
                'dicount' => 0,
                'user_id' => $user->id,
            ],
            [
                'category_id' => 8,
                'name' => 'Vanilla Ice Creame',
                'price' => $faker->numberBetween(1, 200),
                'dicount' => 0,
                'user_id' => $user->id,
            ],
            [
                'category_id' => 9,
                'name' => '	Spaghetti Carbonara',
                'price' => $faker->numberBetween(1, 200),
                'dicount' => 0,
                'user_id' => $user->id,
            ],
            [
                'category_id' => 7,
                'name' => 'Margherita Pizza',
                'price' => $faker->numberBetween(1, 200),
                'dicount' => 0,
                'user_id' => $user->id,
            ],
        ];

        collect($product)->each(fn ($value) => Item::create($value));
    }
}
