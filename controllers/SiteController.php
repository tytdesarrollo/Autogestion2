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
use app\models\Empleados_basic;
use app\models\Calendario;
use PDO;
use app\models\TwPcIdentity;
use app\models\Ldap;



class SiteController extends Controller
{
	
  
      public function actionCopia()
    {
        $query = new Empleados_basic;
		
		if (Yii::$app->user->isGuest) {
			 return $this->goBack();
        }else{

        $emplea = $query->find()->where(["ESTADO"=>"A","CEDULA"=>"79944076"])->all();

        return $this->render('copia', ['emplea' => $emplea]);
		}
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

		$model = new TwPcIdentity;

		$proce = $model->procedimiento();

        return $this->render('saluda', ["rows"=>$proce]);
	}
		
	public function actionFormulario($mensaje = null){
		
		return $this->render("formulario", ["mensaje"=>$mensaje]);
		
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

        $model = new IndexForm();
		
		if($model->load(Yii::$app->request->post()) && Yii::$app->request->isAjax){
			
			Yii::$app->response->format = Response::FORMAT_JSON;
			return ActiveForm::validate($model);			
		}
		
		if($model->load(Yii::$app->request->post())){
		if($model->validate()){
			
			Yii::$app->params['usuario'] = $model->usuario;
			Yii::$app->params['clave'] = $model->clave;
			
			return $this->redirect(['site/logueo','usuario'=>$model->usuario,'clave'=>$model->clave]);
			
		}else{
			
			 return $this->goBack();
			 
			}		
		}
		
        return $this->render('index', ['model' => $model]);
    }

	public function actionLogueo()
    {
		$modeladp = new Ldap;
		
		$ladpcon = $modeladp->directorioactivo();
		
		if(isset($ladpcon[0]) && $ladpcon[2]=="true"){
			
				return $this->redirect(['site/principal']);
				
		}elseif(isset($ladpcon[1]) && $ladpcon[2]=="true"){
			
			return $this->redirect(['site/index', "error"=>$ladpcon[1]]);
			
		}elseif($ladpcon[2]=="false"){
		
		$model = new TwPcIdentity;
		
		$twpcidentity = $model->procedimiento();
		
		if($twpcidentity[1]=="0"){
			
			return $this->redirect(['site/asignapassword']);
			
		}elseif($twpcidentity[1]=="1"){
			
			return $this->redirect(['site/principal']);
			
		}else{
			
			return $this->redirect(['site/index', "error"=>$twpcidentity[2]]);
			
		}        
			}else{
				return $this->redirect(['site/index', "error"=>"No hay conexion, por favor contacte con el administrador."]);
			}	   
    }
		
    public function actionSalida()
    {
        return $this->goHome();
    }

    public function actionVacaciones()
    {
        	
	if (Yii::$app->user->isGuest) {
			 return $this->goBack();
			 
        }else{
		
		$tablet_browser = 0;
			$mobile_browser = 0;
			$body_class = 'desktop';
			 
			if (preg_match('/(tablet|ipad|playbook)|(android(?!.*(mobi|opera mini)))/i', strtolower($_SERVER['HTTP_USER_AGENT']))) {
				$tablet_browser++;
				$body_class = "tablet";
			}
			 
			if (preg_match('/(up.browser|up.link|mmp|symbian|smartphone|midp|wap|phone|android|iemobile)/i', strtolower($_SERVER['HTTP_USER_AGENT']))) {
				$mobile_browser++;
				$body_class = "mobile";
			}
			 
			if ((strpos(strtolower($_SERVER['HTTP_ACCEPT']),'application/vnd.wap.xhtml+xml') > 0) or ((isset($_SERVER['HTTP_X_WAP_PROFILE']) or isset($_SERVER['HTTP_PROFILE'])))) {
				$mobile_browser++;
				$body_class = "mobile";
			}
			 
			$mobile_ua = strtolower(substr($_SERVER['HTTP_USER_AGENT'], 0, 4));
			$mobile_agents = array(
				'w3c ','acs-','alav','alca','amoi','audi','avan','benq','bird','blac',
				'blaz','brew','cell','cldc','cmd-','dang','doco','eric','hipt','inno',
				'ipaq','java','jigs','kddi','keji','leno','lg-c','lg-d','lg-g','lge-',
				'maui','maxo','midp','mits','mmef','mobi','mot-','moto','mwbp','nec-',
				'newt','noki','palm','pana','pant','phil','play','port','prox',
				'qwap','sage','sams','sany','sch-','sec-','send','seri','sgh-','shar',
				'sie-','siem','smal','smar','sony','sph-','symb','t-mo','teli','tim-',
				'tosh','tsm-','upg1','upsi','vk-v','voda','wap-','wapa','wapi','wapp',
				'wapr','webc','winw','winw','xda ','xda-');
			 
			if (in_array($mobile_ua,$mobile_agents)) {
				$mobile_browser++;
			}
			 
			if (strpos(strtolower($_SERVER['HTTP_USER_AGENT']),'opera mini') > 0) {
				$mobile_browser++;
				//Check for tablets on opera mini alternative headers
				$stock_ua = strtolower(isset($_SERVER['HTTP_X_OPERAMINI_PHONE_UA'])?$_SERVER['HTTP_X_OPERAMINI_PHONE_UA']:(isset($_SERVER['HTTP_DEVICE_STOCK_UA'])?$_SERVER['HTTP_DEVICE_STOCK_UA']:''));
				if (preg_match('/(tablet|ipad|playbook)|(android(?!.*mobile))/i', $stock_ua)) {
				  $tablet_browser++;
				}
			}
			if ($tablet_browser > 0) {
			// Si es tablet has lo que necesites
			$events = Yii::$app->mysqldb->createCommand("SELECT ID AS ID, TITLE AS TITLE, START AS START, END AS END, COLOR AS COLOR FROM EVENTS")->queryAll();
			
			$this->view->params['customParam'] = $events;

                return $this->render('mvacaciones',['events' => $events]);

			}
			else if ($mobile_browser > 0) {
			// Si es dispositivo mobil has lo que necesites			
			   $events = Yii::$app->mysqldb->createCommand("SELECT ID AS ID, TITLE AS TITLE, START AS START, END AS END, COLOR AS COLOR FROM EVENTS")->queryAll();
			
			$this->view->params['customParam'] = $events;

                return $this->render('mvacaciones',['events' => $events]);
			}
			else {
			// Si es ordenador de escritorio has lo que necesites
			$events = Yii::$app->mysqldb->createCommand("SELECT ID AS ID, TITLE AS TITLE, START AS START, END AS END, COLOR AS COLOR FROM EVENTS")->queryAll();
			
			$this->view->params['customParam'] = $events;
				
                return $this->render('vacaciones',['events' => $events]);
			}        
		}
    }
	
