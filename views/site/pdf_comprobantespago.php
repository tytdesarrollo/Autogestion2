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
$pdf->SetAuthor('Talentos & Tecnolog�a');
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
        <td colspan="2" bgcolor="#F2F2F2"><div align="center" class="Estilo1">DEDUCCIONES</div></td>
      </tr>
      <tr>
        <td colspan="2"><table width="100%" border="0" class="tabla">
          <tr>
			<td width="10%" align="center">&nbsp;</td>
            <td width="50%" align="center">Concepto</td>
            <td width="20%" align="right">Valor</td>
            <td width="20%" align="right">Cantidad &nbsp;</td>	
          </tr>
		  <tr>
            <td width="10%" align="left">';			
								foreach($bloque3_0 as $BLOQUE3_ARR0){
								$html.='&nbsp;&nbsp;'.$BLOQUE3_ARR0.'<br>';
								};			
			$html.='</td>
            <td width="50%" align="left">';
								foreach($bloque3_1 as $BLOQUE3_ARR1){
								$html.=''.$BLOQUE3_ARR1.'<br>';
								}
			$html.='</td>
            <td width="20%" align="right">';
								foreach($bloque3_2 as $BLOQUE3_ARR2){
								$html.=''.$BLOQUE3_ARR2.'<br>';
								}
			$html.='</td>
            <td width="20%" align="right">';
								foreach($bloque3_3 as $BLOQUE3_ARR3){
								$html.=''.$BLOQUE3_ARR3.'&nbsp;&nbsp;<br>';
								}
			$html.='</td>
          </tr>
		  </table></td>
        <td colspan="2"><table width="100%" border="0" class="tabla">
          <tr>
			<td width="10%" align="center">&nbsp;</td>
            <td width="50%" align="center">Concepto</td>
            <td width="20%" align="right">Valor</td>
			<td width="20%" align="right">Saldo &nbsp;</td>
          </tr>
		  <tr>
            <td width="10%" align="left">';			
								foreach($bloque5_0 as $BLOQUE5_ARR0){
								$html.='&nbsp;&nbsp;'.$BLOQUE5_ARR0.'<br>';
								};			
			$html.='</td>
            <td width="50%" align="left">';
								foreach($bloque5_1 as $BLOQUE5_ARR1){
								$html.=''.$BLOQUE5_ARR1.'<br>';
								}
			$html.='</td>
            <td width="20%" align="right">';
								foreach($bloque5_2 as $BLOQUE5_ARR2){
								$html.=''.$BLOQUE5_ARR2.'<br>';
								}
			$html.='</td>
            <td width="20%" align="right">';
								foreach($bloque5_3 as $BLOQUE5_ARR3){
								$html.=''.$BLOQUE5_ARR3.'&nbsp;&nbsp;<br>';
								}
			$html.='</td>
          </tr>
		   </table></td>
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

//Close and output PDF document
$pdf->Output('ComprobanteDePago.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+

?>