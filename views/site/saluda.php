<?php


 echo $mensaje;


 foreach ($array as $valor){
?>
<p><strong><?php echo $valor; ?></strong></p>
 <?php }; ?>
 
 <div class="alert alert-warning alert-dismissible" role="alert">
  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
  <strong>Warning!</strong> Better check yourself, you're not looking too good.
</div>