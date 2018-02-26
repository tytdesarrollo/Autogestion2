								<?php
//var_dump($equipo); 

	for($i = 0 ; $i < count($equipo)-1 ; $i++) {
		$BLOQUE9_KEY_ARR = explode("_*", $equipo[$i]);
		
		//var_dump($BLOQUE9_KEY_ARR);
		
		for ($j = 0 ; $j < count($BLOQUE9_KEY_ARR) ; $j++) {
			echo $j;
			echo '<br>';
			echo $BLOQUE9_KEY_ARR[$j];
			echo '<br>';
		}
		//echo $BLOQUE9_KEY_ARR[1];
		echo '<br><br><br><br>';
		/*$BLOQUE9_KEY_ARR = explode("_*", $BLOQUE9_KEY);
		
		//echo $BLOQUE9_KEY_ARR[1].'</br>';
		
			//$CRONO_ARR[] = $CRONO_KEY['MES'];
			
			var_dump($BLOQUE9_KEY_ARR[1]);*/ 
		}	
		
		/*$i = 0;
		while ($i < count($equipo)) {
			  // $a = $arr[$i];
			   echo $equipo[6];
			   $i++;
		}*/
			
											?>
								
								