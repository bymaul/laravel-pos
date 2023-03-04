<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;


class CategoryController extends Controller
{
    public function index()
    {
        return view('category.index');
    }

    public function data()
    {
        $categories = Category::all();

        return datatables()
            ->of($categories)
            ->addIndexColumn()
            ->addColumn('action', function ($categories) {
                return '<div class="btn-group">
                <a onclick="editForm(`' . route('category.update', $categories->id) . '`)" class="btn btn-sm btn-primary">Perbarui</a>
                <a onclick="deleteData(`' . route('category.destroy', $categories->id) . '`)" class="btn btn-sm btn-danger">Hapus</a>
                </div>';
            })
            ->make(true);
    }

    public function store(Request $request)
    {
        $category = new Category();
        $category->name = $request->categoryName;
        $category->save();

        return response()->json(
            'Data berhasil disimpan!',
            200
        );
    }

    public function show($id)
    {
        $categories = Category::findOrFail($id);

        return response()->json($categories);
    }

    public function update(Request $request, $id)
    {
        $categories = Category::findOrFail($id);
        $categories->name = $request->categoryName;
        $categories->update();

        return response()->json(
            'Data berhasil diperbarui!',
            200
        );
    }

    public function destroy($id)
    {
        $categories = Category::findOrFail($id);
        $categories->delete();

        return response()->json(
            'Data berhasil dihapus!',
            200
        );
    }
}
