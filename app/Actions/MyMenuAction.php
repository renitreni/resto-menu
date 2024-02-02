<?php

namespace App\Actions;

use App\Models\User;
use App\Services\CategoryService;

class MyMenuAction
{
    public static function handle(User $user)
    {
        $categories = $user->categories()->whereNull('parent_category_id')->get();
        foreach ($categories as $key => $category) {
            $categoryTree[$key] = $category;

            $result = app(CategoryService::class)->getSubCategory($category->subCategories);

            $categoryTree[$key]['sub_categories'] = $result;
        }

        return json_decode(json_encode($categoryTree), true);
    }
}
