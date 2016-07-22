<?php

namespace app\models;
use Yii;
use yii\db\ActiveRecord;
use yii\db\Command;

class QueryPrueba extends Command{
	
	public static function getDb(){
		
		return Yii::$app->telmovil;
	}
	
	public static function tableName(){
	
		return "TALENTOS.T_ADMIN";
	}
	
}

