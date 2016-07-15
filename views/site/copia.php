<?php
use yii\helpers\Html;
use yii\widgets\LinkPager;
?>
<h1>Alumnos</h1>


<table class="table table-bordered">


 <?php foreach($emplea as $row): ?>

 <tr>


 <td><?= $row->COD_EPL ?></td>
 </tr>


    <?php endforeach; ?>
</table>
