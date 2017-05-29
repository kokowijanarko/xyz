<?php
session_start();

/**
*   Required Class
*/
require_once(__DIR__ . '/lib/db.class.php');
require_once(__DIR__ . '/class/user.class.php');
require_once(__DIR__ . '/class/inventory.class.php');
require_once(__DIR__ . '/class/location.class.php');
require_once(__DIR__ . '/class/device.class.php');
require('assets/plugins/fpdf181/fpdf.php');

class PDF extends FPDF
{

    // Page header
    function Header()
    {
        $this->invClass  = new Inventory();
        // Logo
        if ($this->invClass->setting_data("inventory_logo")!="") { 
            $logo_image = "assets/images/".$this->invClass->setting_data("inventory_logo"); } 
        else {
            $logo_image = "assets/images/logo.png";
        }
        $this->Image($logo_image,10,6,50);

        // Arial bold 15
        // Move to the right
        // Title
        $this->SetFont('Arial','B',15);
        $this->Cell(80);
        $this->Cell(30,10,$this->invClass->setting_data("inventory_name"),0,1,'C');

        $this->SetFont('Arial','',12);
        $this->Cell(80);
        $this->Cell(30,5,'Detailed Report',0,0,'C');
        // Line break
        $this->Ln(10);

        $this->Line(10,30,200,30);
    }

    // Page footer
    function Footer()
    {
        // Position at 1.5 cm from bottom
        $this->SetY(-15);
        // Arial italic 8
        $this->SetFont('Arial','I',8);
        // Page number
        $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
    }
}

// Instanciation of inherited class
$invClass      = new Inventory();
$deviceClass   = new DeviceClass();
$locationClass = new LocationClass();
$pdf           = new PDF('P');

$pdf->SetTitle($invClass->setting_data("inventory_name")." Detailed Report");
$pdf->SetCreator("anoerman");
$pdf->SetAuthor("anoerman");
$pdf->SetSubject($invClass->setting_data("inventory_name")." Detailed Report");
$pdf->AliasNbPages();
$pdf->SetFont('Times','',12);

// Get Datas
$criteria = '';
// If criteria is set
if (isset($_GET['criteria']) && $_GET['criteria']!='') {
    $criteria = $_GET['criteria'];
}

$no = 0;
$datas = $deviceClass->show_device_report("type_id", "$criteria");
foreach ($datas as $data) {
    $no++;

    // if location details enabled
    if ($invClass->setting_data("location_details")=="enable") {
        $locationdetail = $data['place_name'].", ".$data['building_name'].", ".$data['floor_name'].", ".$data['location_name'];
    }
    else {
        $locationdetail = $data['location_name'];
    }

    $pdf->AddPage();
    $pdf->Cell(40, 10, "", 0, 0);
    $pdf->Cell(150, 70, $pdf->Image($data['device_photo'],20,33,0, 60), 0, 1);
    $pdf->Cell(40, 8, "ID", 0, 0);
    $pdf->Cell(5, 8, " : ", 0, 0);
    $pdf->Cell(100, 8, $data['device_code'], 0, 1);
    $pdf->Cell(40, 8, "Produk Kategori", 0, 0);
    $pdf->Cell(5, 8, " : ", 0, 0);
    $pdf->Cell(100, 8, $data['type_name'], 0, 1);
    $pdf->Cell(40, 8, "Nama", 0, 0);
    $pdf->Cell(5, 8, " : ", 0, 0);
    $pdf->Cell(100, 8, $data['device_brand'], 0, 1);
    $pdf->Cell(40, 8, "M3 Full", 0, 0);
    $pdf->Cell(5, 8, " : ", 0, 0);
    $pdf->Cell(100, 8, $data['device_model'], 0, 1);
    $pdf->Cell(40, 8, "Kode", 0, 0);
    $pdf->Cell(5, 8, " : ", 0, 0);
    $pdf->Cell(100, 8, $data['device_serial'], 0, 1);
    $pdf->Cell(40, 8, "Ukuran", 0, 0);
    $pdf->Cell(5, 8, " : ", 0, 0);
    $pdf->Cell(100, 8, $data['device_color'], 0, 1);
    $pdf->Cell(40, 8, "M2", 0, 0);
    $pdf->Cell(5, 8, " : ", 0, 0);
    $pdf->Cell(100, 8, $data['device_color'], 0, 1);
	$pdf->Cell(40, 8, "M2 X 2", 0, 0);
    $pdf->Cell(5, 8, " : ", 0, 0);
    $pdf->Cell(100, 8, $data['mx2'], 0, 1);
	$pdf->Cell(40, 8, "Keterangan", 0, 0);
    $pdf->Cell(5, 8, " : ", 0, 0);
    $pdf->Cell(100, 8, $data['kg'], 0, 1);
	$pdf->Cell(40, 8, "M3 PROD", 0, 0);
    $pdf->Cell(5, 8, " : ", 0, 0);
    $pdf->Cell(100, 8, $data['mprod'], 0, 1);
    $pdf->Cell(40, 8, "Harga", 0, 0);
    $pdf->Cell(5, 8, " : ", 0, 0);
    $pdf->Cell(0, 8, strip_tags($data['device_description']));
}

$pdf->Output();
?>