<?php

namespace App\Http\Controllers;

use App\Services\DashboardService;

class DashboardController extends Controller
{
    protected $dashboardService;

    public function __construct(DashboardService $dashboardService)
    {
        $this->dashboardService = $dashboardService;
    }

    public function index()
    {
        $dashboardData = $this->dashboardService->getDashboardData();

        return view('dashboard', [
            'categories' => $dashboardData['categoriesCount'],
            'products' => $dashboardData['productsCount'],
            'todayRevenue' => $dashboardData['todayRevenue'],
            'monthRevenue' => $dashboardData['monthRevenue'],
            'startDate' => date('Y-m-01'),
            'endDate' => date('Y-m-d'),
            'labelChart' => $dashboardData['labelChart'],
            'dataChart' => $dashboardData['dataChart'],
            'todaySales' => $dashboardData['todaySalesCount'],
            'monthSales' => $dashboardData['monthSalesCount'],
            'bestSellers' => $dashboardData['bestSellers'],
        ]);
    }
}
