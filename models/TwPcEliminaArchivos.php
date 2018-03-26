<?php

namespace app\models;
use Yii;
use yii\db\ActiveRecord;
use yii\db\Command;
use PDO;
use yii\base\Model;

class TwPcEliminaArchivos extends Model{	
	
    public function EliminaArchivo(){
		
		$c1 = Yii::$app->session['cedula'];
    	//c1: cedula de quien genera o carg un archivo
    	//c2: nombre de salida
    	//
    	// TNS DE LA BASE DE DATOS
    	$db = Yii::$app->params['orcl'];		
		$usr = Yii::$app->params['usr'];		
		$psw = Yii::$app->params['psw'];	
		//conexion con la base de datos
		$conexion = oci_connect($usr, $psw, $db);
		
		//procedimiento a ejecutar
		$stid = oci_parse($conexion, 'BEGIN TW_PC_ELIMINA_ARCHIVOS(:c1,:c2); END;');

		//SE DECLARAN LOS CURSOR 
		$c2 = oci_new_cursor($conexion);	
		//
		oci_bind_by_name($stid, ':c1', $c1, 18);
		oci_bind_by_name($stid, ':c2', $c2, -1, OCI_B_CURSOR);
		//
		oci_execute($stid);
		
	    oci_execute($c2, OCI_DEFAULT);
		
		//extrae cada fila de cada cursor de una variable 
	    oci_fetch_all($c2, $cursor1, null, null, OCI_FETCHSTATEMENT_BY_ROW);
		
		//SE RETORNA LAS VARIABLES QUE CONTIENE LA INFROMACION DE LOS CURSORES
		return ($cursor1);

	}	
}