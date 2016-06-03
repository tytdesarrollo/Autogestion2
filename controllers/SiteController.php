<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\IndexForm;
use app\models\ContactForm;
use app\models\ValidarFormulario;
use app\models\ValidarFormularioAjax;
use yii\widgets\ActiveForm;
use yii\web\Response;
use app\models\FormAlumnos;
use app\models\Alumnos;
use app\models\FormSearch;
use yii\helpers\Html;
use yii\data\Pagination;
use yii\helpers\Url;
use app\models\Users;
use app\models\FormRegister;


class SiteController extends Controller
{
	
	
	private function randKey($str='', $long=0)
    {
        $key = null;
        $str = str_split($str);
        $start = 0;
        $limit = count($str)-1;
        for($x=0; $x<$long; $x++)
        {
            $key .= $str[rand($start, $limit)];
        }
        return $key;
    }
  
 public function actionConfirm()
 {
    $table = new Users;
    if (Yii::$app->request->get())
    {
   
        //Obtenemos el valor de los parámetros get
        $id = Html::encode($_GET["id"]);
        $authKey = $_GET["authKey"];
    
        if ((int) $id)
        {
            //Realizamos la consulta para obtener el registro
            $model = $table
            ->find()
            ->where("id=:id", [":id" => $id])
            ->andWhere("authKey=:authKey", [":authKey" => $authKey]);
 
            //Si el registro existe
            if ($model->count() == 1)
            {
                $activar = Users::findOne($id);
                $activar->activate = 1;
                if ($activar->update())
                {
                    echo "Enhorabuena registro llevado a cabo correctamente, redireccionando ...";
                    echo "<meta http-equiv='refresh' content='8; ".Url::toRoute("site/login")."'>";
                }
                else
                {
                    echo "Ha ocurrido un error al realizar el registro, redireccionando ...";
                    echo "<meta http-equiv='refresh' content='8; ".Url::toRoute("site/login")."'>";
                }
             }
            else //Si no existe redireccionamos a login
            {
                return $this->redirect(["site/login"]);
            }
        }
        else //Si id no es un número entero redireccionamos a login
        {
            return $this->redirect(["site/login"]);
        }
    }
 }
 
 public function actionRegister()
 {
  //Creamos la instancia con el model de validación
  $model = new FormRegister;
   
  //Mostrará un mensaje en la vista cuando el usuario se haya registrado
  $msg = null;
   
  //Validación mediante ajax
  if ($model->load(Yii::$app->request->post()) && Yii::$app->request->isAjax)
        {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }
   
  //Validación cuando el formulario es enviado vía post
  //Esto sucede cuando la validación ajax se ha llevado a cabo correctamente
  //También previene por si el usuario tiene desactivado javascript y la
  //validación mediante ajax no puede ser llevada a cabo
  if ($model->load(Yii::$app->request->post()))
  {
   if($model->validate())
   {
    //Preparamos la consulta para guardar el usuario
    $table = new Users;
    $table->username = $model->username;
    $table->email = $model->email;
    //Encriptamos el password
    $table->password = crypt($model->password, Yii::$app->params["salt"]);
    //Creamos una cookie para autenticar al usuario cuando decida recordar la sesión, esta misma
    //clave será utilizada para activar el usuario
    $table->authKey = $this->randKey("abcdef0123456789", 200);
    //Creamos un token de acceso único para el usuario
    $table->accessToken = $this->randKey("abcdef0123456789", 200);
     
    //Si el registro es guardado correctamente
    if ($table->insert())
    {
     //Nueva consulta para obtener el id del usuario
     //Para confirmar al usuario se requiere su id y su authKey
     $user = $table->find()->where(["email" => $model->email])->one();
     $id = urlencode($user->id);
     $authKey = urlencode($user->authKey);
      
     $subject = "Confirmar registro";
     $body = "<h1>Haga click en el siguiente enlace para finalizar tu registro</h1>";
     $body .= "<a href='http://yii.local/index.php?r=site/confirm&id=".$id."&authKey=".$authKey."'>Confirmar</a>";
      
     //Enviamos el correo
     Yii::$app->mailer->compose()
     ->setTo($user->email)
     ->setFrom([Yii::$app->params["adminEmail"] => Yii::$app->params["title"]])
     ->setSubject($subject)
     ->setHtmlBody($body)
     ->send();
     
     $model->username = null;
     $model->email = null;
     $model->password = null;
     $model->password_repeat = null;
     
     $msg = "Enhorabuena, ahora sólo falta que confirmes tu registro en tu cuenta de correo";
    }
    else
    {
     $msg = "Ha ocurrido un error al llevar a cabo tu registro";
    }
     
   }
   else
   {
    $model->getErrors();
   }
  }
  return $this->render("register", ["model" => $model, "msg" => $msg]);
 }
	
	
	 public function actionUpdate()
    {
        $model = new FormAlumnos;
        $msg = null;
        
        if($model->load(Yii::$app->request->post()))
        {
            if($model->validate())
            {
                $table = Alumnos::findOne($model->id_alumno);
                if($table)
                {
                    $table->nombre = $model->nombre;
                    $table->apellidos = $model->apellidos;
                    $table->clase = $model->clase;
                    $table->nota_final = $model->nota_final;
                    if ($table->update())
                    {
                        $msg = "El Alumno ha sido actualizado correctamente";
                    }
                    else
                    {
                        $msg = "El Alumno no ha podido ser actualizado";
                    }
                }
                else
                {
                    $msg = "El alumno seleccionado no ha sido encontrado";
                }
            }
            else
            {
                $model->getErrors();
            }
        }
        
        
        if (Yii::$app->request->get("id_alumno"))
        {
            $id_alumno = Html::encode($_GET["id_alumno"]);
            if ((int) $id_alumno)
            {
                $table = Alumnos::findOne($id_alumno);
                if($table)
                {
                    $model->id_alumno = $table->id_alumno;
                    $model->nombre = $table->nombre;
                    $model->apellidos = $table->apellidos;
                    $model->clase = $table->clase;
                    $model->nota_final = $table->nota_final;
                }
                else
                {
                    return $this->redirect(["site/view"]);
                }
            }
            else
            {
                return $this->redirect(["site/view"]);
            }
        }
        else
        {
            return $this->redirect(["site/view"]);
        }
        return $this->render("update", ["model" => $model, "msg" => $msg]);
    }
	
