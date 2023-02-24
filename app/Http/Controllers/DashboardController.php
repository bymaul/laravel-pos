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
        $today_sales = Sale::whereDate('created_at', date('Y-m-d'))->count();
        $month_sales = Sale::whereMonth('created_at', date('m'))->count();
        $today_revenue = Sale::whereDate('created_at', date('Y-m-d'))->sum('total_price');
        $month_revenue = Sale::whereMonth('created_at', date('m'))->sum('total_price');
        $start_date = $startDate = date('Y-m-d', mktime(0, 0, 0, date('m'), 1, date('Y')));
        $end_date = date('Y-m-d');
        $label_chart = [];
        $data_chart = [];

        while (strtotime($start_date) <= strtotime($end_date)) {
            $sales = Sale::whereDate('created_at', $start_date)->get();
            $total_sales = 0;

            foreach ($sales as $sale) {
                $total_sales += $sale->total_price;
            }

            $label_chart[] = (int) date('d', strtotime($start_date));

            $data_chart[] += $total_sales;

            $start_date = date('Y-m-d', strtotime('+1 day', strtotime($start_date)));
        }

        return view('dashboard', compact(
            'categories',
            'products',
            'today_revenue',
            'month_revenue',
            'start_date',
            'end_date',
            'label_chart',
            'data_chart',
            'today_sales',
            'month_sales',
        ));
    }
}
