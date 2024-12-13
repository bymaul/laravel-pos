<?php

namespace App\Services;

use App\Models\Sale;
use App\Models\SaleDetail;
use Illuminate\Support\Facades\Auth;

class SaleService
{
    public function getSalesData()
    {
        $isAdmin = Auth::user()->role == 'admin';
        $query = Sale::with('user')->where('total_items', '!=', 0)->orderBy('created_at', 'desc');

        return $isAdmin ?
            $query->get() :
            $query->where('user_id', Auth::user()->id)->get();
    }

    public function createSale()
    {
        $sale = new Sale();
        $sale->total_items = 0;
        $sale->total_price = 0;
        $sale->user_id = Auth::user()->id;
        $sale->save();

        session(['sale_id' => $sale->id]);

        return $sale;
    }

    public function updateSale($saleId, $data)
    {
        $sale = Sale::query()->find($saleId);
        $sale->update([
            'total_items' => $data['total_items'],
            'total_price' => $data['total_price'],
        ]);

        session(['last_sale' => [
            'id' => $saleId,
            'received' => $data['received'],
        ]]);

        session()->forget('sale_id');

        return $sale;
    }

    public function getSaleDetails($saleId)
    {
        return SaleDetail::with('products')
            ->where('sale_id', $saleId)
            ->get();
    }

    public function deleteSale($saleId)
    {
        $sale = Sale::query()->find($saleId);
        $sale->delete();

        if (session('sale_id') == $saleId) {
            session()->forget('sale_id');
        }

        return $sale;
    }

    public function getPrintData()
    {
        abort_if(!session('last_sale'), 404);

        $sale = Sale::query()->find(session('last_sale')['id']);
        $saleDetail = SaleDetail::with('products')
            ->where('sale_id', session('last_sale')['id'])
            ->get();

        return compact('sale', 'saleDetail');
    }
}
