<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);

require ('src/TCPDF/tcpdf.php');


function sanitizeValue($value) {
    $sanitizedValue = trim($value);
    $sanitizedValue = stripslashes($sanitizedValue);
    $sanitizedValue = htmlspecialchars($sanitizedValue, ENT_QUOTES);
	$sanitizedValue = str_replace('\n', ' ', $sanitizedValue);
	$sanitizedValue = str_replace('\r\n', ' ', $sanitizedValue);
	$sanitizedValue = str_replace('  ', ' ', $sanitizedValue);
	
    return $sanitizedValue;
}


function datasheets($csvFile){
	// create new PDF document
	$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
	// set document information
	$pdf->setCreator(PDF_CREATOR);
	$pdf->setTitle('Technical Data Sheet');

	// set header and footer fonts
	$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
	$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

	// set default monospaced font
	$pdf->setDefaultMonospacedFont(PDF_FONT_MONOSPACED);

	// set margins
	$pdf->setMargins(PDF_MARGIN_LEFT, 5, PDF_MARGIN_RIGHT);
	$pdf->setHeaderMargin(PDF_MARGIN_HEADER);
	$pdf->setFooterMargin(PDF_MARGIN_FOOTER);

	// set auto page breaks
	$pdf->setAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

	//disable header and footer
	$pdf->SetPrintHeader(false);
	$pdf->SetPrintFooter(false);

	// set image scale factor
	$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

	// set default font subsetting mode
	$pdf->setFontSubsetting(true);

	$csv = array_map('str_getcsv', file($csvFile));
	$count = count($csv)-1;
	for($i=1;$i<=$count;$i++) {
		
		$title = sanitizeValue($csv[$i][0]);

		$headerImage = sanitizeValue($csv[$i][1]);
		$headerImageHeight = sanitizeValue($csv[$i][2]);

		$footerImage = sanitizeValue($csv[$i][3]);
		$footerImageHeight = sanitizeValue($csv[$i][4]);

		$productSku = sanitizeValue($csv[$i][5]);
		$productTitle = sanitizeValue($csv[$i][6]);
		$productDescription = sanitizeValue($csv[$i][7]);
		$productImage = $csv[$i][8];

		$pdf->AddPage();

		$headerImageHtml = '<div style="text-align: center;"> <img src="'.$headerImage.'" height="'.$headerImageHeight.'px"></div>';
		$pdf->writeHTML($headerImageHtml, true, 0, true, 0);

		$header = '<p align="center"><h1>'.$title.'</h1><br><h2>'.$productTitle.'</h2></p>';
		$pdf->writeHTML($header, true, 0, true, 0);

		$productImageHtml = '<div style="text-align: center;"><img src="' . $productImage . '" height="300px"></div>';
		$pdf->writeHTML($productImageHtml, true, 0, true, 0);

		$productDescriptionHtml = '<p align="justify">'.$productDescription.'</p>';
		$pdf->writeHTML($productDescriptionHtml, true, 0, true, 0);

		$productSkuHtml = '<br><p align="left"><b>SKU: '.$productSku.'</b></p>';
		$pdf->writeHTML($productSkuHtml, true, 0, true, 0);

		$footer = '<br><br><div> <img src="'.$footerImage.'" height="'.$footerImageHeight.'px"></div>';
		$pdf->writeHTML($footer, true, 0, true, 0);
	}
	$pdf->Output('example_001.pdf', 'I');
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_FILES["csv_file"])) {
        $csvFile = $_FILES["csv_file"]["tmp_name"];
		$originalFileName = $_FILES["csv_file"]["name"];
		$ext = pathinfo($originalFileName, PATHINFO_EXTENSION);

		if($ext != 'csv') {
			die("Error: File extension not allowed.");
		}
        datasheets($csvFile);
    } else {
        die("Error: CSV file not found.");
    }
}

?>