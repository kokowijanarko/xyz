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
        $report_name = ucwords(str_replace("_", " ", $_GET['name']));
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
        $this->Cell(120);
        $this->Cell(30,10,$this->invClass->setting_data("inventory_name"),0,1,'C');

        $this->SetFont('Arial','',12);
        $this->Cell(120);
        $this->Cell(30,5,'Report '.$report_name,0,0,'C');
        // Line break
        $this->Ln(10);

        // Table header
        $this->SetFont('Arial','B',9);
        $this->Cell(12, 10, "No", 1, 0);
		$this->Cell(30, 10, "Nama", 1, 0);
        $this->Cell(15, 10, "Kategori", 1, 0);
        $this->Cell(15, 10, "M3 Full", 1, 0);
        $this->Cell(20, 10, "Kode", 1, 0);
        $this->Cell(35, 10, "Ukuran", 1, 0);

		$this->Cell(15, 10, "M2", 1, 0);
		$this->Cell(15, 10, "M2x2", 1, 0);
		$this->Cell(15, 10, "Suplier", 1, 0);
		$this->Cell(15, 10, "KET", 1, 0);
		$this->Cell(18, 10, "M3PROD", 1, 0);
		//$this->Cell(35, 10, "Foto", 1, 0);
        $this->Cell(46, 10, "Harga", 1, 1);
        //$this->Cell(15, 10, "Status", 1, 1);
		

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
$pdf           = new PDF('L');
$report_name   = ucwords(str_replace("_", " ", $_GET['name']));
$pdf->AliasNbPages();
$pdf->SetTitle($invClass->setting_data("inventory_name")." Report " . $report_name);
$pdf->SetCreator("anoerman");
$pdf->SetAuthor("anoerman");
$pdf->SetSubject($invClass->setting_data("inventory_name")." Report " . $report_name);
$pdf->AddPage();
$pdf->SetFont('Times','',8);

// Get Datas
$by       = $_GET['by'];
$criteria = '';

// If criteria is set
if (isset($_GET['criteria']) && $_GET['criteria']!='') {
    $criteria = $_GET['criteria'];
}

$no = 0;
$datas = $deviceClass->show_device_report($by, $criteria);
foreach ($datas as $data) {
    $no++;

    // if location details enabled
    if ($invClass->setting_data("location_details")=="enable") {
        $locationdetail = $data['place_name'].", ".$data['building_name'].", ".$data['floor_name'].", ".$data['location_name'];
    }
    else {
        $locationdetail = $data['location_name'];
    }

    $pdf->Cell(12, 10, $no, 1, 0);
    
    $pdf->Cell(30, 10, $data['device_brand'], 1, 0);
	$pdf->Cell(15, 10, $data['type_name'], 1, 0);
    $pdf->Cell(15, 10, $data['device_model'], 1, 0);
    $pdf->Cell(20, 10, $data['device_serial'], 1, 0);
    $pdf->Cell(35, 10, $data['device_color'], 1, 0);
	
	$pdf->Cell(15, 10, $data['m2'], 1, 0);
	$pdf->Cell(15, 10, $data['mx2'], 1, 0);
	$pdf->Cell(15, 10, $data['cek'], 1, 0);
	$pdf->Cell(15, 10, $data['kg'], 1, 0);
	$pdf->Cell(18, 10, $data['mprod'], 1, 0);
	//$pdf->Cell(35, 35, $pdf->Image($data['device_photo'],5,5,0, 5), 0, 1);
	$pdf->MultiCell(46, 10, strip_tags($data['device_description']), 1, 1);
    //$pdf->Cell(35, 10, strip_tags($data['device_description'], 1, 1);
	//$pdf->Cell(15, 10, ucfirst($data['device_status']), 1, 1);
	
    //$pdf->Cell(15, 10, $data['device_kg1']), 1, 1);
}

$pdf->Output();
?>