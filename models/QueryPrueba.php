<?php

namespace app\models;
use Yii;
use yii\db\ActiveRecord;
use yii\db\Command;

class QueryPrueba extends Command{
	
	
		
		return Yii::$app->telmovil->createCommand("SELECT A.NOM_EPL AS NOMBRE FROM TALENTOS.EMPLEADOS_BASIC A, TALENTOS.EMPLEADOS_GRAL B
WHERE  A.ESTADO = 'A' AND A.COD_EPL = B.COD_EPL")->queryAll();
	
	
}