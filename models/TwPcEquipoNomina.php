<?php

namespace app\models;
use Yii;
use yii\db\ActiveRecord;
use yii\db\Command;
use PDO;
use yii\base\Model;

class TwPcEquipoNomina extends Model{

	public function EquipoNomina(){
		$db = Yii::$app->params['orcl'];		
		$usr = Yii::$app->params['usr'];		
		$psw = Yii::$app->params['psw'];		

		$CONEXION = oci_connect($usr, $psw, $db);
		
		//Salida
		
		//cursores
		$BLOQUE1;	
		$BLOQUE2;	
		$BLOQUE3;	
		$BLOQUE4;	
		$BLOQUE5;	
		$BLOQUE6;	
		$BLOQUE7;	
	
		//LLAMA AL PROCEDIMIENTO						
		$stid = oci_parse($CONEXION, 'BEGIN TW_PC_EQUIPO_NOMINA(:BLOQUE1, :BLOQUE2, :BLOQUE3, :BLOQUE4, :BLOQUE5, :BLOQUE6, :BLOQUE7);END;');
		
		//SE DECLARAN LOS CURSOR 
		$BLOQUE1 = oci_new_cursor($CONEXION);
		$BLOQUE2 = oci_new_cursor($CONEXION);
		$BLOQUE3 = oci_new_cursor($CONEXION);
		$BLOQUE4 = oci_new_cursor($CONEXION);
		$BLOQUE5 = oci_new_cursor($CONEXION);
		$BLOQUE6 = oci_new_cursor($CONEXION);
		$BLOQUE7 = oci_new_cursor($CONEXION);
		
		//SE PASAN COMO PARAMETRO LOS CURSOR 
		oci_bind_by_name($stid, ':BLOQUE1', $BLOQUE1, -1, OCI_B_CURSOR);
		oci_bind_by_name($stid, ':BLOQUE2', $BLOQUE2, -1, OCI_B_CURSOR);
		oci_bind_by_name($stid, ':BLOQUE3', $BLOQUE3, -1, OCI_B_CURSOR);
		oci_bind_by_name($stid, ':BLOQUE4', $BLOQUE4, -1, OCI_B_CURSOR);
		oci_bind_by_name($stid, ':BLOQUE5', $BLOQUE5, -1, OCI_B_CURSOR);
		oci_bind_by_name($stid, ':BLOQUE6', $BLOQUE6, -1, OCI_B_CURSOR);
		oci_bind_by_name($stid, ':BLOQUE7', $BLOQUE7, -1, OCI_B_CURSOR);
		

	    //SE EJECUTA  LA SENTENCIA SQL
	    oci_execute($stid);
	    oci_execute($BLOQUE1, OCI_DEFAULT);
	    oci_execute($BLOQUE2, OCI_DEFAULT);
	    oci_execute($BLOQUE3, OCI_DEFAULT);
	    oci_execute($BLOQUE4, OCI_DEFAULT);
	    oci_execute($BLOQUE5, OCI_DEFAULT);
	    oci_execute($BLOQUE6, OCI_DEFAULT);
	    oci_execute($BLOQUE7, OCI_DEFAULT);

	    //extrae cada fila de cada cursor de una variable 
	    oci_fetch_all($BLOQUE1, $cursor1, null, null, OCI_FETCHSTATEMENT_BY_ROW);
	    oci_fetch_all($BLOQUE2, $cursor2, null, null, OCI_FETCHSTATEMENT_BY_ROW);
	    oci_fetch_all($BLOQUE3, $cursor3, null, null, OCI_FETCHSTATEMENT_BY_ROW);
	    oci_fetch_all($BLOQUE4, $cursor4, null, null, OCI_FETCHSTATEMENT_BY_ROW);
	    oci_fetch_all($BLOQUE5, $cursor5, null, null, OCI_FETCHSTATEMENT_BY_ROW);
	    oci_fetch_all($BLOQUE6, $cursor6, null, null, OCI_FETCHSTATEMENT_BY_ROW);
	    oci_fetch_all($BLOQUE7, $cursor7, null, null, OCI_FETCHSTATEMENT_BY_ROW);

	    //SE RETORNA LAS VARIABLES QUE CONTIENE LA INFROMACION DE LOS CURSORES
		return array ($cursor1,$cursor2,$cursor3,$cursor4,$cursor5,$cursor6,$cursor7);
	}
}