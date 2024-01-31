<?php
require_once('tcpdf/tcpdf.php');
require_once('connection.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve the entered invoice ID from the form
    $invoiceId = isset($_POST['invoiceId']) ? $_POST['invoiceId'] : '';

    // Create a new PDF document
    $pdf = new TCPDF();
    $pdf->SetAutoPageBreak(true, 10);

    // Set document information
    $pdf->SetCreator('Your Company');
    $pdf->SetAuthor('Your Name');
    $pdf->SetTitle('Invoice');

    // Add a page to the PDF
    $pdf->AddPage();

    // Set font
    $pdf->SetFont('helvetica', '', 12);

    // Set Company Name and Address
    $companyName = 'VIYAGULA SECURITY SERVICES';

    // Break the address into three lines
    $companyAddress = array(
        '15/456 NO.2, ANNAI KAMATCHI NAGAR',
        'MALAIPATTY ROAD, THOTTANATHU POST',
        'DINDIGUL 624003, TAMIL NADU'
    );

    // Set logo file path and dimensions
    $logoPath = 'Logo.png';
    $logoWidth = 30;  // adjust based on your logo dimensions
    $logoHeight = 30; // adjust based on your logo dimensions

    // Push logo 5 pixels away from the left page border
    $logoX = 15;  // 10 (original X position) + 5 (additional spacing)
    $pdf->Image($logoPath, $logoX, 15, $logoWidth, $logoHeight);

    // Output Company Name and Address below the logo
    $pdf->SetX($logoX); // Set the X position for the company name and address below the logo
    $pdf->SetFont('helvetica', 'B', 15);
    $pdf->Cell(0, 10, $companyName, 0, 1, 'C');
    $pdf->SetFont('helvetica', '', 12);
    $pdf->MultiCell(0, 10, implode("\n", $companyAddress), 0, 'C');

    // Set top margin to 0 for subsequent pages
    $pdf->SetMargins(15, 0, 15);

    // Set line style for the border
    $pdf->SetLineStyle(array('width' => 0.5, 'color' => array(0, 0, 0)));

    // Draw a border around the entire page
    $pdf->Rect(10, 10, $pdf->getPageWidth() - 20, $pdf->getPageHeight() - 20);

    // Fetch data for the specified invoice ID from the database
    $query = "SELECT * FROM invoices WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $invoiceId);
    $stmt->execute();
    $result = $stmt->get_result();

    // ...

        // ...

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();

            // Output Customer Name and Invoice ID on the same line
            $pdf->SetX($logoX);
            $pdf->Cell(0, 25, ' ' , 0, 1, 'R');
            $pdf->Cell(140, 1, 'TO: ' . $row['name'], 0, 0, 'L');
            
            
            $pdf->Cell(25, 1, 'Invoice ID: ' . $row['invoice_num'], 0, 1, 'R');

            // Output Address directly below the customer name and invoice ID
            $pdf->SetX($logoX);
            $pdf->Cell(30, 1, '       ' . $row['address'], 0, 1, 'L');

            // Calculate Total Amount
            $totalsecurityAmount = $row['security_count'] * $row['security_amount'];

            // Add a table with headers
            $pdf->Ln(10); // Add some space between address and the table
            $pdf->SetFont('helvetica', 'B', 12);
            $pdf->Cell(45, 10, 'Description', 1, 0, 'C');
            $pdf->Cell(45, 10, 'Number of Guards', 1, 0, 'C');
            $pdf->Cell(90, 10, 'Amount (Rs)', 1, 1, 'C');
           

            // Add data to the table
            $totalsecurityAmount = $row['security_count'] * $row['security_amount'];

            $pdf->SetFont('helvetica', '', 12);
            $pdf->Cell(45, 10, 'Security Guard', 1, 0, 'L');
            $pdf->Cell(45, 10, $row['security_count'], 1, 0, 'C');
            $pdf->Cell(45, 10, 'Rs. ' . $row['security_amount'], 1, 0, 'C');
            $pdf->Cell(45, 10, 'Rs. ' . $totalsecurityAmount, 1, 1, 'C');

            $totalcompanysecurityAmount = $row['company_security_count'] * $row['company_security_amount'];
            
            $pdf->SetFont('helvetica', '', 12);
            $pdf->Cell(45, 10, 'Company Security', 1, 0, 'L');
            $pdf->Cell(45, 10, $row['company_security_count'], 1, 0, 'C');
            $pdf->Cell(45, 10, 'Rs. ' . $row['company_security_amount'], 1, 0, 'C');
            $pdf->Cell(45, 10, 'Rs. ' . $totalcompanysecurityAmount, 1, 1, 'C');

            $totalpersonalsecurityAmount = $row['personal_security_count'] * $row['personal_security_amount'];
            
            $pdf->SetFont('helvetica', '', 12);
            $pdf->Cell(45, 10, 'Persoanal Guard', 1, 0, 'L');
            $pdf->Cell(45, 10, $row['personal_security_count'], 1, 0, 'C');
            $pdf->Cell(45, 10, 'Rs. ' . $row['personal_security_amount'], 1, 0, 'C');
            $pdf->Cell(45, 10, 'Rs. ' . $totalpersonalsecurityAmount, 1, 1, 'C');

            $totalprivatesecurityAmount = $row['private_security_count'] * $row['private_security_amount'];
            
            $pdf->SetFont('helvetica', '', 12);
            $pdf->Cell(45, 10, 'Private Security', 1, 0, 'L');
            $pdf->Cell(45, 10, $row['private_security_count'], 1, 0, 'C');
            $pdf->Cell(45, 10, 'Rs. ' . $row['private_security_amount'], 1, 0, 'C');
            $pdf->Cell(45, 10, 'Rs. ' . $totalprivatesecurityAmount, 1, 1, 'C');

            $totalladysecurityAmount = $row['lady_security_count'] * $row['lady_security_amount'];
            
            $pdf->SetFont('helvetica', '', 12);
            $pdf->Cell(45, 10, 'Lady Security Guard', 1, 0, 'L');
            $pdf->Cell(45, 10, $row['lady_security_count'], 1, 0, 'C');
            $pdf->Cell(45, 10, 'Rs. ' . $row['lady_security_amount'], 1, 0, 'C');
            $pdf->Cell(45, 10, 'Rs. ' . $totalladysecurityAmount, 1, 1, 'C');
            
            $total=$totalsecurityAmount+$totalcompanysecurityAmount+$totalpersonalsecurityAmount+$totalprivatesecurityAmount+$totalladysecurityAmount;

            $pdf->SetFont('helvetica', 'B', 12);
            $pdf->Cell(45, 10, '', 0, 0, 'C');
            $pdf->Cell(45, 10,'' , 0, 0, 'C');
            $pdf->Cell(45, 10, 'Total', 1, 0, 'C');
            $pdf->SetFont('helvetica', '', 12);
            $pdf->Cell(45, 10, 'Rs. ' . $total, 1, 1, 'C');

            $pdf->SetFont('helvetica', 'B', 12);
            $pdf->Cell(45, 10, 'Mode of Payment:', 0, 0, 'C');
            $pdf->SetFont('helvetica', '', 12);
            $pdf->Cell(45, 10,$row['mode_of_payment'] , 0, 0, 'L');
            $pdf->SetFont('helvetica', 'B', 12);
            $pdf->Cell(45, 10, 'GST', 1, 0, 'C');
            $pdf->SetFont('helvetica', '', 12);
            $pdf->Cell(45, 10, $row['gst'].'%', 1, 1, 'C');
            
            $grandtotal=(($row['gst']/100)*$total)+$total ;

            $pdf->SetFont('helvetica', 'B', 12);
            $pdf->Cell(45, 10, '', 0, 0, 'C');
            $pdf->Cell(45, 10,'' , 0, 0, 'C');
            $pdf->Cell(45, 10, 'Total Amount', 1, 0, 'C');
            $pdf->SetFont('helvetica', '', 12);
            $pdf->Cell(45, 10, 'Rs. '.$grandtotal, 1, 1, 'C');
            
            $pdf->Ln(10);
            $pdf->SetFont('helvetica', 'B', 12);
            $pdf->Cell(150, 2, 'General Terms of Agreement:', 0, 1, 'L');

            $pdf->Ln(5);
            $pdf->SetFont('helvetica', 'B', 10);
            $pdf->Cell(0, 5, "1. The above rates are based on the existing minimum wages and any revision in minimum wages statutory", 0, 1, 'L');
            $pdf->Cell(0, 5, "   compliance would result in a pro-rate change in the rates.", 0, 1, 'L');
            $pdf->Cell(0, 5, "2. Working schedule 12 hours a day & seven days of the week as per Client preference", 0, 1, 'L');
            $pdf->Cell(0, 5, "3. Statutory compliance's we shall be responsible for all statutory compliance like ESI, PF etc. In respect of", 0, 1, 'L');
            $pdf->Cell(0, 5, "   our employees", 0, 1, 'L');
            $pdf->Cell(0, 5, "4. Uniform our personal will be smartly turned out at all time.", 0, 1, 'L');
            $pdf->Cell(0, 5, "5. Monthly invoice for the services rendered will be submitted on the 1st the succeeding month & payment ", 0, 1, 'L');
            $pdf->Cell(0, 5, "6. The contract shall be initially for one year and automatically renewable for equal periods unless other ", 0, 1, 'L');
            $pdf->Cell(0, 5, "   parties wishes to terminate by giving one month notice to the other party.", 0, 1, 'L');
            $pdf->Cell(0, 5, "7.Formal contract will be signed before the development so security personal at the site.", 0, 1, 'L');

            $pdf->Ln(5);
            $pdf->Cell(0, 5, "We trust that the same will have your concurrence. Should you have further query. Please do not hesitate", 0, 1, 'L');
            $pdf->Cell(0, 5, " to contact us.", 0, 1, 'L');
            
            $pdf->Ln(3);
            $pdf->Cell(0, 5, "Thanking You", 0, 1, 'C');

            
            
            
        } else {
            $pdf->Cell(45, 10, 'No records found for the specified Invoice ID.');
        }

// ...

// Output the PDF as a file (you can also use 'I' to display it in the browser)
$pdf->Output('invoice.pdf', 'D');
} else {
    // Redirect to the form if accessed directly without a POST request
    header('Location: index.html');
    exit();
}
?>