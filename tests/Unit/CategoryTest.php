<?php

namespace Tests\Unit;

use App\Models\Category;
use App\Services\CategoryService;
use Exception;
use Faker\Factory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;

/**
 * php artisan test --filter=CategoryTest
 */
class CategoryTest extends TestCase
{
    use RefreshDatabase;

    public function test_cannot_get_tree_non_parent()
    {
        $this->seed();

        $this->expectException(Exception::class);

        app(CategoryService::class)->getParentTree(Category::whereNotNull('parent_category_id')->first());
    }

    public function test_can_get_tree_non_parent()
    {
        $this->seed();

        $result = app(CategoryService::class)->getParentTree(Category::whereNull('parent_category_id')->first());

        $this->assertNotEmpty($result['sub_categories']);
    }

    public function test_can_add_subcategory(): void
    {
        $this->seed();
        $category = Category::find(10);
        $attributes = [
            'user_id' => 1,
            'name' => 'Italian Pizza',
            'discount' => 3,
        ];

        $result = app(CategoryService::class)->addSubCategory($category, $attributes);

        $this->assertEquals($result->name, $attributes['name']);

    }

    public function test_cannot_add_subcategory_more_than_4(): void
    {
        $this->seed();

        $this->expectExceptionMessage('Sorry, you cannot add more sub-category.');

        $category = Category::find(10);
        $count = 4;

        do {
            $attributes = [
                'user_id' => 1,
                'name' => Factory::create()->word,
                'discount' => 3,
            ];

            $category = app(CategoryService::class)->addSubCategory($category, $attributes);

            $count--;
        } while ($count > 0);
    }
}
