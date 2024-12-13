<?php

namespace App\Services;

use App\Models\Sale;
use Carbon\Carbon;
use Codedge\Fpdf\Fpdf\Fpdf;
use Illuminate\Support\Number;

class ExportService
{

    public function __construct(private readonly Fpdf $fpdf) {}

    public function getData($startDate, $endDate)
    {
        $no = 1;
        $total_revenue = 0;
        $row = [];

        while (strtotime($startDate) <= strtotime($endDate)) {
            $sales = Sale::query()
                ->whereDate('created_at', $startDate)
                ->get();

            $total_sales = 0;
            $revenue = 0;

            foreach ($sales as $sale) {
                $total_sales += $sale->total_price;
                $revenue += $sale->total_price;
            }

            $row[] = [
                'DT_RowIndex' => $no++,
                'date' => $startDate,
                'total_sales' => Number::currency($total_sales, 'IDR', 'id'),
                'revenue' => Number::currency($revenue, 'IDR', 'id'),
            ];

            $total_revenue += $revenue;

            $startDate = date('Y-m-d', strtotime('+1 day', strtotime($startDate)));
        }

        $row[] = [
            'DT_RowIndex' => '',
            'date' => 'Total Pendapatan',
            'total_sales' => '',
            'revenue' => Number::currency($total_revenue, 'IDR', 'id'),
        ];

        return $row;
    }

    public function export($startDate, $endDate)
    {
        $data = $this->getData($startDate, $endDate);

        $this->fpdf->AddPage();
        $this->fpdf->SetFont('Times', 'B', 16);
        $this->fpdf->Cell(0, 5, 'LAPORAN PENDAPATAN', 0, 1, 'C');
        $this->fpdf->Ln(3);
        $this->fpdf->SetFont('Times', 'B', 14);
        $this->fpdf->Cell(0, 5, 'Periode ' . Carbon::parse($startDate)->locale('id')->isoFormat('D MMMM Y') . ' s/d ' . Carbon::parse($endDate)->locale('id')->isoFormat('D MMMM Y'), 0, 1, 'C');
        $this->fpdf->Ln(10);
        $this->fpdf->SetLeftMargin(25);

        $this->fpdf->SetFont('Times', 'B', 10);
        $this->fpdf->Cell(10, 7, 'NO', 1, 0, 'C');
        $this->fpdf->Cell(40, 7, 'TANGGAL', 1, 0, 'C');
        $this->fpdf->Cell(55, 7, 'PENJUALAN', 1, 0, 'C');
        $this->fpdf->Cell(55, 7, 'PENDAPATAN', 1, 0, 'C');

        $this->fpdf->SetFont('Times', '', 10);
        foreach ($data as $row) {
            if ($row['DT_RowIndex'] == '') {
                $this->fpdf->Ln();
                $this->fpdf->SetFont('Times', 'B', 10);
                $this->fpdf->Cell(105, 6, $row['date'], 1, 0, 'C');
                $this->fpdf->Cell(55, 6, ($row['revenue']), 1, 0, 'R');
            } else {
                $this->fpdf->Ln();
                $this->fpdf->Cell(10, 6, $row['DT_RowIndex'], 1, 0, 'C');
                $this->fpdf->Cell(40, 6, $row['date'], 1, 0, 'C');
                $this->fpdf->Cell(55, 6, ($row['total_sales']), 1, 0, 'R');
                $this->fpdf->Cell(55, 6, ($row['revenue']), 1, 0, 'R');
            }
        }

        $this->fpdf->Output('I', date('dm', strtotime($startDate)) . date('dm', strtotime($endDate)) . '_laporan_pendapatan.pdf');
    }
}
