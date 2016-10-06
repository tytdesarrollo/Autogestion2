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

	$usuario =  Yii::$app->request->get('usuario');
	$clave = Yii::$app->request->get('clave');

  $ID_LOGIN= $usuario;
  $PASS= $clave;
  $OPERACION= 'L';
  $EMPLOYEE_ID= '';
  $OUTPUT= '';
  $MESSAGE= '';
  $KEY_ACT= '';
  
		$rows = Yii::$app->telmovil->createCommand("BEGIN 
		TW_PC_IDENTITY ( :ID_LOGIN, :PASS, :OPERACION, :KEY_ACT, :EMPLOYEE_ID, :OUTPUT, :MESSAGE);
		END;");

$rows->bindParam(":ID_LOGIN", $ID_LOGIN, PDO::PARAM_STR);
$rows->bindParam(":PASS", $PASS, PDO::PARAM_STR);
$rows->bindParam(":OPERACION", $OPERACION, PDO::PARAM_STR);
$rows->bindParam(":KEY_ACT", $KEY_ACT, PDO::PARAM_STR);
$rows->bindParam(":EMPLOYEE_ID", $EMPLOYEE_ID, PDO::PARAM_INT,200);
$rows->bindParam(":OUTPUT", $OUTPUT, PDO::PARAM_INT,200);
$rows->bindParam(":MESSAGE", $MESSAGE, PDO::PARAM_STR,200);


$rows->execute();

return $twpcidentity = array($EMPLOYEE_ID,$OUTPUT,$MESSAGE);

	}
	
}