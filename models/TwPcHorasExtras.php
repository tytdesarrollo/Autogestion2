<?php

namespace app\models;
use Yii;
use yii\db\ActiveRecord;
use yii\db\Command;
use PDO;
use yii\base\Model;

class TwPcHorasExtras extends Model{

	public function HorasExtrasVal(){
		$db = Yii::$app->params['orcl'];		
		$usr = Yii::$app->params['usr'];		
		$psw = Yii::$app->params['psw'];		

		$CONEXION = oci_connect($usr, $psw, $db);
		
		//Entrada
		$CODIGO_EPL = Yii::$app->session['cedula'];
		
		$IN_HORAS = Yii::$app->session['cedulahoext'];
		$IN_FECHA = Yii::$app->session['fechahoext'];
		$IN_CONCEPTO = Yii::$app->session['conceptohoext'];
		
		//Salida
		
		//cursores
		$BLOQUE1;
		//Strings
		$CODIGO_EPL;
		$IN_HORAS;
		$IN_FECHA;
		$IN_CONCEPTO;
		$MESSAGE;	
		$OUTPUT;		

		//LLAMA AL PROCEDIMIENTO					
		$stid = oci_parse($CONEXION, 'BEGIN TW_PC_HORAS_EXTRAS(:IN_CODIGO_EPL,:IN_HORAS,:IN_FECHA,:IN_CONCEPTO,:BLOQUE1,:MESSAGE,:OUTPUT);END;');
		//SE DECLARAN LOS CURSOR 
		$BLOQUE1 = oci_new_cursor($CONEXION);	
		//SE PASAN COMO PARAMETRO LOS CURSOR 

		oci_bind_by_name($stid, ':IN_CODIGO_EPL', $CODIGO_EPL, 12);
		oci_bind_by_name($stid, ':IN_HORAS', $OUTPUT,200);
		oci_bind_by_name($stid, ':IN_FECHA', $OUTPUT,200);
		oci_bind_by_name($stid, ':IN_CONCEPTO', $OUTPUT,200);
		oci_bind_by_name($stid, ':BLOQUE1', $BLOQUE1, -1, OCI_B_CURSOR);
		oci_bind_by_name($stid, ':MESSAGE', $MESSAGE,200);
		oci_bind_by_name($stid, ':OUTPUT', $OUTPUT,200);

		

	    //SE EJECUTA  LA SENTENCIA SQL
	    oci_execute($stid);
	    oci_execute($BLOQUE1, OCI_DEFAULT);

	    //extrae cada fila de cada cursor de una variable 
	    oci_fetch_all($BLOQUE1, $cursor1, null, null, OCI_FETCHSTATEMENT_BY_ROW);

	    //SE RETORNA LAS VARIABLES QUE CONTIENE LA INFROMACION DE LOS CURSORES
		return array ($cursor1, $MESSAGE, $OUTPUT);
	}
}