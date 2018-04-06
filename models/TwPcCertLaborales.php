<?php

namespace app\models;
use Yii;
use yii\db\ActiveRecord;
use yii\db\Command;
use PDO;
use yii\base\Model;

class TwPcCertLaborales extends Model{	
	
    public function procedimiento()
    {
	
		$CODIGO_EPL = Yii::$app->session['cedula'];
		$TIPO = Yii::$app->session['checklab'];
		$DESTINATARIO = Yii::$app->session['textlab'];
	//Strings
		$BLOQUEA;		
		$BLOQUET;	
		$BLOQUEB;	
		$BLOQUEC;	

		// TNS DE LA BASE DE DATOS
    	$db = Yii::$app->params['orcl'];		
		$usr = Yii::$app->params['usr'];		
		$psw = Yii::$app->params['psw'];	
		//conexion con la base de datos
		$conexion = oci_connect($usr, $psw, $db);
		//procedimiento a ejecutar
		$stid = oci_parse($conexion, "BEGIN TW_PC_CERT_LABORALES1(:CODIGO_EPL,:TIPO,:DESTINATARIO,:BLOQUEA,:BLOQUET,:BLOQUEB,:BLOQUEC); END;");

		oci_bind_by_name($stid, ':CODIGO_EPL', $CODIGO_EPL, 100);
		oci_bind_by_name($stid, ':TIPO', $TIPO, 100);
		oci_bind_by_name($stid, ':DESTINATARIO', $DESTINATARIO, 1000);
		oci_bind_by_name($stid, ':BLOQUEA', $BLOQUEA, 1000);
		oci_bind_by_name($stid, ':BLOQUET', $BLOQUET, 1000);
		oci_bind_by_name($stid, ':BLOQUEB', $BLOQUEB, 1000);
		oci_bind_by_name($stid, ':BLOQUEC', $BLOQUEC, 1000);
		//
		oci_execute($stid);
		//
		return array($BLOQUEA,$BLOQUET,$BLOQUEB,$BLOQUEC);

	}	
}