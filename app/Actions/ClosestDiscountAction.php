<?php

namespace App\Actions;

use App\Models\Category;
use App\Models\Item;

class ClosestDiscountAction
{
    public static function handle(Item $item)
    {
        $discount = $item->dicount;
        if ($item->dicount == 0) {
            self::getDiscount($item->category, $discount);
        }

        return $discount;
    }

    public static function getDiscount(Category $category, &$discount)
    {
        if ($category->discount != null && $category->discount == 0) {
            $discount = $category->descendantCategory->discount ?: 0;
            self::getDiscount($category->descendantCategory, $discount);
        } elseif ($discount == 0) {
            $discount = $category->discount;
        }
    }
}
