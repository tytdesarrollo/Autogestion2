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
		// set bacground image
		$img_file = K_PATH_IMAGES.'certificado2014.jpg';
		$this->Image($img_file, 0, 0, 210, 297, '', '', '', false, 300, '', false, false, 0);
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
$pdf->SetTitle('Certificado de ingresos y Retención');
$pdf->SetSubject('Certificado 2016');
$pdf->SetKeywords('Certificado,Certificado de ingresos, Certificiado 2016, PDF, ingresos, Retención');

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, 7);
$pdf->SetHeaderMargin(0);
$pdf->SetFooterMargin(0);

// remove default footer
$pdf->setPrintFooter(false);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__).'pdf/lang/spa.php')) {
	require_once(dirname(__FILE__).'pdf/lang/spa.php');
	$pdf->setLanguageArray($l);
}

// ---------------------------------------------------------

// set font
$pdf->SetFont('Helvetica', '', 9);

// add a page
$pdf->AddPage();

$pdf->SetXY(120, 27); //NUM_FOR_4
$html = '<span>44836</span>';
$pdf->writeHTML($html, true, false, true, false, '');

$pdf->SetXY(48, 36); //NIT_5
$html = '<span>830122566</span>';
$pdf->writeHTML($html, true, false, true, false, '');

$pdf->SetXY(66, 36); //DV_6
$html = '<span>1</span>';
$pdf->writeHTML($html, true, false, true, false, '');

$pdf->SetXY(15, 45); //DV_6X
$html = '<span>COLOMBIA TELECOMUNICACIONES S.A. ESP</span>';
$pdf->writeHTML($html, true, false, true, false, '');

$pdf->SetXY(20, 55); //TIPO_24
$html = '<span>13</span>';
$pdf->writeHTML($html, true, false, true, false, '');

$pdf->SetXY(33, 53); //CEDULA_25
$html = '<span>94493860</span>';
$pdf->writeHTML($html, true, false, true, false, '');

$pdf->SetXY(84, 54); //PRIMER_APE_26
$html = '<span>WALLES</span>';
$pdf->writeHTML($html, true, false, true, false, '');

$pdf->SetXY(114, 54); //SEG_APE_27
$html = '<span>VALENCIA</span>';
$pdf->writeHTML($html, true, false, true, false, '');

$pdf->SetXY(146, 54); //PRIMER_NOM_28
$html = '<span>LEONARDO</span>';
$pdf->writeHTML($html, true, false, true, false, '');

$pdf->SetXY(176, 54); //SEG_NOM_29
$html = '<span>JOSE</span>';
$pdf->writeHTML($html, true, false, true, false, '');

$pdf->SetXY(20, 63); //AÑO_F_INI_30
$html = '<span>2015</span>';
$pdf->writeHTML($html, true, false, true, false, '');

$pdf->SetXY(32, 63); //MES_F_INI_30
$html = '<span>01</span>';
$pdf->writeHTML($html, true, false, true, false, '');

$pdf->SetXY(39, 63); //DIA_F_INI_30
$html = '<span>01</span>';
$pdf->writeHTML($html, true, false, true, false, '');

$pdf->SetXY(57, 63); //AÑO_F_FIN_31
$html = '<span>2015</span>';
$pdf->writeHTML($html, true, false, true, false, '');

$pdf->SetXY(69, 63); //MES_F_FIN_31
$html = '<span>12</span>';
$pdf->writeHTML($html, true, false, true, false, '');

$pdf->SetXY(77, 63); //DIA_F_FIN_31
$html = '<span>31</span>';
$pdf->writeHTML($html, true, false, true, false, '');

$pdf->SetXY(88, 63); //AÑO_F_EXP_32
$html = '<span>2016</span>';
$pdf->writeHTML($html, true, false, true, false, '');

$pdf->SetXY(100, 63); //MES_F_EXP_32X
$html = '<span>03</span>';
$pdf->writeHTML($html, true, false, true, false, '');

$pdf->SetXY(108, 63); //DIA_F_EXP_32X
$html = '<span>08</span>';
$pdf->writeHTML($html, true, false, true, false, '');

$pdf->SetXY(120, 63); //LUGAR_EXPEDICION_33
$html = '<span>BOGOTA D.C.</span>';
$pdf->writeHTML($html, true, false, true, false, '');

$pdf->SetXY(181, 63); //COD_DEP_34X
$html = '<span>11</span>';
$pdf->writeHTML($html, true, false, true, false, '');

$pdf->SetXY(190, 63); //COD_CIU_MUNI_35
$html = '<span>0 0 1</span>';
$pdf->writeHTML($html, true, false, true, false, '');

$pdf->SetXY(153, 68); //NUM_AGENCI_36
$html = '<span>1</span>';
$pdf->writeHTML($html, true, false, true, false, '');

$pdf->SetFont('Helvetica', '', 9);

$pdf->SetY(77); //SALARIOS_37
$html = '<span style="text-align:right;">65.614.000</span>';
$pdf->writeHTML($html, true, false, true, false, '');

$pdf->SetY(81); //CESANTIAS_38
$html = '<span style="text-align:right;">54.000</span>';
$pdf->writeHTML($html, true, false, true, false, '');

$pdf->SetY(85); //GASTOSREPRE_39
$html = '<span style="text-align:right;">0</span>';
$pdf->writeHTML($html, true, false, true, false, '');

$pdf->SetY(89); //PENSIONES_40
$html = '<span style="text-align:right;">0</span>';
$pdf->writeHTML($html, true, false, true, false, '');

$pdf->SetY(94);//OTROS_ING_41
$html = '<span style="text-align:right;">7.537.000</span>';
$pdf->writeHTML($html, true, false, true, false, '');

$pdf->SetY(98);//TOTAL_ING_42
$html = '<span style="text-align:right;">73.205.000</span>';
$pdf->writeHTML($html, true, false, true, false, '');

$pdf->SetY(108);//APOR_SALUD_43
$html = '<span style="text-align:right;">2.625.000</span>';
$pdf->writeHTML($html, true, false, true, false, '');

$pdf->SetY(112);//PENSION_SOLIDARIDAD_44
$html = '<span style="text-align:right;">3.281.000</span>';
$pdf->writeHTML($html, true, false, true, false, '');

$pdf->SetY(116);//VOLUNTARIAS_45
$html = '<span style="text-align:right;">4.450.000</span>';
$pdf->writeHTML($html, true, false, true, false, '');

$pdf->SetY(121);//RETENCION_46
$html = '<span style="text-align:right;">2.006.000</span>';
$pdf->writeHTML($html, true, false, true, false, '');

$pdf->SetFont('Helvetica', '', 10);

$pdf->SetXY(20, 130);//NOM_PAGADOR
$html = '<span>SE OMITE LA FIRMA DEL CERTIFICADO DE ACUERDO AL ART.10 DEL DECRETO 836 DE 1991</span>';
$pdf->writeHTML($html, true, false, true, false, '');

$pdf->SetXY(20, 135);//NOM_RET
$html = '<span>LEONARDO WALLES VALENCIA</span>';
$pdf->writeHTML($html, true, false, true, false, '');

// ---------------------------------------------------------

//Close and output PDF document
$pdf->Output('CertificadoIR.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+



?>
