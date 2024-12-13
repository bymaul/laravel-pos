<?php

namespace App\Http\Controllers;

use App\Services\CategoryService;
use Illuminate\Http\Request;

class CategoryController extends Controller
{

    public function __construct(private readonly CategoryService $categoryService) {}

    public function index()
    {
        return view('category.index');
    }

    public function data()
    {
        $categories = $this->categoryService->getAllCategories();

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
        $this->categoryService->createCategory($request->categoryName);

        return response()->json(
            'Data berhasil disimpan!',
            201
        );
    }

    public function show($id)
    {
        $category = $this->categoryService->getCategoryById($id);

        return response()->json($category);
    }

    public function update(Request $request, $id)
    {
        $this->categoryService->updateCategory($id, $request->categoryName);

        return response()->json(
            'Data berhasil diperbarui!',
            200
        );
    }

    public function destroy($id)
    {
        $this->categoryService->deleteCategory($id);

        return response()->json(
            'Data berhasil dihapus!',
            204
        );
    }
}
