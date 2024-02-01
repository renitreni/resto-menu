<?php

namespace App\Services;

use App\Models\Category;
use Exception;

class ItemService
{
    public function store($attribute, Category $category)
    {
        if ($category->subCategories->isNotEmpty()) {
            throw new Exception('Item could not be created. A sub-category already exist.');
        }

        return $category->items()->create($attribute);
    }
}
