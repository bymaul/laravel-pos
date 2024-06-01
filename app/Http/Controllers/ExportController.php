<?php

namespace App\Http\Controllers;

use App\Services\ExportService;

class ExportController extends Controller
{
    protected $exportService;

    public function __construct(ExportService $exportService)
    {
        $this->exportService = $exportService;
    }

    public function export($startDate, $endDate)
    {
        $pdfContent = $this->exportService->export($startDate, $endDate);

        return response($pdfContent, 200)
            ->header('Content-Type', 'application/pdf');
    }
}
