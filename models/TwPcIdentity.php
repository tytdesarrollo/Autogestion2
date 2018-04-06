<?php

namespace app\models;
use Yii;
use yii\db\ActiveRecord;
use yii\db\Command;
use PDO;
use yii\base\Model;

class TwPcIdentity extends Model{	
	
    public function procedimiento()
    {

		$ID_LOGIN = Yii::$app->session['usuario'];
		$IN_PASS = Yii::$app->session['clave'];
		$OPERACION = Yii::$app->session['operacion'];
		$KEY_ACT = Yii::$app->session['tokenreset'];
	//Strings
		$EMPLOYEE_ID;		
		$OUTPUT;	
		$BLOQUEB;	
		$MESSAGE;	
		
	// OPERACION L CONSULTA
	// OPERACION C INSERT
	// OPERACION U UPDATE olvidaste contraseña
	// OPERACION T VALIDA TOKEN
	// OPERACION F CREA PASS POR PRIMERA VEZ
  
	// TNS DE LA BASE DE DATOS
    	$db = Yii::$app->params['orcl'];		
		$usr = Yii::$app->params['usr'];		
		$psw = Yii::$app->params['psw'];	
		//conexion con la base de datos
		$conexion = oci_connect($usr, $psw, $db);
  
  //LOS BEGIN DEL PROCEDIMIENTO ALMACENADO NO DEBEN CONTENER ESPACIOS ENTRE VARIABLES :, TENERLOS GENERA UN ERROR AL MOMENTO DE ENVIAR PETICIONES AL SERVIDOR
		
		$stid = oci_parse($conexion, "BEGIN TW_PC_IDENTITY(:ID_LOGIN,:IN_PASS,:OPERACION,:KEY_ACT,:EMPLOYEE_ID,:OUTPUT,:MESSAGE); END;");

		oci_bind_by_name($stid, ':ID_LOGIN', $ID_LOGIN, 100);
		oci_bind_by_name($stid, ':IN_PASS', $IN_PASS, 100);
		oci_bind_by_name($stid, ':OPERACION', $OPERACION, 100);
		oci_bind_by_name($stid, ':KEY_ACT', $KEY_ACT, 100);
		oci_bind_by_name($stid, ':EMPLOYEE_ID', $EMPLOYEE_ID, 200);
		oci_bind_by_name($stid, ':OUTPUT', $OUTPUT, 200);
		oci_bind_by_name($stid, ':MESSAGE', $MESSAGE, 200);
		//
		oci_execute($stid);
		//
		return $twpcidentity = array($EMPLOYEE_ID,$OUTPUT,$MESSAGE);

	}
	
}