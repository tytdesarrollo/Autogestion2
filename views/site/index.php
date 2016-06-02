<script>
  $(function () {
    $.material.init();
  });
</script>

<?php
use yii\helpers\Html;
use app\assets\AppAsset;

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

 <div class="container">

<div class="site-index">

<?= Html::img('@web/img/Inicio-ag-Desktop_03.png', ['alt' => 'Logo Emp'], ['class' => 'profile-link']) ?>

    </div>
</div>


<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>