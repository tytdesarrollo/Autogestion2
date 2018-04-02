<?php

//var_dump ($ano);

//die;

$GLOBALS['datos'] = $datos[0];
//$GLOBALS['tipo'] = $tiprend;

//var_dump($tiprend)or die;

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
		//$img_file = K_PATH_IMAGES.'certificado2014.jpg';
		
		$img_file =$GLOBALS['datos'];
		
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
$pdf->SetSubject('Certificado');
$pdf->SetKeywords('Certificado,Certificado de ingresos, PDF, ingresos, Retención');

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

// ---------------------------------------------------------

// set font
$pdf->SetFont('Helvetica', '', 9);

// add a page
$pdf->AddPage();

$pdf->SetXY($datos[2], $datos[3]); //NUM_FOR_4
$html = '<span>'.$datos[1].'</span>';
$pdf->writeHTML($html, true, false, true, false, '');

$pdf->SetXY($datos[5], $datos[6]); //NIT_5
$html = '<span>'.$datos[4].'</span>';
$pdf->writeHTML($html, true, false, true, false, '');

$pdf->SetXY($datos[8], $datos[9]); //DV_6
$html = '<span>'.$datos[7].'</span>';
$pdf->writeHTML($html, true, false, true, false, '');

$pdf->SetXY($datos[11], $datos[12]); //DV_6X
$html = '<span>'.$datos[10].'</span>';
$pdf->writeHTML($html, true, false, true, false, '');

$pdf->SetXY($datos[14], $datos[15]); //TIPO_24
$html = '<span>'.$datos[13].'</span>';
$pdf->writeHTML($html, true, false, true, false, '');

$pdf->SetXY($datos[17], $datos[18]); //CEDULA_25
$html = '<span>'.$datos[16].'</span>';
$pdf->writeHTML($html, true, false, true, false, '');

$pdf->SetXY($datos[20], $datos[21]); //PRIMER_APE_26
$html = '<span>'.$datos[19].'</span>';
$pdf->writeHTML($html, true, false, true, false, '');

$pdf->SetXY($datos[23], $datos[24]); //SEG_APE_27
$html = '<span>'.$datos[22].'</span>';
$pdf->writeHTML($html, true, false, true, false, '');

$pdf->SetXY($datos[26], $datos[27]); //PRIMER_NOM_28
$html = '<span>'.$datos[25].'</span>';
$pdf->writeHTML($html, true, false, true, false, '');

$pdf->SetXY($datos[29], $datos[30]); //SEG_NOM_29
$html = '<span>'.$datos[28].'</span>';
$pdf->writeHTML($html, true, false, true, false, '');

$pdf->SetXY($datos[32], $datos[33]); //AÑO_F_INI_30
$html = '<span>'.$datos[31].'</span>';
$pdf->writeHTML($html, true, false, true, false, '');

$pdf->SetXY($datos[35], $datos[36]); //MES_F_INI_30
$html = '<span>'.$datos[34].'</span>';
$pdf->writeHTML($html, true, false, true, false, '');

$pdf->SetXY($datos[38], $datos[39]); //DIA_F_INI_30
$html = '<span>'.$datos[37].'</span>';
$pdf->writeHTML($html, true, false, true, false, '');

$pdf->SetXY($datos[41], $datos[42]); //AÑO_F_FIN_31
$html = '<span>'.$datos[40].'</span>';
$pdf->writeHTML($html, true, false, true, false, '');

$pdf->SetXY($datos[44], $datos[45]); //MES_F_FIN_31
$html = '<span>'.$datos[43].'</span>';
$pdf->writeHTML($html, true, false, true, false, '');

$pdf->SetXY($datos[47], $datos[48]); //DIA_F_FIN_31
$html = '<span>'.$datos[46].'</span>';
$pdf->writeHTML($html, true, false, true, false, '');

$pdf->SetXY($datos[50], $datos[51]); //AÑO_F_EXP_32
$html = '<span>'.$datos[49].'</span>';
$pdf->writeHTML($html, true, false, true, false, '');

$pdf->SetXY($datos[53], $datos[54]); //MES_F_EXP_32X
$html = '<span>'.$datos[52].'</span>';
$pdf->writeHTML($html, true, false, true, false, '');

$pdf->SetXY($datos[56], $datos[57]); //DIA_F_EXP_32X
$html = '<span>'.$datos[55].'</span>';
$pdf->writeHTML($html, true, false, true, false, '');

$pdf->SetXY($datos[59], $datos[60]); //LUGAR_EXPEDICION_33
$html = '<span>'.$datos[58].'</span>';
$pdf->writeHTML($html, true, false, true, false, '');

$pdf->SetXY($datos[62], $datos[63]); //COD_DEP_34X
$html = '<span>'.$datos[61].'</span>';
$pdf->writeHTML($html, true, false, true, false, '');

$pdf->SetXY($datos[65], $datos[66]); //COD_CIU_MUNI_35
$html = '<span>'.$datos[64].'</span>';
$pdf->writeHTML($html, true, false, true, false, '');

$pdf->SetXY($datos[68], $datos[69]); //NUM_AGENCI_36
$html = '<span>'.$datos[67].'</span>';
$pdf->writeHTML($html, true, false, true, false, '');

$pdf->SetFont('Helvetica', '', 9);

$pdf->SetY($datos[71]); //SALARIOS_37
$html = '<span style="text-align:right;">'.$datos[70].'</span>';
$pdf->writeHTML($html, true, false, true, false, '');

$pdf->SetY($datos[73]); //CESANTIAS_38
$html = '<span style="text-align:right;">'.$datos[72].'</span>';
$pdf->writeHTML($html, true, false, true, false, '');

$pdf->SetY($datos[75]); //GASTOSREPRE_39
$html = '<span style="text-align:right;">'.$datos[74].'</span>';
$pdf->writeHTML($html, true, false, true, false, '');

$pdf->SetY($datos[77]); //PENSIONES_40
$html = '<span style="text-align:right;">'.$datos[76].'</span>';
$pdf->writeHTML($html, true, false, true, false, '');

$pdf->SetY($datos[79]);//OTROS_ING_41
$html = '<span style="text-align:right;">'.$datos[78].'</span>';
$pdf->writeHTML($html, true, false, true, false, '');

$pdf->SetY($datos[81]);//TOTAL_ING_42
$html = '<span style="text-align:right;">'.$datos[80].'</span>';
$pdf->writeHTML($html, true, false, true, false, '');

$pdf->SetY($datos[83]);//APOR_SALUD_43
$html = '<span style="text-align:right;">'.$datos[82].'</span>';
$pdf->writeHTML($html, true, false, true, false, '');

$pdf->SetY($datos[85]);//PENSION_SOLIDARIDAD_44
$html = '<span style="text-align:right;">'.$datos[84].'</span>';
$pdf->writeHTML($html, true, false, true, false, '');

$pdf->SetY($datos[87]);//VOLUNTARIAS_45
$html = '<span style="text-align:right;">'.$datos[86].'</span>';
$pdf->writeHTML($html, true, false, true, false, '');

$pdf->SetY($datos[89]);//RETENCION_46
$html = '<span style="text-align:right;">'.$datos[88].'</span>';
$pdf->writeHTML($html, true, false, true, false, '');

$pdf->SetFont('Helvetica', '', 10);

$pdf->SetXY($datos[91], $datos[92]);//NOM_PAGADOR
$html = '<span>'.$datos[90].'</span>';
$pdf->writeHTML($html, true, false, true, false, '');

$pdf->SetXY($datos[94], $datos[95]);//NOM_RET
$html = '<span>'.$datos[93].'</span>';
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