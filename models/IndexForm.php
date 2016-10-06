<?php

namespace app\models;
use Yii;
use yii\base\Model;
//use app\models\TwPcIdentity;

class IndexForm extends Model
{
    public $usuario;
    public $clave;

    public function rules()
    {
        return [
			
			["usuario", "required", "message"=>"Escribe tu usuario, es requerido"],
			["usuario", "match", "pattern"=>"/^.{3,10}$/", "message"=>"Minimo 3 y maximo 10 caracteres"],
			//["usuario", "match", "pattern"=>"/^[0-9a-z]+$/i", "message"=>"Solo se aceptan letras y numeros"],
			["clave", "required", "message"=>"Escribe tu clave, es requerida"],
			["clave", "match", "pattern"=>"/^.{5,80}$/", "message"=>"Minimos de 3 a 10 caracteres"]					
        ];
    }
	
	public function attributeLabels(){
		
		return [
		"usuario"=>"Escribe tu usuario",
		"clave"=>"Escribe tu clave",
		];
	}


	
}
