<?php

namespace Tests\Unit;

use App\Actions\ClosestDiscountAction;
use App\Models\Category;
use App\Models\Item;
use App\Services\ItemService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * php artisan test --filter=ItemServiceTest
 */
class ItemServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_cannot_store_item_if_sub_category_exist(): void
    {
        $this->seed();
        $this->expectExceptionMessage('Item could not be created. A sub-category already exist.');

        $itemService = new ItemService();

        $category = Category::find(4);

        $attributes = [
            'name' => 'Banana Split',
            'price' => 13,
            'dicount' => 4,
            'user_id' => 1,
        ];

        $result = $itemService->store($attributes, $category);
    }

    public function test_can_store_item_if_sub_category_does_not_exist(): void
    {
        $this->seed();

        $itemService = new ItemService();

        $category = Category::find(10);

        $attributes = [
            'name' => 'Banana Split',
            'price' => 13,
            'dicount' => 4,
            'user_id' => 1,
        ];

        $result = $itemService->store($attributes, $category);

        $this->assertEquals($attributes['name'], $result->name);
    }

    public function test_can_get_closest_discount_on_item_case_1()
    {
        $this->seed();
        $item = Item::find(3);
        $discount = ClosestDiscountAction::handle($item);

        $this->assertEquals(10, $discount);
    }

    public function test_can_get_closest_discount_on_item_case_2()
    {
        $this->seed();

        $item = Item::find(5);

        $discount = ClosestDiscountAction::handle($item);

        $this->assertEquals(12, $discount);
    }
}
