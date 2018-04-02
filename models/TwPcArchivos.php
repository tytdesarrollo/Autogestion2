<?php

namespace app\models;
use Yii;
use yii\db\ActiveRecord;
use yii\db\Command;
use PDO;
use yii\base\Model;

class TwPcArchivos extends Model{	
	
    public function nombreArchivo($c1,$c2,$c3){
    	//c1: cedula de quien genera o carg un archivo
    	//c2: extension del archivo 
    	//c3: comentario
    	//c4: nombre de salida
    	//
    	// TNS DE LA BASE DE DATOS
    	$db = Yii::$app->params['orcl'];		
		$usr = Yii::$app->params['usr'];		
		$psw = Yii::$app->params['psw'];	
		//conexion con la base de datos
		$conexion = oci_connect($usr, $psw, $db);
		//procedimiento a ejecutar
		$stid = oci_parse($conexion, 'BEGIN TW_PC_NOMBRE_ARCHIVOS(:c1,:c2,:c3,:c4); END;');
		//
		oci_bind_by_name($stid, ':c1', $c1, 12);
		oci_bind_by_name($stid, ':c2', $c2, 10);
		oci_bind_by_name($stid, ':c3', $c3, 500);
		oci_bind_by_name($stid, ':c4', $c4, 200);
		//
		oci_execute($stid);
		//
		return $c4;
	}	
}