<?php

namespace App\Http\Controllers;

use App\Services\SaleService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Number;

class SaleController extends Controller
{
    public function __construct(private readonly SaleService $saleService) {}

    public function index()
    {
        return view('sale.index');
    }

    public function data()
    {
        $isAdmin = auth()->user()->role == 'admin';
        $sales = $this->saleService->getSalesData();

        return datatables()
            ->of($sales)
            ->addIndexColumn()
            ->addColumn('date', function ($sales) {
                return Carbon::parse($sales->created_at)->locale('id')->isoFormat('dddd, D MMMM Y');
            })
            ->addColumn('total_items', function ($sales) {
                return $sales->total_items;
            })
            ->addColumn('total_price', function ($sales) {
                return Number::currency($sales->total_price, 'IDR', 'id');
            })
            ->addColumn('cashier', function ($sales) {
                return $sales->user->name;
            })
            ->addColumn('action', function ($sales) use ($isAdmin) {
                return $isAdmin ?
                    '
                    <div class="d-flex justify-content-center">
                        <div class="dropdown no-arrow">
                            <a class="btn btn-sm dropdown-toggle" href="#" data-bs-toggle="dropdown" aria-expanded="true">
                                <i class="fas fa-ellipsis-v"></i>
                            </a>
                            <ul class="dropdown-menu">
                                <li>
                                    <button onclick="showDetail(`' . route('sale.show', $sales->id) . '`)" class="dropdown-item">Detail</button>
                                </li>
                                <li>
                                    <a href="' . route('sale.edit', $sales->id) . '" class="dropdown-item">Perbarui</a>
                                </li>
                                <li>
                                    <button onclick="deleteData(`' . route('sale.destroy', $sales->id) . '`)" class="dropdown-item">Hapus</button>
                                </li>
                            </ul>
                        </div>
                    </div>
                ' : '
                    <div class="d-flex justify-content-center">
                        <div class="dropdown no-arrow">
                            <a class="btn btn-sm dropdown-toggle" href="#" data-bs-toggle="dropdown" aria-expanded="true">
                                <i class="fas fa-ellipsis-v"></i>
                            </a>
                            <ul class="dropdown-menu">
                                <li>
                                    <button onclick="showDetail(`' . route('sale.show', $sales->id) . '`)" class="dropdown-item">Detail</button>
                                </li>
                            </ul>
                        </div>
                    </div>
                ';
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function create()
    {
        $this->saleService->createSale();

        return redirect()->route('transaction.index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'received' => 'required|numeric',
        ]);

        $this->saleService->updateSale(session('sale_id'), $request->only('total_items', 'total_price', 'received'));

        return redirect()->route('sale.index')->with('success', 'Transaksi berhasil disimpan!');
    }

    public function show($id)
    {
        $detail = $this->saleService->getSaleDetails($id);

        return datatables()
            ->of($detail)
            ->addIndexColumn()
            ->addColumn('code', function ($detail) {
                return '<span class="badge bg-success">' . $detail->products['code'] . '</span>';
            })
            ->addColumn('name', function ($detail) {
                return $detail->products['name'];
            })
            ->addColumn('price', function ($detail) {
                return Number::currency($detail->price, 'IDR', 'id');
            })
            ->addColumn('subtotal', function ($detail) {
                return Number::currency($detail->subtotal, 'IDR', 'id');
            })
            ->rawColumns(['code'])
            ->make(true);
    }

    public function edit($id)
    {
        session(['sale_id' => $id]);

        return redirect()->route('transaction.index');
    }

    public function destroy($id)
    {
        $this->saleService->deleteSale($id);

        return response()->json(
            'Data berhasil dihapus!',
            200
        );
    }

    public function print()
    {
        $data = $this->saleService->getPrintData();

        return view('sale.print', $data);
    }
}
