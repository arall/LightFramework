<?php defined('_EXE') or die('Restricted access'); ?>

<div class="jumbotron">
	<h1>Hello, world!</h1>
	<p>This is a sample funcion to generate random strings.</p>
	<p>We already have generated <?=$total?> random strings.</p>
	<p>Last string is: <?=$demo->string?></p>
	<p><?=Registry::translate("TEST_STRING");?></p>
	<p><a class="btn btn-primary btn-lg" role="button" href="<?=Url::site("demo/generate");?>">Randomize!</a></p>
</div>