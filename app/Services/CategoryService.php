<?php

namespace App\Services;

use App\Models\Category;
use Exception;

class CategoryService
{
    /**
     * Adding a sub Category to an existing category.
     *
     * @return void
     */
    public function addSubCategory(Category $category, array $attributes)
    {
        $this->countCategoryDescendants($category, $countDescendants);

        if ($countDescendants > 3) {
            throw new Exception('Sorry, you cannot add more sub-category.');
        }

        $category->subCategories()->create($attributes);

        $category->refresh();

        return $category->subCategories[0];
    }

    /**
     * Fetching Category Tree from Parent Category
     *
     * @return array
     */
    public function getParentTree(Category $category)
    {
        if ($category->parent_category_id) {
            throw new Exception('Category is not a parent.');
        }
        $categoryTree = $category;
        $categoryTree['sub_categories'] = $this->getSubCategory($category->subCategories);

        return collect($categoryTree)->toArray();
    }

    /**
     * Recursive call for sub Category
     *
     * @param  Model  $subCategories
     * @return Model Instance
     */
    public function getSubCategory($subCategories)
    {
        if ($subCategories) {
            foreach ($subCategories as $subcategory) {
                $this->getSubCategory(
                    $subcategory->subCategories && $subcategory->subCategories->count()
                    ? $subcategory->subCategories
                    : $subcategory->items
                );
            }
        }
    }

    /**
     * Counting the sub categories descendant.
     *
     * @param [type] $count
     * @return void
     */
    public function countCategoryDescendants(Category $category, &$count)
    {
        $count += $category->descendantCategory ? 1 : 0;

        if ($category->descendantCategory) {
            $this->countCategoryDescendants($category->descendantCategory, $count);
        }

        return $count;
    }
}
