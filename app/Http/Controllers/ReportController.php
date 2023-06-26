<?php

namespace App\Http\Controllers;

use App\Models\Sale;

class ReportController extends Controller
{
    public function index()
    {
        $startDate = date('Y-m-01');
        $endDate = date('Y-m-d');

        return view('report.index', compact('startDate', 'endDate'));
    }

    public function data($startDate, $endDate)
    {
        $no = 1;
        $total_sales = 0;
        $revenue = 0;
        $total_revenue = 0;

        while (strtotime($startDate) <= strtotime($endDate)) {
            $sales = Sale::whereDate('created_at', $startDate)->get();
            $total_sales = 0;
            $revenue = 0;

            foreach ($sales as $sale) {
                $total_sales += $sale->total_price;
                $revenue += $sale->total_price;
            }

            $row[] = [
                'DT_RowIndex' => $no++,
                'date' => $startDate,
                'total_sales' => indonesia_format($total_sales),
                'revenue' => indonesia_format($revenue),
            ];

            $total_revenue += $revenue;

            $startDate = date('Y-m-d', strtotime('+1 day', strtotime($startDate)));

            $data = $row;
        }

        $data[] = [
            'DT_RowIndex' => '',
            'date' => 'Total Pendapatan',
            'total_sales' => '',
            'revenue' => indonesia_format($total_revenue),
        ];

        return datatables()
            ->of($data)
            ->make(true);
    }
}
