<?php

namespace App\Services;

use App\Models\Sale;
use App\Models\SaleDetail;

class SaleService
{
    public function getSalesData()
    {
        $isAdmin = auth()->user()->role == 'admin';

        return $isAdmin ?
            Sale::where('total_items', '!=', 0)->with('user')->orderBy('created_at', 'desc')->get() :
            Sale::where('total_items', '!=', 0)->where('user_id', auth()->user()->id)->with('user')->orderBy('created_at', 'desc')->get();
    }

    public function createSale()
    {
        $sale = new Sale();
        $sale->total_items = 0;
        $sale->total_price = 0;
        $sale->user_id = auth()->user()->id;
        $sale->save();

        session(['sale_id' => $sale->id]);

        return $sale;
    }

    public function updateSale($saleId, $data)
    {
        $sale = Sale::find($saleId);
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
        $sale = Sale::find($saleId);
        $sale->delete();

        if (session('sale_id') == $saleId) {
            session()->forget('sale_id');
        }

        return $sale;
    }

    public function getPrintData()
    {
        if (!session('last_sale')) {
            abort(404);
        }

        $sale = Sale::find(session('last_sale')['id']);
        $saleDetail = SaleDetail::with('products')
            ->where('sale_id', session('last_sale')['id'])
            ->get();

        return compact('sale', 'saleDetail');
    }
}
