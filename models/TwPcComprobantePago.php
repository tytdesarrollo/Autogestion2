<?php

namespace app\models;
use Yii;
use yii\db\ActiveRecord;
use yii\db\Command;
use PDO;
use yii\base\Model;

class TwPcComprobantePago extends Model{

	public function ComprobantePago(){
		$db = Yii::$app->params['orcl'];		
		$usr = Yii::$app->params['usr'];		
		$psw = Yii::$app->params['psw'];		

		$CONEXION = oci_connect($usr, $psw, $db);
		
		//Entrada
		$CEDULAA = Yii::$app->session['cedula'];
		$ANO_FORMU = Yii::$app->session['ano_com'];
		$PERIODO_FORMU = Yii::$app->session['per_com'];
		
		//Salida
		
		//cursores
		$ANIO;
		$PERIODOS;
		$BLOQUE3;
		$BLOQUE5;
		//Strings
		$OUTPUT;		
		$MESSAGE;	
		$BLOQUE1;	
		$BLOQUE2;	
		$BLOQUE4;	
		$BLOQUE6;	

		//LLAMA AL PROCEDIMIENTO					
		$stid = oci_parse($CONEXION, 'BEGIN TW_PC_COMPROBANTE_PAGO(:CEDULAA,:ANO_FORMU,:PERIODO_FORMU,:OUTPUT,:MESSAGE,:ANIO,:PERIODOS,:BLOQUE1,:BLOQUE2,:BLOQUE3,:BLOQUE4,:BLOQUE5,:BLOQUE6);END;');
		//SE DECLARAN LOS CURSOR 
		$ANIO = oci_new_cursor($CONEXION);
		$PERIODOS = oci_new_cursor($CONEXION);		
		$BLOQUE3 = oci_new_cursor($CONEXION);		
		$BLOQUE5 = oci_new_cursor($CONEXION);		
		//SE PASAN COMO PARAMETRO LOS CURSOR 
		oci_bind_by_name($stid, ':CEDULAA', $CEDULAA, 12);
		oci_bind_by_name($stid, ':ANO_FORMU', $ANO_FORMU, 50);
		oci_bind_by_name($stid, ':PERIODO_FORMU', $PERIODO_FORMU,200);
		oci_bind_by_name($stid, ':ANIO', $ANIO, -1, OCI_B_CURSOR);
		oci_bind_by_name($stid, ':PERIODOS', $PERIODOS, -1, OCI_B_CURSOR);
		oci_bind_by_name($stid, ':BLOQUE3', $BLOQUE3, -1, OCI_B_CURSOR);
		oci_bind_by_name($stid, ':BLOQUE5', $BLOQUE5, -1, OCI_B_CURSOR);
		oci_bind_by_name($stid, ':OUTPUT', $OUTPUT,200);
		oci_bind_by_name($stid, ':MESSAGE', $MESSAGE,200);
		oci_bind_by_name($stid, ':BLOQUE1', $BLOQUE1,200);
		oci_bind_by_name($stid, ':BLOQUE2', $BLOQUE2,200);
		oci_bind_by_name($stid, ':BLOQUE4', $BLOQUE4,200);
		oci_bind_by_name($stid, ':BLOQUE6', $BLOQUE6,200);
		

	    //SE EJECUTA  LA SENTENCIA SQL
	    oci_execute($stid);
	    oci_execute($ANIO, OCI_DEFAULT);
	    oci_execute($PERIODOS, OCI_DEFAULT);
	    oci_execute($BLOQUE3, OCI_DEFAULT);
	    oci_execute($BLOQUE5, OCI_DEFAULT);

	    //extrae cada fila de cada cursor de una variable 
	    oci_fetch_all($ANIO, $cursor1, null, null, OCI_FETCHSTATEMENT_BY_ROW);
	    oci_fetch_all($PERIODOS, $cursor2, null, null, OCI_FETCHSTATEMENT_BY_ROW);
	    oci_fetch_all($BLOQUE3, $cursor3, null, null, OCI_FETCHSTATEMENT_BY_ROW);
	    oci_fetch_all($BLOQUE5, $cursor4, null, null, OCI_FETCHSTATEMENT_BY_ROW);

	    //SE RETORNA LAS VARIABLES QUE CONTIENE LA INFROMACION DE LOS CURSORES
		return array ($cursor1, $cursor2, $cursor3, $cursor4, $BLOQUE1, $BLOQUE2, $BLOQUE4, $BLOQUE6, $MESSAGE, $OUTPUT);
	}
}