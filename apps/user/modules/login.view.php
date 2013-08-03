<?php defined('_EXE') or die('Restricted access'); ?>

<div class="well">
	<?php $user = Registry::getUser(); ?>
	<?php if(!$user->id){ ?>
		<form class="form-horizontal ajax" method="post" name="loginForm" id="loginForm" action="<?=Url::site("user/login")?>">
			<div class="control-group">
		    	<label class="control-label" for="username">Username / email</label>
		    	<div class="controls">
			    	<input type="text" id="login" name="login" placeholder="Username / email">
			    </div>
			</div>
			<div class="control-group">
		    	<label class="control-label" for="password">Password</label>
		    	<div class="controls">
			    	<input type="password" id="password" name="password" placeholder="Password">
			    </div>
			</div>
			<div class="control-group">
		    	<div class="controls">
		    		<a href="<?=Url::site("user/register")?>" class="btn" />Register</a>
				    <button type="submit" class="btn btn-primary">Login</button>
				</div>
			</div>
		</form>
	<?php }else{ ?>
		<h3>Hi there <?=$user->username?>! :)</h3>
		<a class="btn" href="<?=Url::app("user/logout")?>">Logout</a>
	<?php } ?>
</div>