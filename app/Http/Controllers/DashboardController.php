<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Sale;

class DashboardController extends Controller
{
    public function index()
    {
        $categories = Category::count();
        $products = Product::count();
        $todaySales = Sale::whereDate('created_at', date('Y-m-d'))->count();
        $monthSales = Sale::whereMonth('created_at', date('m'))->count();
        $todayRevenue = Sale::whereDate('created_at', date('Y-m-d'))->sum('total_price');
        $monthRevenue = Sale::whereMonth('created_at', date('m'))->sum('total_price');
        $startDate = date('Y-m-01');
        $endDate = date('Y-m-d');
        $labelChart = [];
        $dataChart = [];

        while (strtotime($startDate) <= strtotime($endDate)) {
            $sales = Sale::whereDate('created_at', $startDate)->get();
            $total_sales = 0;

            foreach ($sales as $sale) {
                $total_sales += $sale->total_price;
            }

            $labelChart[] = (int) date('d', strtotime($startDate));

            $dataChart[] += $total_sales;

            $startDate = date('Y-m-d', strtotime('+1 day', strtotime($startDate)));
        }

        // reset date from loop
        $startDate = date('Y-m-01');

        return view('dashboard', compact(
            'categories',
            'products',
            'todayRevenue',
            'monthRevenue',
            'startDate',
            'endDate',
            'labelChart',
            'dataChart',
            'todaySales',
            'monthSales',
        ));
    }
}
