<?php
// Check if FPDF is available
if (!file_exists('fpdf/fpdf.php')) {
    die('FPDF library not found!');
}

// Include FPDF library
require('fpdf/fpdf.php');

// Include database connection
include('../database/connection.php');

// Create instance of FPDF
$pdf = new FPDF();

// Set the page to landscape to have more horizontal space
$pdf->AddPage('L');

// Set margins
$pdf->SetMargins(5, 5, 5);

// Set font for the title
$pdf->SetFont('Arial', 'B', 16);
$pdf->Cell(0, 10, 'Computer Information Report', 0, 1, 'C');

// Add some space
$pdf->Ln(10);

// Set font for the table header (smaller size)
$pdf->SetFont('Arial', 'B', 10);

// Adjusted column widths
$pdf->Cell(12, 10, 'ID', 1, 0, 'C'); 
$pdf->Cell(25, 10, 'Asset ID', 1, 0, 'C');
$pdf->Cell(35, 10, 'Computer Name', 1, 0, 'C');
$pdf->Cell(20, 10, 'Type', 1, 0, 'C');
$pdf->Cell(25, 10, 'OS', 1, 0, 'C');
$pdf->Cell(35, 10, 'Processor', 1, 0, 'C');
$pdf->Cell(18, 10, 'RAM', 1, 0, 'C');
$pdf->Cell(25, 10, 'Storage', 1, 0, 'C');
$pdf->Cell(25, 10, 'Graphics', 1, 0, 'C');
$pdf->Cell(18, 10, 'Monitor', 1, 0, 'C');
$pdf->Cell(25, 10, 'Lab', 1, 1, 'C');

// Set font for table content (smaller size)
$pdf->SetFont('Arial', '', 8);

// Query to fetch all computer records
$query = "SELECT * FROM computers";
$result = $conn->query($query);

// Check if there are any records
if ($result->num_rows > 0) {
    // Fetch each record and display it in the table
    while ($row = $result->fetch_assoc()) {
        // Get current Y position for accurate row height
        $currentY = $pdf->GetY();

        // First column: ID
        $pdf->SetXY(10, $currentY); // Adjust X and Y to the correct position
        $pdf->Cell(12, 10, $row['id'], 1, 0, 'C');

        // Second column: Asset ID
        $pdf->SetXY(22, $currentY); 
        $pdf->Cell(25, 10, $row['asset_id'], 1, 0, 'C');
        
        // Third column: Computer Name (using MultiCell for wrapping text)
        $pdf->SetXY(47, $currentY); 
        $pdf->MultiCell(35, 10, $row['computer_name'], 1, 'C');
        
        // Fourth column: Type
        $pdf->SetXY(82, $currentY); 
        $pdf->Cell(20, 10, $row['computer_type'], 1, 0, 'C');

        // Fifth column: Operating System
        $pdf->SetXY(102, $currentY); 
        $pdf->MultiCell(25, 10, $row['operating_system'], 1, 'C');
        
        // Sixth column: Processor
        $pdf->SetXY(127, $currentY); 
        $pdf->MultiCell(35, 10, $row['processor_details'], 1, 'C');
        
        // Seventh column: RAM
        $pdf->SetXY(162, $currentY); 
        $pdf->Cell(18, 10, $row['ram_size'], 1, 0, 'C');
        
        // Eighth column: Storage
        $pdf->SetXY(180, $currentY); 
        $pdf->Cell(25, 10, $row['storage_details'], 1, 0, 'C');
        
        // Ninth column: Graphics
        $pdf->SetXY(205, $currentY); 
        $pdf->Cell(25, 10, $row['graphics_card'], 1, 0, 'C');
        
        // Tenth column: Monitor
        $pdf->SetXY(230, $currentY); 
        $pdf->Cell(18, 10, $row['monitor_details'], 1, 0, 'C');
        
        // Eleventh column: Lab
        $pdf->SetXY(248, $currentY); 
        $pdf->Cell(25, 10, $row['Lab'], 1, 1, 'C');
        
        // Check the Y position after the row, if it's greater than the initial Y, adjust for next row
        $newY = $pdf->GetY();
        if ($newY > $currentY + 10) {
            $rowHeight = $newY - $currentY;
        } else {
            $rowHeight = 10; // Default row height
        }
        
        // Move the Y position for the next row
        $pdf->SetY($newY);
    }
} else {
    $pdf->Cell(200, 10, 'No records found.', 0, 1, 'C');
}

// Close the database connection
$conn->close();

// Output the PDF to the browser
$pdf->Output();
?>
