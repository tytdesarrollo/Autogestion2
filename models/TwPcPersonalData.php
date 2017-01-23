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
		
	$cedula =  Yii::$app->request->get('cedula');
	$rol = '1';

	
  $CODIGO_EPL= $cedula;
  $ROL= $rol;
  $BLOQUE1= '';
  $BLOQUE2= '';
  $BLOQUE3= '';
  $BLOQUE4= '';
  $BLOQUE5= '';
  $BLOQUE6= '';
  $BLOQUE7= '';
  $BLOQUE8= '';
  
		$rows = Yii::$app->telmovil->createCommand("BEGIN TW_PC_PERSONAL_DATA1 (:CODIGO_EPL,:ROL,:BLOQUE1,:BLOQUE2,:BLOQUE3,:BLOQUE4,:BLOQUE5,:BLOQUE6,:BLOQUE7,:BLOQUE8);	END;");

$rows->bindParam(":CODIGO_EPL", $CODIGO_EPL, PDO::PARAM_STR);
$rows->bindParam(":ROL", $ROL, PDO::PARAM_STR);
$rows->bindParam(":BLOQUE1", $BLOQUE1, PDO::PARAM_STR,1000); //DATOS PRINCIPALES
$rows->bindParam(":BLOQUE2", $BLOQUE2, PDO::PARAM_STR,1000); //DATOS PERSONALES
$rows->bindParam(":BLOQUE3", $BLOQUE3, PDO::PARAM_STR,1000); //CUENTA BANCARIA
$rows->bindParam(":BLOQUE4", $BLOQUE4, PDO::PARAM_STR,1000); //DATOS INFORMATIVOS
$rows->bindParam(":BLOQUE5", $BLOQUE5, PDO::PARAM_STR,1000); //NOVEDADES
$rows->bindParam(":BLOQUE6", $BLOQUE6, PDO::PARAM_STR,1000); //AFILIACIONES SEGURIDAD SOCIAL
$rows->bindParam(":BLOQUE7", $BLOQUE7, PDO::PARAM_STR,1000); //DEDUCIBLES DE RETENCION EN LA FUENTE
$rows->bindParam(":BLOQUE8", $BLOQUE8, PDO::PARAM_STR,1000); //CERTIFICADOS DE BENEFICIO

$rows->execute();

return $twpcpersonaldata = array($BLOQUE1,$BLOQUE2,$BLOQUE3,$BLOQUE4,$BLOQUE5,$BLOQUE6,$BLOQUE7,$BLOQUE8);

	}	
}