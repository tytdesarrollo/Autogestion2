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
 
 <div class="container text-center txt__light-100">
	<div class="content-mrg__top-10">
		<div class="clearfix">
			<h3 class="mrg__top-30">Asigna tu contraseña</h3>
		</div>
		<div class="row mrg__top-30">
			<div class="col-sm-4 col-sm-offset-1 col-md-3 col-md-offset-2 mrg__bottom-30">
				<div class="content-avatar__update-image">
					<input type="file" class="input-file">
					<?= Html::img('@web/img/avatar.png', ['alt' => 'avatar', 'class' => 'img-avatar img-circle']) ?>
					<span class="label-update">Cambiar</span>
				</div>
			</div>
			<div class="col-sm-6 col-md-5 text-left mrg__bottom-20">
				<p>Establece una única contraseña para tu próximo inicio de sesión.</p>
				<div class="clearfix"></div>
				<div class="form-group label-floating mrg__top-15">
					<label class="control-label" for="focusedInput1">Nueva contraseña</label>
					<input class="form-control" id="focusedInput1" type="text">
				</div>
				<div class="form-group label-floating mrg__top-15">
					<label class="control-label" for="focusedInput1">Confirma contraseña</label>
					<input class="form-control" id="focusedInput1" type="text">
				</div>
				<div class="form-group text-right no-mrg">
					<button class="btn btn-raised btn-info">Continuar</button>
				</div>
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