<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;


class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
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

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
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

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $categories = Category::findOrFail($id);

        return response()->json($categories);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
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

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
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
