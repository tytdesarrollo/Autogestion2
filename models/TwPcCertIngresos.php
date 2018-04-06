<?php

namespace app\models;
use Yii;
use yii\db\ActiveRecord;
use yii\db\Command;
use PDO;
use yii\base\Model;

class TwPcCertIngresos extends Model{	

	
    public function procedimiento()
    {
		
		$CODIGO_EPL = Yii::$app->session['cedula'];
		$ANO_FORMU = Yii::$app->session['ano'];
	//Strings
		$BLOQUE1;		
		$BLOQUE2;	
		$OUTPUT;	
		$MESSAGE;	

      	// TNS DE LA BASE DE DATOS
    	$db = Yii::$app->params['orcl'];		
		$usr = Yii::$app->params['usr'];		
		$psw = Yii::$app->params['psw'];	
		//conexion con la base de datos
		$conexion = oci_connect($usr, $psw, $db);
		//procedimiento a ejecutar
		$stid = oci_parse($conexion, "BEGIN TW_PC_CERT_INGRESOS1(:CODIGO_EPL,:ANO_FORMU,:BLOQUE1,:BLOQUE2,:OUTPUT,:MESSAGE); END;");

		oci_bind_by_name($stid, ':CODIGO_EPL', $CODIGO_EPL, 50);
		oci_bind_by_name($stid, ':ANO_FORMU', $ANO_FORMU, 50);
		oci_bind_by_name($stid, ':BLOQUE1', $BLOQUE1, 1000);
		oci_bind_by_name($stid, ':BLOQUE2', $BLOQUE2, 1000);
		oci_bind_by_name($stid, ':OUTPUT', $OUTPUT, 1000);
		oci_bind_by_name($stid, ':MESSAGE', $MESSAGE, 1000);
		//
		oci_execute($stid);
		//
		return $twpccertingresos = array($BLOQUE1,$BLOQUE2);

	}	
}