	public function actionDelete(){
		
		if (Yii::$app->request->post()){
			
			$id_alumno = Html::encode($_POST["id_alumno"]);
			if((int)$id_alumno){
				
				if(Alumnos::deleteAll("id_alumno=:id_alumno", [":id_alumno"=>$id_alumno])){
					
					echo "Alumno con id $id_alumno eliminado con exito, redireccionando ..";
					echo "<meta http-equiv='refresh' content='3;'".Url::toRoute("site/view")."'>";
					
				}else{
					
				echo "ha ocurrido un error, redireccionando";
				echo "<meta http-equiv='refresh' content='3;'".Url::toRoute("site/view")."'>";
				}
				
			}else{
				echo "ha ocurrido un error, redireccionando";
				echo "<meta http-equiv='refresh' content='3;'".Url::toRoute("site/view")."'>";
			}
			
		}else{
			
			return $this->redirect(["site/view"]);
		}
	}
	
	
	public function actionView(){
		
		$form= new FormSearch;
		$search = null;
		
		if($form->load(Yii::$app->request->get())){
			
			if($form->validate()){
				
				$search = Html::encode($form->q);
				$table = Alumnos::find()
				->where (["like","id_alumno", $search])
				->orWhere(["like","nombre", $search])
				->orWhere(["like","apellidos", $search]);
				$count =clone $table;
				$pages =new Pagination ([
				"pageSize"=> 1,
				"totalCount"=> $count->count(),
				]);
				$model = $table->offset($pages->offset)->limit($pages->limit)->all();
			}else{
				
				$form->getErrors();
			}
			
		}else{
			
			$table =Alumnos::find();
			$count= clone $table;
			$pages = new Pagination([
			"pageSize"=>1,
			"totalCount"=> $count->count(),
			]);
			
			$model = $table->offset($pages->offset)->limit($pages->limit)->all();
		}
		
		return $this->render("view", ["model"=>$model, "form" => $form, "search" => $search, "pages"=>$pages]);
		
	}
	
	
	public function actionCreate(){
		
		$model = new FormAlumnos;
		$msg = null;
		
		if($model->load(Yii::$app->request->post())){
			
			if($model->validate()){
				
				$table = new Alumnos;
				$table->nombre = $model->nombre;
				$table->apellidos = $model->apellidos;
				$table->clase = $model->clase;
				$table->nota_final = $model->nota_final;
				
				if($table->insert()){
					
					$msg ="registro guardado correctamente";
					$model->nombre =null;
					$model->apellidos =null;
					$model->clase =null;
					$model->nota_final =null;
					
				}else{
					
					$msg ="registro no fue guardado";
				}
				
			}else{
				
				$model->getErrors();
			}
		}
		
		return $this->render("create", ["model" => $model, "msg"=>$msg]);
	}
	
	public function actionSaluda(){
		$mensaje = "hola mundo";
		$numeros = [0,1,2,3,4,5];
		
		return $this->render("saluda", 
		["mensaje"=>$mensaje,
		"array" => $numeros		
		]);
	}
	
	
	public function actionFormulario($mensaje = null){
		
		return $this->render("formulario", ["mensaje"=>$mensaje]);
		
	}
	
	public function actionRequest (){
		
		$mensaje = null;
		
		if  (isset($_REQUEST["nombre"])){
			
			$mensaje = "has enviado tu nombre correctamente: ".$_REQUEST["nombre"]."";
			
		}
		
		$this->redirect(["site/formulario", "mensaje" => $mensaje]);
		
	}
	
	public function actionValidarformulario(){
		
		$model = new ValidarFormulario;
		
		if($model->load(Yii::$app->request->post())){
			
			if($model->validate()){
				
				//DBadsasd
				
			}else{
				
				$model->getErrors();
				
			}
			
		}
		
		return $this->render("validarformulario",["model"=>$model]);
		
	}
	
	public function actionValidarformularioajax(){
		
		$model = new ValidarFormularioAjax;
		
		$msg = null;
		
		if($model->load(Yii::$app->request->post()) && Yii::$app->request->isAjax){
			
			Yii::$app->response->format = Response::FORMAT_JSON;
			return ActiveForm::validate($model);
			
		}
		
		if($model->load(Yii::$app->request->post())){
		if($model->validate()){
			
			$msg = "formulario enviado correctamente";
			$model->nombre = null;
			$model->email = null;
		}else{
			$model->getErrors();
		}
		
		}
		return $this->render("validarformularioajax", ["model"=>$model, "msg"=>$msg]);
	}
	
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function actionIndex()
    {
		 $this->layout=false;       
		
		if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new IndexForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }
        return $this->render('index', [
            'model' => $model,
        ]);
    }

    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    public function actionAbout()
    {
        return $this->render('about');
    }
}
