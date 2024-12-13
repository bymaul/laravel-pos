<?php

namespace App\Services;

use App\Models\Category;

class CategoryService
{
    public function getAllCategories()
    {
        return Category::all();
    }

    public function createCategory($categoryName)
    {
        $category = new Category();
        $category->name = $categoryName;
        $category->save();

        return $category;
    }

    public function getCategoryById($id)
    {
        return Category::query()->findOrFail($id);
    }

    public function updateCategory($id, $categoryName)
    {
        $category = Category::query()->findOrFail($id);
        $category->name = $categoryName;
        $category->update();

        return $category;
    }

    public function deleteCategory($id)
    {
        $category = Category::query()->findOrFail($id);
        $category->delete();

        return $category;
    }
}
