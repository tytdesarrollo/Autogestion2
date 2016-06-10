<?php
use yii\helpers\Html;
use yii\widgets\LinkPager;
?>
<h1>Alumnos</h1>
<ul>
<?php foreach ($empleados_basic as $empleados): ?>
    <li>
        <?= Html::encode("{$empleados->NOM_EPL} ({$empleados->COD_EPL})") ?>
        <?= $empleados->COD_EPL ?>
    </li>
<?php endforeach; ?>
</ul>

<?= LinkPager::widget(['pagination' => $pagination]) ?>