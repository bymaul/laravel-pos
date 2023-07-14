<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use Codedge\Fpdf\Fpdf\Fpdf;

class ExportController extends Controller
{
    protected $fpdf;

    public function __construct()
    {
        $this->fpdf = new Fpdf;
    }

    public function getData($startDate, $endDate)
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

        return $data;
    }

    public function export($startDate, $endDate)
    {
        $data = $this->getData($startDate, $endDate);

        $this->fpdf->AddPage();
        $this->fpdf->SetFont('Times', 'B', 16);
        $this->fpdf->Cell(0, 5, 'LAPORAN PENDAPATAN', 0, 1, 'C');
        $this->fpdf->Ln(3);
        $this->fpdf->SetFont('Times', 'B', 14);
        $this->fpdf->Cell(0, 5, 'Periode '.indonesia_date($startDate, false).' s/d '.indonesia_date($endDate, false), 0, 1, 'C');
        $this->fpdf->Ln(10);
        $this->fpdf->SetLeftMargin(25);

        $this->fpdf->SetFont('Times', 'B', 10);
        $this->fpdf->Cell(10, 7, 'NO', 1, 0, 'C');
        $this->fpdf->Cell(40, 7, 'TANGGAL', 1, 0, 'C');
        $this->fpdf->Cell(55, 7, 'PENJUALAN', 1, 0, 'C');
        $this->fpdf->Cell(55, 7, 'PEDAPATAN', 1, 0, 'C');

        $this->fpdf->SetFont('Times', '', 10);
        foreach ($data as $row) {
            if ($row['DT_RowIndex'] == '') {
                $this->fpdf->Ln();
                $this->fpdf->SetFont('Times', 'B', 10);
                $this->fpdf->Cell(105, 6, $row['date'], 1, 0, 'C');
                $this->fpdf->Cell(55, 6, ($row['revenue']), 1, 0, 'R');
            }

            if ($row['DT_RowIndex'] != '') {
                $this->fpdf->Ln();
                $this->fpdf->Cell(10, 6, $row['DT_RowIndex'], 1, 0, 'C');
                $this->fpdf->Cell(40, 6, $row['date'], 1, 0, 'C');
                $this->fpdf->Cell(55, 6, ($row['total_sales']), 1, 0, 'R');
                $this->fpdf->Cell(55, 6, ($row['revenue']), 1, 0, 'R');
            }
        }

        $this->fpdf->Output('I', date('dm', strtotime($startDate)).date('dm', strtotime($endDate)).'_laporan_pendapatan.pdf');

        exit;
    }
}
