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
                return '
                <div class="d-flex justify-content-center">
                    <div class="dropdown no-arrow">
                        <a class="btn btn-sm dropdown-toggle" href="#" data-bs-toggle="dropdown" aria-expanded="true">
                            <i class="fas fa-ellipsis-v"></i>
                        </a>
                        <ul class="dropdown-menu">
                            <li>
                                <a onclick="editForm(`' . route('category.update', $categories->id) . '`)" class="dropdown-item" href="#">Perbarui</a>
                            </li>
                            <li>
                                <a onclick="deleteData(`' . route('category.destroy', $categories->id) . '`)" class="dropdown-item" href="#">Hapus</a>
                            </li>
                        </ul>
                    </div>
                </div>
                ';
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
            201
        );
    }

    public function show($id)
    {
        return response()->json(Category::findOrFail($id));
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
        Category::findOrFail($id)->delete();

        return response()->json(
            'Data berhasil dihapus!',
            204
        );
    }
}
