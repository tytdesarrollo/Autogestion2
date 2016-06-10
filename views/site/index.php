<?php
use yii\helpers\Html;
use app\assets\AppAsset;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Alert;

AppAsset::register($this);

$this->title = '.:Autogestion:.';
?>

<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body class='bg__grt-blue'>

<?php $this->beginBody() ?>

<div class="alert-login text-center">
 <?php echo Alert::widget([
    'options' => [
        'class' => 'alert-info',
    ],
    'body' => '<strong>Importante!</strong> Por favor escribe tu usuario de red sin dominio (NH/TELECOM) y seguido su clave de red.',
]);?>
</div>

 <div class="container text-center">

	<div class="row">
		<div class="col-md-12 text-right"><h2 class="txt__light-100"> </h2></div>
	</div>
	<div class="row">
		<div class="col-md-4 col-md-offset-4">
			<div>
				<?= Html::img('@web/img/logo_ag.png', ['alt' => 'Auto Gestión Web']) ?>
			</div>
			<div>
				<h3 class="txt__light-100 mrg__top-30">Inicia sesión con tu cuenta</h3>
				<div class="text-left">
					<?php $form = ActiveForm::begin(['id' => 'login-form']); ?>
						<?= $form->field($model, 'usuario', ['options' => ['class' => 'form-group label-floating']])->textInput(['autofocus' => true]) ?>
						 <?= $form->field($model, 'clave', ['options' => ['class' => 'form-group label-floating']])->passwordInput() ?>
						<div class="form-group text-center">
							<?= Html::submitButton('Ingresar', ['class' => 'btn btn-raised btn-info btn-block', 'name' => 'send-button']) ?>
						</div>
					<?php ActiveForm::end(); ?>
				</div>
			</div>
			<div class="pdg__16">
				<?= Html::img('@web/img/logo_telefonica.png', ['alt' => 'Telefónica']) ?>
			</div>
		</div>
	</div>
</div>
<footer class="footer-login text-center">
	<p class="txt__light-100">Power by Talentos & Tecnología</p>
</footer>

<?php $this->endBody() ?>
<script>
  $(function () {
    $.material.init();
  });
</script>
</body>
</html>
<?php $this->endPage() ?>