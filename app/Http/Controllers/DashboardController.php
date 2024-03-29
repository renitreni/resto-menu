<?php

namespace App\Http\Controllers;

use App\Actions\ClosestDiscountAction;
use App\Actions\MyMenuAction;
use App\Http\Requests\AddCategoryRequest;
use App\Http\Requests\AddItemRequest;
use App\Models\Category;
use App\Models\Item;
use App\Services\CategoryService;
use Exception;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index()
    {
        $categoryTree = MyMenuAction::handle(auth()->user());

        return Inertia::render('Dashboard', ['categoryTree' => $categoryTree]);
    }

    public function addItem(AddItemRequest $request)
    {
        $attributes = $request->validated();
        $item = Item::updateOrCreate(
            ['id' => $attributes['item']],
            [
                'name' => $attributes['name'],
                'price' => $attributes['price'],
                'dicount' => $attributes['dicount'],
                'category_id' => $attributes['categoryId'],
                'user_id' => auth()->id(),
            ],
        );

        return response()->json($item);
    }

    public function addCategory(AddCategoryRequest $request, CategoryService $categoryService)
    {
        $attributes = $request->validated();
        try {

            if ($attributes['parentId'] != null && $attributes['categoryId'] == 'null') {
                $attributes['user_id'] = auth()->id();
                $parentCategory = Category::find($attributes['parentId']);
                $category = $categoryService->addSubCategory($parentCategory, $attributes);
            } else {
                $category = Category::updateOrCreate(
                    ['id' => $attributes['categoryId']],
                    [
                        'name' => $attributes['name'],
                        'discount' => $attributes['discount'],
                        'parent_category_id' => $attributes['parentId'] == 'null' ? null : $attributes['parentId'],
                        'user_id' => auth()->id(),
                    ]
                );
            }
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }

        return response()->json($category);
    }

    public function getItem($item)
    {
        if ($item) {
            $item = Item::find($item);
            $discount = ClosestDiscountAction::handle($item);
            $item->apply_discount = $discount;
        }

        return response()->json($item);
    }

    public function getCategory($category)
    {
        if ($category) {
            $category = Category::find($category);
        }

        return response()->json($category);
    }

    public function deleteItem(Item $item)
    {
        $item->delete();
    }
}
