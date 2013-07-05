<?php defined('_EXE') or die('Restricted access'); ?>

<h1><?php echo $title; ?></h1>

<?php if(count($demos)){ ?>
	<?php foreach($demos as $demo){ ?>
		<h3>Demo <?=$demo->id?>: <?=$demo->string?></h3>
	<?php } ?>
<?php } ?>

<?//=$controller->view("modules.login"); ?>