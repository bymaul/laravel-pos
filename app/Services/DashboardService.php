<?php

namespace App\Services;

use App\Models\Category;
use App\Models\Product;
use App\Models\Sale;
use App\Models\SaleDetail;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class DashboardService
{
    public function getDashboardData()
    {
        $currentDate = Carbon::now();
        $monthStart = $currentDate->copy()->startOfMonth();
        $categoriesCount = Category::query()->count();
        $productsCount = Product::query()->count();

        $todaySalesCount = $this->getSalesCountByDate($currentDate);
        $monthSalesCount = $this->getSalesCountByMonth($currentDate->month);
        $todayRevenue = $this->getRevenueByDate($currentDate);
        $monthRevenue = $this->getRevenueByMonth($currentDate->month);

        [$labelChart, $dataChart] = $this->generateSalesChartData($monthStart, $currentDate);

        $bestSellers = $this->getBestSellers();

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

    private function getSalesCountByDate(Carbon $date)
    {
        return Sale::query()
            ->whereDate('created_at', $date)
            ->count();
    }

    private function getSalesCountByMonth($month)
    {
        return Sale::query()
            ->whereMonth('created_at', $month)
            ->count();
    }

    private function getRevenueByDate(Carbon $date)
    {
        return Sale::query()
            ->whereDate('created_at', $date)
            ->sum('total_price');
    }

    private function getRevenueByMonth($month)
    {
        return Sale::query()
            ->whereMonth('created_at', $month)
            ->sum('total_price');
    }

    private function generateSalesChartData(Carbon $startDate, Carbon $endDate)
    {
        $labelChart = [];
        $dataChart = [];

        while ($startDate->lte($endDate)) {
            $totalSales = Sale::query()
                ->whereDate('created_at', $startDate)
                ->sum('total_price');

            $labelChart[] = $startDate->day;
            $dataChart[] = $totalSales;

            $startDate->addDay();
        }

        return [$labelChart, $dataChart];
    }

    private function getBestSellers()
    {
        return SaleDetail::query()
            ->select('product_id', DB::raw('SUM(quantity) as quantity'))
            ->with('product')
            ->groupBy('product_id')
            ->orderByDesc('quantity')
            ->limit(6)
            ->get();
    }
}
