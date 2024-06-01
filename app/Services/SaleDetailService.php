<?php

namespace App\Services;

use App\Models\Product;
use App\Models\SaleDetail;

class SaleDetailService
{
    public function getSaleDetails($saleId)
    {
        return SaleDetail::where('sale_id', $saleId)->with('products')->get();
    }

    public function addSaleDetail($saleId, $productId)
    {
        $product = Product::find($productId);

        if (!$product) {
            return response()->json('Data gagal disimpan', 400);
        }

        $detail = new SaleDetail();
        $detail->sale_id = $saleId;
        $detail->product_id = $product->id;
        $detail->price = $product->price;
        $detail->quantity = 1;
        $detail->subtotal = $product->price;
        $detail->save();

        return response()->json('Data berhasil disimpan', 200);
    }

    public function updateSaleDetail($id, $quantity)
    {
        $detail = SaleDetail::find($id);
        $detail->quantity = $quantity;
        $detail->subtotal = $detail->price * $quantity;
        $detail->update();
    }

    public function deleteSaleDetail($id)
    {
        SaleDetail::find($id)->delete();
    }

    public function calculateTotals($details)
    {
        $data = [];
        $total = 0;
        $total_items = 0;

        foreach ($details as $item) {
            $row = [];
            $row['code'] = '<span class="badge bg-success">' . $item->products->code . '</span>';
            $row['name'] = $item->products->name;
            $row['price'] = 'Rp' . indonesia_format($item->price);
            $row['quantity'] = '<input type="number" class="form-control form-control-sm quantity" data-id="' . $item->id . '" value="' . $item->quantity . '">';
            $row['subtotal'] = 'Rp' . indonesia_format($item->subtotal);
            $row['action'] = '<a onclick="deleteData(`' . route('transaction.destroy', $item->id) . '`)" class="btn btn-sm btn-danger btn-icon-split"><span class="icon text-white-50"><i class="fas fa-trash"></i></span><span class="text">Hapus</span></a>';
            $data[] = $row;

            $total += $item->price * $item->quantity;
            $total_items += $item->quantity;
        }

        $data[] = [
            'code' => '<div class="total d-none">' . $total . '</div><div class="total_items d-none">' . $total_items . '</div>',
            'name' => '',
            'price' => '',
            'quantity' => '',
            'subtotal' => '',
            'action' => '',
        ];

        return $data;
    }

    public function calculatePayment($total = 0, $received = 0)
    {
        $payed = $total;
        $change = ($received != 0) ? $received - $payed : 0;

        return [
            'total' => indonesia_format($total),
            'pay' => indonesia_format($payed),
            'change' => indonesia_format($change),
        ];
    }
}
