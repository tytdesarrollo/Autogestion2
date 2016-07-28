<?php
use yii\helpers\Html;
?>
<h1>Datos</h1>


<table class="table table-bordered">


 <?php 
 
foreach($rows as $item): ?>

 <tr>

 <td><?= $item['NOMBRE'] ?></td>
 </tr>


    <?php endforeach; ?>

</table>