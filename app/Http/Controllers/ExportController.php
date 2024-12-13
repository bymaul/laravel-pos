<?php

namespace App\Http\Controllers;

use App\Services\ExportService;

class ExportController extends Controller
{
    public function __construct(private readonly ExportService $exportService) {}

    public function export($startDate, $endDate)
    {
        $pdfContent = $this->exportService->export($startDate, $endDate);

        return response($pdfContent, 200)
            ->header('Content-Type', 'application/pdf');
    }
}
