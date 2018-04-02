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
$pdf->SetTitle('Comprobante de pago');
$pdf->SetSubject('Comprobante de pago');
$pdf->SetKeywords('Comprobante,Comprobante pago, PDF');
// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(0);
$pdf->SetFooterMargin(0);
// remove default footer
$pdf->setPrintFooter(false);
// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
// ---------------------------------------------------------
// set font //2912
$pdf->SetFont('Helvetica', '', 9);
// add a page
$pdf->AddPage('P', 'A4');
$pdf->SetXY(15, 15);
$pdf->Image('img/empresa.jpg', '', '', 40, '', '', '', 'T', false, 200, '', false, false, 0, false, false, false);
$pdf->writeHTML('', true, false, true, false, true);
$html='<div align="center">
<b>'.$bloque1[0].'</b>
<br>
NIT '.$bloque1[1].'
<br> 
'.$bloque1[2].'
<br>
'.$bloque1[3].'
<br>
'.$bloque1[4].'
</div>';
$pdf->writeHTML($html, true, false, true, false, '');
$pdf->SetFont('helvetica', 'BI', 7);
$html='
<hr/>
<br>
<p>Periodo Liquidado: '.$bloque1[5].'</p>
<br><br><br>
<table  border="1" align="center" bordercolor="#000000"   frame="box" rules="all" class="tabla">
    
    <tr>
    
        <td colspan="4"><div><table width="100%" border="0" align="center">
             <tr bgcolor="#F2F2F2">
              <td style="border:1px solid black;"><div align="center" ><strong>IDENTIFICACI&Oacute;N</strong></div></td>
              <td style="border:1px solid black;"><div align="center" ><strong>APELLIDOS</strong></div></td>
                <td style="border:1px solid black;"><div align="center" ><strong>NOMBRES</strong></div></td>
                <td style="border:1px solid black;"><div align="center" ><strong>'.$bloque2[8].'</strong></div></td>
            </tr>
               <tr>
              <td>'.$bloque2[0].'</td>
              <td>'.$bloque2[1].'</td>
                 <td>'.$bloque2[2].'</td>
                 <td>'.$bloque2[3].'</td>
            </tr>
            <tr bgcolor="#F2F2F2" style="border:1px solid black; ">
              <td bgcolor="#F2F2F2" style="border:1px solid black;"><div align="center" ><strong>CARGO</strong></div></td>
              <td bgcolor="#F2F2F2" style="border:1px solid black;"><div align="center" ><strong>&Aacute;REA</strong></div></td>
              <td style="border:1px solid black;"><div align="center" ><strong>CONTRATO</strong></div></td>
 <td style="border:1px solid black;"><div align="center" ><strong>PORCENTAJE RETENCI&Oacute;N</strong></div></td>
              </tr>
            <tr>
				<td>'.$bloque2[4].'</td>
				<td>'.$bloque2[5].'</td>
                <td>'.$bloque2[6].'</td>
				<td>'.$bloque2[7].'</td>
             </tr>            
          </table>
        </div></td>
      </tr>
      <tr>
        <td colspan="2" bgcolor="#F2F2F2"><div align="center" ><strong>DEVENGOS</strong></div></td>
        <td colspan="2" bgcolor="#F2F2F2"><div align="center" ><strong>DEDUCCIONES</strong></div></td>
      </tr>
      <tr>
        <td colspan="2"><table width="100%" border="0" class="tabla">
          <tr>
			<td width="10%" align="center">&nbsp;</td>
            <td width="50%" align="center">Concepto</td>
            <td width="20%" align="right">Valor</td>
            <td width="20%" align="right">Cantidad &nbsp;</td>	
         </tr><tr><td>&nbsp;</td></tr>';
		 foreach($bloque3_0 as $BLOQUE3_KEY){
								$html.='<tr><td width="10%" align="left">&nbsp;&nbsp;'.$BLOQUE3_KEY['COD_CON1'].'</td><td width="50%" align="left">'.$BLOQUE3_KEY['NOM_CON1'].'</td><td width="20%" align="right">'.$BLOQUE3_KEY['VALOR1'].'</td><td width="20%" align="right">'.$BLOQUE3_KEY['CANT1'].' &nbsp;</td></tr>';
								};
		  $html.='<tr><td>&nbsp;</td></tr></table></td>
        <td colspan="2"><table width="100%" border="0" class="tabla">
          <tr>
			<td width="10%" align="center">&nbsp;</td>
            <td width="50%" align="center">Concepto</td>
            <td width="20%" align="right">Valor</td>
			<td width="20%" align="right">Saldo &nbsp;</td>
         </tr><tr><td>&nbsp;</td></tr>';
		  foreach($bloque5_0 as $BLOQUE5_KEY){
								$html.='<tr><td width="10%" align="left">&nbsp;&nbsp;'.$BLOQUE5_KEY['CODCON2'].'</td><td width="50%" align="left">'.$BLOQUE5_KEY['NOMCON2'].'</td><td width="20%" align="right">'.$BLOQUE5_KEY['VALOR2'].'</td><td width="20%" align="right">'.$BLOQUE5_KEY['SALDO2'].' &nbsp;</td></tr>';
								};
		  
		   $html.='<tr><td>&nbsp;</td></tr></table></td>
      </tr>
      <tr>
        <td bgcolor="#F2F2F2"><div align="center" ><strong>TOTAL DEVENGOS</strong></div></td>
        <td><div align="center" class="tabla">'.$bloque4[0].'</div></td>
        <td  bgcolor="#F2F2F2" ><div align="center"><strong>TOTAL DEDUCCIONES</strong></div></td>
        <td><div align="center" class="tabla">'.$bloque6[0].'</div></td>
      </tr>
      <tr>
        <td  bgcolor="#F2F2F2" ><div align="center"><strong>PAGO</strong></div></td>
        <td><div align="center" class="tabla">'.$bloque4[1].'</div></td>
        <td  bgcolor="#F2F2F2"><div align="center"><strong>NETO A PAGAR</strong></div></td>
        <td><div align="center" class="tabla">'.$bloque6[1].'</div></td>
      </tr>
      <tr>
        <td height="40" colspan="4">&nbsp;</td>
      </tr>
    </table>';
$pdf->writeHTML($html, true, false, false, false,'');

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