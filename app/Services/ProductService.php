<?php

namespace App\Services;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductService
{
    public function getAllCategories()
    {
        return Category::all()->pluck('name', 'id');
    }

    public function getAllProducts()
    {
        return Product::query()->with('category')->get();
    }

    public function createProduct(Request $request)
    {
        $lastProduct = Product::latest('id')->first() ?? new Product();

        preg_match('/PRD-0*(\d+)/', $lastProduct->code, $matches);

        $request['code'] = 'PRD-' . add_zero_infront((int) $matches[1] + 1, 6);

        return Product::create([
            'category_id' => $request->productCategoryId,
            'code' => $request->code,
            'name' => $request->productName,
            'price' => $request->productPrice,
        ]);
    }

    public function getProductById($id)
    {
        return Product::findOrFail($id);
    }

    public function updateProduct(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $product->name = $request->productName;
        $product->category_id = $request->productCategoryId;
        $product->price = $request->productPrice;
        $product->save();

        return $product;
    }

    public function deleteProduct($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();
    }

    public function deleteSelectedProducts(array $ids)
    {
        foreach ($ids as $id) {
            $product = Product::findOrFail($id);
            $product->delete();
        }
    }
}
