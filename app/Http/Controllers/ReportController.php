<?php

namespace App\Http\Controllers;

use App\Services\ReportService;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function __construct(private readonly ReportService $reportService) {}

    public function index()
    {
        $startDate = date('Y-m-01');
        $endDate = date('Y-m-d');

        return view('report.index', compact('startDate', 'endDate'));
    }

    public function data(Request $request, $startDate, $endDate)
    {
        $data = $this->reportService->generateReportData($startDate, $endDate);

        return datatables()
            ->of($data)
            ->make(true);
    }
}
