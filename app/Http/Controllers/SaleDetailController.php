<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Sale;
use Illuminate\Http\Request;
use App\Services\SaleDetailService;

class SaleDetailController extends Controller
{
    protected $saleDetailService;

    public function __construct(SaleDetailService $saleDetailService)
    {
        $this->saleDetailService = $saleDetailService;
    }

    public function index()
    {
        $sale_id = session('sale_id') ? (Sale::find(session('sale_id'))->id ?? null) : null;
        $products = Product::all();

        if ($sale_id) {
            return view('sale_detail.index', compact('products', 'sale_id'));
        } else {
            return redirect()->route('transaction.new');
        }
    }

    public function data($id)
    {
        $details = $this->saleDetailService->getSaleDetails($id);
        $data = $this->saleDetailService->calculateTotals($details);

        return datatables()
            ->of($data)
            ->addIndexColumn()
            ->rawColumns(['action', 'code', 'quantity'])
            ->make(true);
    }

    public function store(Request $request)
    {
        return $this->saleDetailService->addSaleDetail($request->saleId, $request->productId);
    }

    public function update(Request $request, $id)
    {
        $this->saleDetailService->updateSaleDetail($id, $request->quantity);
    }

    public function destroy($id)
    {
        $this->saleDetailService->deleteSaleDetail($id);

        return response(null, 204);
    }

    public function loadForm($total = 0, $received = 0)
    {
        $data = $this->saleDetailService->calculatePayment($total, $received);

        return response()->json($data);
    }
}
