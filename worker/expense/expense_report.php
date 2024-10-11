<?php

require_once('../core/Database.php');
require_once('../core/expenseController.php');
require_once('../fpdf/fpdf.php');

class PDF extends FPDF
{
    function Header()
    {
        // Logo
        $this->Image('../assets/img/pig-logo.png', 10, 6, 30);
        // Arial bold 15
        $this->SetFont('Courier', 'B', 15);
        // Move to the right
        $this->Cell(80);
        // Title
        $this->Cell(30, 10, 'Barangay Liberty Abal Piggery', 0, 0, 'C');
        // Line break
        $this->Ln(20);

        $this->SetFont('Courier', '', 12);
        $this->Cell(0, 10, 'Expense Report', 0, 1, 'C');
        $this->Cell(0, 10, 'Generated on: ' . date('F d, Y'), 0, 1, 'C');
        $this->Ln(10);
    }

    function Footer()
    {
        // Position at 1.5 cm from bottom
        $this->SetY(-15);
        // Arial italic 8
        $this->SetFont('Courier', 'I', 8);
        // Page number
        $this->Cell(0, 10, 'Page ' . $this->PageNo() . '/{nb}', 0, 0, 'C');
    }
}

// Instantiation of inherited class
$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();

// Fetch expenses
$expenseController = new expenseController();
$expenses = $expenseController->getAllExpenses();

// Table header
$pdf->SetFont('Courier', 'B', 12);
$pdf->Cell(50, 10, 'Expense Name', 1);
$pdf->Cell(40, 10, 'Expense Type', 1);
$pdf->Cell(40, 10, 'Expense Cost', 1);
$pdf->Cell(60, 10, 'Expense Date', 1);
$pdf->Ln();

// Table data
$pdf->SetFont('Courier', '', 12);
$totalExpense = 0;
foreach ($expenses as $expense) {
    $pdf->Cell(50, 10, $expense['expenseName'], 1);
    $pdf->Cell(40, 10, $expense['expenseType'], 1);
    $pdf->Cell(40, 10, '' . number_format($expense['total'], 2), 1);
    $pdf->Cell(60, 10, date('M d, Y', strtotime($expense['expenseDate'])), 1);
    $pdf->Ln();
    $totalExpense += $expense['total'];
}

// Total
$pdf->SetFont('Courier', 'B', 12);
$pdf->Cell(130, 10, 'Total Expenses:', 1);
$pdf->Cell(60, 10, '' . number_format($totalExpense, 2), 1);

// Output PDF to a specified path
$pdfFilePath = 'Expense_Report.pdf';
$pdf->Output($pdfFilePath, 'F');

// Check if PDF was created successfully
if (file_exists($pdfFilePath)) {
    echo "PDF generated successfully. <a href='$pdfFilePath' target='_blank'>Download PDF</a>";
} else {
    echo "Failed to generate PDF.";
}
