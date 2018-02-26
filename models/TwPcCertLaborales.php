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
		
	$cod_epl = Yii::$app->session['cedula'];
	$tipo = Yii::$app->session['checklab'];
	$destinatario = Yii::$app->session['textlab'];

  $BLOQUEA= '';
  $BLOQUET= '';  
  $BLOQUEB= '';
  $BLOQUEC= '';
  $CODIGO_EPL= $cod_epl;
  $TIPO= $tipo;
  $DESTINATARIO= $destinatario;

  
		$rows = Yii::$app->telmovil->createCommand("BEGIN TW_PC_CERT_LABORALES1 (:CODIGO_EPL,:TIPO,:DESTINATARIO,:BLOQUEA,:BLOQUET,:BLOQUEB,:BLOQUEC);	END;");

$rows->bindParam(":CODIGO_EPL", $CODIGO_EPL, PDO::PARAM_STR);
$rows->bindParam(":TIPO", $TIPO, PDO::PARAM_STR);
$rows->bindParam(":DESTINATARIO", $DESTINATARIO, PDO::PARAM_STR);
$rows->bindParam(":BLOQUEA", $BLOQUEA, PDO::PARAM_STR,1000);
$rows->bindParam(":BLOQUET", $BLOQUET, PDO::PARAM_STR,1000);
$rows->bindParam(":BLOQUEB", $BLOQUEB, PDO::PARAM_STR,1000);
$rows->bindParam(":BLOQUEC", $BLOQUEC, PDO::PARAM_STR,1000);


$rows->execute();

return $twpccertlaborales = array($BLOQUEA,$BLOQUET,$BLOQUEB,$BLOQUEC);

	}	
}