	public function actionAddevent(){
		
		if (Yii::$app->request->post()){
			
			$titulo = Html::encode($_POST["title"]);
			$start = Html::encode($_POST['start']);
			$end = Html::encode($_POST['end']);
			$color = Html::encode($_POST['color']);
			
			if(isset($titulo)){

			//INSERTO VACACIONES
			
			return $this->redirect(["site/vacaciones"]);
					
				}else{
					
				echo "ha ocurrido un error, redireccionando...";
				echo "<meta http-equiv='refresh' content='3;'".Url::toRoute("site/vacaciones")."'>";
				}				
				
			}else{
			
			return $this->redirect(["site/vacaciones"]);
		}
	}

    public function actionPrincipal()
    {				
		
        return $this->render('principal');
		
    }
	
	    public function actionMvacaciones()
    {
				if (Yii::$app->user->isGuest) {
			 return $this->goBack();
        }else{
		
		$tablet_browser = 0;
			$mobile_browser = 0;
			$body_class = 'desktop';
			 
			if (preg_match('/(tablet|ipad|playbook)|(android(?!.*(mobi|opera mini)))/i', strtolower($_SERVER['HTTP_USER_AGENT']))) {
				$tablet_browser++;
				$body_class = "tablet";
			}
			 
			if (preg_match('/(up.browser|up.link|mmp|symbian|smartphone|midp|wap|phone|android|iemobile)/i', strtolower($_SERVER['HTTP_USER_AGENT']))) {
				$mobile_browser++;
				$body_class = "mobile";
			}
			 
			if ((strpos(strtolower($_SERVER['HTTP_ACCEPT']),'application/vnd.wap.xhtml+xml') > 0) or ((isset($_SERVER['HTTP_X_WAP_PROFILE']) or isset($_SERVER['HTTP_PROFILE'])))) {
				$mobile_browser++;
				$body_class = "mobile";
			}
			 
			$mobile_ua = strtolower(substr($_SERVER['HTTP_USER_AGENT'], 0, 4));
			$mobile_agents = array(
				'w3c ','acs-','alav','alca','amoi','audi','avan','benq','bird','blac',
				'blaz','brew','cell','cldc','cmd-','dang','doco','eric','hipt','inno',
				'ipaq','java','jigs','kddi','keji','leno','lg-c','lg-d','lg-g','lge-',
				'maui','maxo','midp','mits','mmef','mobi','mot-','moto','mwbp','nec-',
				'newt','noki','palm','pana','pant','phil','play','port','prox',
				'qwap','sage','sams','sany','sch-','sec-','send','seri','sgh-','shar',
				'sie-','siem','smal','smar','sony','sph-','symb','t-mo','teli','tim-',
				'tosh','tsm-','upg1','upsi','vk-v','voda','wap-','wapa','wapi','wapp',
				'wapr','webc','winw','winw','xda ','xda-');
			 
			if (in_array($mobile_ua,$mobile_agents)) {
				$mobile_browser++;
			}
			 
			if (strpos(strtolower($_SERVER['HTTP_USER_AGENT']),'opera mini') > 0) {
				$mobile_browser++;
				//Check for tablets on opera mini alternative headers
				$stock_ua = strtolower(isset($_SERVER['HTTP_X_OPERAMINI_PHONE_UA'])?$_SERVER['HTTP_X_OPERAMINI_PHONE_UA']:(isset($_SERVER['HTTP_DEVICE_STOCK_UA'])?$_SERVER['HTTP_DEVICE_STOCK_UA']:''));
				if (preg_match('/(tablet|ipad|playbook)|(android(?!.*mobile))/i', $stock_ua)) {
				  $tablet_browser++;
				}
			}
			if ($tablet_browser > 0) {
			// Si es tablet has lo que necesites
			   return $this->render('mvacaciones');
			}
			else if ($mobile_browser > 0) {
			// Si es dispositivo mobil has lo que necesites
			   return $this->render('mvacaciones');
			}
			else {
			// Si es ordenador de escritorio has lo que necesites			 
			  return $this->render('vacaciones');
			}        
		}
    }
		public function actionAsignapassword()
    {
		  $this->layout=false;		  
		  
        return $this->render('asignapassword');
			
	}
}
