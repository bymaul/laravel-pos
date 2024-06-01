<?php

namespace App\Services;

use App\Models\Category;
use App\Models\Product;
use App\Models\Sale;
use App\Models\SaleDetail;
use Illuminate\Support\Facades\DB;

class DashboardService
{
    public function getDashboardData()
    {
        $categoriesCount = Category::count();
        $productsCount = Product::count();
        $todaySalesCount = Sale::whereDate('created_at', date('Y-m-d'))->count();
        $monthSalesCount = Sale::whereMonth('created_at', date('m'))->count();
        $todayRevenue = Sale::whereDate('created_at', date('Y-m-d'))->sum('total_price');
        $monthRevenue = Sale::whereMonth('created_at', date('m'))->sum('total_price');
        $startDate = date('Y-m-01');
        $endDate = date('Y-m-d');
        $labelChart = [];
        $dataChart = [];
        $bestSellers = SaleDetail::select('product_id', DB::raw('SUM(quantity) as quantity'))
            ->with('products')
            ->limit(6)
            ->groupBy('product_id')
            ->orderByDesc('quantity')
            ->get();

        while (strtotime($startDate) <= strtotime($endDate)) {
            $sales = Sale::whereDate('created_at', $startDate)->get();
            $total_sales = 0;

            foreach ($sales as $sale) {
                $total_sales += $sale->total_price;
            }

            $labelChart[] = (int) date('d', strtotime($startDate));
            $dataChart[] = $total_sales;

            $startDate = date('Y-m-d', strtotime('+1 day', strtotime($startDate)));
        }

        return [
            'categoriesCount' => $categoriesCount,
            'productsCount' => $productsCount,
            'todaySalesCount' => $todaySalesCount,
            'monthSalesCount' => $monthSalesCount,
            'todayRevenue' => $todayRevenue,
            'monthRevenue' => $monthRevenue,
            'labelChart' => $labelChart,
            'dataChart' => $dataChart,
            'bestSellers' => $bestSellers,
        ];
    }
}
