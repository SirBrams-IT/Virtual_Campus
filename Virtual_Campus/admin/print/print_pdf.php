<?php
require('fpdf.php');

class PDF extends FPDF
{
    //Header
    function Header()
    {
        $this->SetFont('Helvetica', '', 25);
        $this->SetFontSize(40);
        $this->Cell(80);
        $this->Ln();
    }

    //Page footer
    function Footer()
    {
    }

    //Simple table
    function BasicTable($header, $data)
    {
        $this->SetFillColor(255, 255, 255);
        $w = array(25, 20, 30, 20, 20, 20, 20, 20, 20, 20, 20, 20);

        //Header
        $this->SetFont('Arial', 'B', 9);
        for ($i = 0; $i < count($header); $i++)
            $this->Cell($w[$i], 9, $header[$i], 1, 0, 'L', true);
        $this->Ln();

        //Data
        $this->SetFont('Arial', '', 10);
        foreach ($data as $eachResult) {
            $this->Cell(10);
            $this->Cell(25, 6, $eachResult["product_id"], 1);
            $this->Cell(20, 6, $eachResult["product_brand"], 1);
            $this->Cell(30, 6, $eachResult["product_title"], 1);
            $this->Cell(30, 7, $eachResult["product_price"], 1);
           
            $this->Ln();
        }
    }
}

$pdf = new PDF();

$header = array('product_id', 'product_brand', 'product_title', 'product_price', );

$pdf->AddPage();

$pdf->SetFont('Helvetica', '', 14);
$pdf->Cell(68);
$pdf->Write(5, 'MARKET PLACE FOR FARMERS');
$pdf->Ln();

$pdf->Cell(22);
$pdf->SetFontSize(8);
$pdf->Cell(57);
$pdf->Write(5, date('l, F j, Y'));
$pdf->Ln();

$objConnect = mysqli_connect("localhost", "root", "") or die("Error:Please check your database username & password");
mysqli_select_db($objConnect, "farmers market place");
$strSQL = "SELECT product_id, product_brand, product_title, product_price, product_image FROM products";
$objQuery = mysqli_query($objConnect, $strSQL);
$resultData = array();
if ($objQuery) {
    while ($result = mysqli_fetch_array($objQuery)) {
        array_push($resultData, $result);
    }
} else {
    die("Error: " . mysqli_error($objConnect));
}

$pdf->Ln(5);
$pdf->Cell(0);
$pdf->Write(5, 'Total users: ' . mysqli_num_rows($objQuery));
$pdf->Ln();

$pdf->Ln(5);
$pdf->Ln(0);
$pdf->Cell(10);
$pdf->BasicTable($header, $resultData);

$pdf->Output();
mysqli_close($objConnect);
?>
