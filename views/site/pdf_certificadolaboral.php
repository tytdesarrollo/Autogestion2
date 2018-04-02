<?php
// Extend the TCPDF class to create custom Header and Footer
class MYPDF extends TCPDF {
	//Page header
	
	public function Header() {
	
		// get the current page break margin
		$bMargin = $this->getBreakMargin();
		// get current auto-page-break mode
		$auto_page_break = $this->AutoPageBreak;
		// disable auto-page-break
		$this->SetAutoPageBreak(false, 0);
		// restore auto-page-break status
		$this->SetAutoPageBreak($auto_page_break, $bMargin);
		// set the starting point for the page content
		$this->setPageMark();
	}
}

// create new PDF document
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Talentos & Tecnología');
$pdf->SetTitle('Certificado Laboral');
$pdf->SetSubject('Certificado');
$pdf->SetKeywords('Certificado,Certificado laboral, PDF');

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(20, PDF_MARGIN_TOP, 20);
$pdf->SetHeaderMargin(0);
$pdf->SetFooterMargin(0);

// remove default footer
$pdf->setPrintFooter(false);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// ---------------------------------------------------------

// set font
$pdf->SetFont('Helvetica', '', 7);

// add a page
$pdf->AddPage('P', 'A4');

$html = '<span align="right">'.$encabezado.'</span>';
$pdf->writeHTML($html, true, false, true, false, '');

$pdf->SetFont('Helvetica', '', 11);

$html = '<br/><br/><br/><br/><br/><br/>';
$pdf->writeHTML($html, true, false, true, false, '');

$html = '<span align="center">'.$titulo.'</span>';
$pdf->writeHTML($html, true, false, true, false, '');

$html = '<br/><br/><br/><br/><br/><br/>';
$pdf->writeHTML($html, true, false, true, false, '');

$html = '<span align="justify">'.$cuerpo.'</span>';
$pdf->writeHTML($html, true, false, true, false, '');

$pdf->SetFont('Helvetica', '', 11);

$html = '<br/><br/><br/><br/>';
$pdf->writeHTML($html, true, false, true, false, '');

$pdf->Image('img/firma.jpg', '', '', '', '', '', '', 'T', false, 300, '', false, false, 0, false, false, false);
$html = '<br/><br/><br/><br/>';
$pdf->writeHTML($html, true, false, true, false, '');

$html = '<span>'.$pie.'</span>';
$pdf->writeHTML($html, true, false, true, false, '');

// ---------------------------------------------------------
	if($tiprend=="btnPdf"){
//imprime el reporte
		$pdf->Output($NMBR, 'I');
		
	}else if($tiprend=="envPdf"){
//guarda el reporte		
		$pdf->Output(__DIR__ . '/../reportes/'.$NMBR, 'F');
		
	}
//============================================================+
// END OF FILE
//============================================================+

?>