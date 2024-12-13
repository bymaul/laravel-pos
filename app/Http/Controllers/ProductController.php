<?php

namespace App\Http\Controllers;

use App\Services\ProductService;
use Illuminate\Http\Request;
use Illuminate\Support\Number;

class ProductController extends Controller
{
    public function __construct(private readonly ProductService $productService) {}

    public function index()
    {
        $categories = $this->productService->getAllCategories();

        return view('product.index', compact('categories'));
    }

    public function data()
    {
        $products = $this->productService->getAllProducts();

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
                return Number::currency($products->price, 'IDR', 'id');
            })
            ->addColumn('action', function ($products) {
                return '
                <div class="d-flex justify-content-center">
                    <div class="dropdown no-arrow">
                        <a class="btn btn-sm dropdown-toggle" href="#" data-bs-toggle="dropdown" aria-expanded="true">
                            <i class="fas fa-ellipsis-v"></i>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a onclick="editForm(`' . route('product.update', $products->id) . '`)" class="dropdown-item" href="#">Perbarui</a></li>
                            <li><a onclick="deleteData(`' . route('product.destroy', $products->id) . '`)" class="dropdown-item" href="#">Hapus</a></li>
                        </ul>
                    </div>
                </div>
                ';
            })
            ->rawColumns(['selectAll', 'code', 'action'])
            ->make(true);
    }

    public function store(Request $request)
    {
        $this->productService->createProduct($request);

        return response()->json('Data berhasil disimpan!', 200);
    }

    public function show($id)
    {
        return response()->json($this->productService->getProductById($id));
    }

    public function update(Request $request, $id)
    {
        $this->productService->updateProduct($request, $id);

        return response()->json('Data berhasil diperbarui!', 200);
    }

    public function destroy($id)
    {
        $this->productService->deleteProduct($id);

        return response()->json('Data berhasil dihapus!', 200);
    }

    public function deleteSelected(Request $request)
    {
        $this->productService->deleteSelectedProducts($request->id);

        return response(null, 204);
    }
}
