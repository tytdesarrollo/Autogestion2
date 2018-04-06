<?php

namespace app\models;
use Yii;
use yii\db\ActiveRecord;
use yii\db\Command;
use PDO;
use yii\base\Model;

class TwPcPersonalData extends Model{	
	
    public function procedimiento()
    {
		
	//NOTAS
		//SI EL BLOQUE RETORNA "INACTIVO" ES POR Q EL ROL DEL EMPLEADO NO PUEDE VISUALIZAR ESA INFORMACION
		// 35326177
		// 52513735
	
		$CODIGO_EPL = Yii::$app->session['cedula'];
	//Strings
		  $BLOQUE1;
		  $BLOQUE2;
		  $BLOQUE3;
		  $BLOQUE4;
		  $BLOQUE5;
		  $BLOQUE6;
		  $BLOQUE7;
		  $BLOQUE8;
		  $BLOQUE9;
		  $BLOQUE10;
		  $BLOQUE11;
		  $BLOQUE12;
		  $BLOQUE13;
		  $BLOQUE14;
  
  // TNS DE LA BASE DE DATOS
    	$db = Yii::$app->params['orcl'];		
		$usr = Yii::$app->params['usr'];		
		$psw = Yii::$app->params['psw'];	
		//conexion con la base de datos
		$conexion = oci_connect($usr, $psw, $db);
		//procedimiento a ejecutar
		$stid = oci_parse($conexion, "BEGIN TW_PC_PERSONAL_DATA1(:CODIGO_EPL,:BLOQUE1,:BLOQUE2,:BLOQUE3,:BLOQUE4,:BLOQUE5,:BLOQUE6,:BLOQUE7,:BLOQUE8,:BLOQUE9,:BLOQUE10,:BLOQUE11,:BLOQUE12,:BLOQUE13,:BLOQUE14); END;");

		oci_bind_by_name($stid, ':CODIGO_EPL', $CODIGO_EPL, 100);
		oci_bind_by_name($stid, ':BLOQUE1', $BLOQUE1, 100); //DATOS PRINCIPALES
		oci_bind_by_name($stid, ':BLOQUE2', $BLOQUE2, 1000); //DATOS PERSONALES
		oci_bind_by_name($stid, ':BLOQUE3', $BLOQUE3, 1000); //CUENTA BANCARIA
		oci_bind_by_name($stid, ':BLOQUE4', $BLOQUE4, 1000); //DATOS INFORMATIVOS
		oci_bind_by_name($stid, ':BLOQUE5', $BLOQUE5, 1000); //NOVEDADES
		oci_bind_by_name($stid, ':BLOQUE6', $BLOQUE6, 1000); //AFILIACIONES SEGURIDAD SOCIAL
		oci_bind_by_name($stid, ':BLOQUE7', $BLOQUE7, 1000); //DEDUCIBLES DE RETENCION EN LA FUENTE
		oci_bind_by_name($stid, ':BLOQUE8', $BLOQUE8, 1000); //CERTIFICADOS DE BENEFICIO
		oci_bind_by_name($stid, ':BLOQUE9', $BLOQUE9, 1000); //NOTICIAS
		oci_bind_by_name($stid, ':BLOQUE10', $BLOQUE10, 1000); //WIDGET COMPROBANTES DE PAGO
		oci_bind_by_name($stid, ':BLOQUE11', $BLOQUE11, 1000); //WIDGET VACACIONES
		oci_bind_by_name($stid, ':BLOQUE12', $BLOQUE12, 1000); //WIDGET NOVEDADES
		oci_bind_by_name($stid, ':BLOQUE13', $BLOQUE13, 1000); //WIDGET CERTIFICADO LABORAL
		oci_bind_by_name($stid, ':BLOQUE14', $BLOQUE14, 1000); //WIDGET CERTIFICADO DE I Y R
		
		//
		oci_execute($stid);
		//
		return $twpcpersonaldata = array($BLOQUE1,$BLOQUE2,$BLOQUE3,$BLOQUE4,$BLOQUE5,$BLOQUE6,$BLOQUE7,$BLOQUE8,$BLOQUE9,$BLOQUE10,$BLOQUE11,$BLOQUE12,$BLOQUE13,$BLOQUE14);
	}	
}