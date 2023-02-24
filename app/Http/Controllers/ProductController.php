<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $categories = Category::all()->pluck('name', 'id');

        return view('product.index', compact('categories'));
    }

    public function data()
    {
        $products = Product::all();

        return datatables()
            ->of($products)
            ->addIndexColumn()
            ->addColumn('selectAll', function ($products) {
                return '<input type="checkbox" name="id[]" value="' . $products->id . '">';
            })
            ->addColumn('code', function ($products) {
                return '<span class="badge bg-success">' . $products->code . '</span>';
            })
            ->addColumn('category', function ($products) {
                return $products->category->name;
            })
            ->addColumn('price', function ($products) {
                return indonesia_format($products->price);
            })
            ->addColumn('action', function ($products) {
                return '
                <div class="btn-group">
                <a onclick="editForm(`' . route('product.update', $products->id) . '`)" class="btn btn-sm btn-primary">Perbarui</a>
                <a onclick="deleteData(`' . route('product.destroy', $products->id) . '`)" class="btn btn-sm btn-danger">Hapus</a>
                </div>
                ';
            })
            ->rawColumns(['selectAll', 'code', 'action'])
            ->make(true);
    }

    public function store(Request $request)
    {
        $products = Product::latest()->first() ?? new Product();

        $request['code'] =  'PRD-' . add_zero_infront((int)$products->id + 1, 6);

        $products = Product::create([
            'category_id' => $request->productCategoryId,
            'code' => $request->code,
            'name' => $request->productName,
            'price' => $request->productPrice,
        ]);

        return response()->json(
            'Data berhasil disimpan!',
            200
        );
    }

    public function show($id)
    {
        $products = Product::findOrFail($id);

        return response()->json($products);
    }

    public function update(Request $request, $id)
    {
        $products = Product::findOrFail($id);
        $products->name = $request->productName;
        $products->category_id = $request->productCategoryId;
        $products->price = $request->productPrice;
        $products->update();

        return response()->json(
            'Data berhasil diperbarui!',
            200
        );
    }

    public function destroy($id)
    {
        $categories = Product::findOrFail($id);
        $categories->delete();

        return response()->json(
            'Data berhasil dihapus!',
            200
        );
    }

    public function deleteSelected(Request $request)
    {
        foreach ($request->id as $id) {
            $products = Product::findOrFail($id);
            $products->delete();
        }

        return response(null, 204);
    }
}
