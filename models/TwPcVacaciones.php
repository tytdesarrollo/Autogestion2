<?php

namespace app\models;
use Yii;
use yii\db\ActiveRecord;
use yii\db\Command;
use PDO;
use yii\base\Model;

class TwPcVacaciones extends Model{

	public function Vacaciones(){
		$db = Yii::$app->params['orcl'];		
		$usr = Yii::$app->params['usr'];		
		$psw = Yii::$app->params['psw'];		

		$CONEXION = oci_connect($usr, $psw, $db);
		
		//Entrada
		$CODIGO_EPL = Yii::$app->session['cedula'];
			
		//cursores
		$BLOQUE1;
		$BLOQUE2;
		//Strings
		$CODIGO_EPL;		
		$OUTPUT_B1;	
		$OUTPUT_B2;	
		$OUT_DIAS_PEND;		

		//LLAMA AL PROCEDIMIENTO					
		$stid = oci_parse($CONEXION, 'BEGIN TW_PC_VACACIONES(:IN_CODIGO_EPL,:BLOQUE1,:OUTPUT_B1,:BLOQUE2,:OUTPUT_B2,:OUT_DIAS_PEND);END;');
		//SE DECLARAN LOS CURSOR 
		$BLOQUE1 = oci_new_cursor($CONEXION);	
		$BLOQUE2 = oci_new_cursor($CONEXION);	
		//SE PASAN COMO PARAMETRO LOS CURSOR 

		oci_bind_by_name($stid, ':BLOQUE1', $BLOQUE1, -1, OCI_B_CURSOR);
		oci_bind_by_name($stid, ':BLOQUE2', $BLOQUE2, -1, OCI_B_CURSOR);
		oci_bind_by_name($stid, ':IN_CODIGO_EPL', $CODIGO_EPL, 12);
		oci_bind_by_name($stid, ':OUTPUT_B1', $OUTPUT_B1,200);
		oci_bind_by_name($stid, ':OUTPUT_B2', $OUTPUT_B2,200);
		oci_bind_by_name($stid, ':OUT_DIAS_PEND', $OUT_DIAS_PEND,10);
		
	    //SE EJECUTA  LA SENTENCIA SQL
	    oci_execute($stid);
	    oci_execute($BLOQUE1, OCI_DEFAULT);
	    oci_execute($BLOQUE2, OCI_DEFAULT);

	    //extrae cada fila de cada cursor de una variable 
	    oci_fetch_all($BLOQUE1, $cursor1, null, null, OCI_FETCHSTATEMENT_BY_ROW);
	    oci_fetch_all($BLOQUE2, $cursor2, null, null, OCI_FETCHSTATEMENT_BY_ROW);

	    //SE RETORNA LAS VARIABLES QUE CONTIENE LA INFROMACION DE LOS CURSORES
		return array ($cursor1, $cursor2, $OUTPUT_B1, $OUTPUT_B2, $OUT_DIAS_PEND);
	}
}