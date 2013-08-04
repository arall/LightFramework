<?php defined('_EXE') or die('Restricted access'); ?>

<div class="row">
  <div class="col-lg-4">
  	<h1><?php echo $title; ?></h1> 
  	<?php if(count($demos)){ ?>
		<?php foreach($demos as $demo){ ?>
			<h3>Demo <?=$demo->id?>: <?=$demo->string?></h3>
		<?php } ?>
	<?php } ?>
	<?=$controller->view("modules.demo"); ?>
  </div>
  	<?php if($title=="First Select"){ ?>
		<div class="col-lg-4 col-lg-offset-4">
			<?=$controller->view("modules.login", "user"); ?>
		</div>
	<?php } ?>
</div>