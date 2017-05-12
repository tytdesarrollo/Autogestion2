<?php
use yii\helpers\Html;
?>
<h1>Datos</h1>


<?php
	//echo 'SIZE '.sizeof($menus);
	$array =array();

	foreach ($menus as $key) {
		echo $key['VALOR'];
		echo '<br>';

		$array[] = $key['VALOR'];;
	}
	echo '<br>';echo '<br>';echo '<br>';

	echo($array[0]);
?>