<?php defined('_EXE') or die('Restricted access'); ?>

<div class="well">
	<fieldset>
		<legend>Login</legend>
		<?php $user = Registry::getUser(); ?>
		<?php if(!$user->id){ ?>
			<form class="form-horizontal ajax" method="post" name="loginForm" id="loginForm" action="<?=Url::site("user/doLogin")?>">
				<div class="form-group">
					<label class="control-label" for="login">Username</label>
				  	<input type="text" class="form-control" id="login" name="login" placeholder="Username / email">
				</div>
				<div class="form-group">
			    	<label class="control-label" for="password">Password</label>
				    <input type="password" class="form-control" id="password" name="password" placeholder="Password">
				</div>
				<div class="form-group">
			    	<a href="<?=Url::site("user/register")?>" class="btn btn-default" />Register</a>
					<button type="submit" class="btn btn-primary">Login</button>
				</div>
			</form>
		<?php }else{ ?>
			<h3>Hi there <?=$user->username?>! :)</h3>
			<a class="btn" href="<?=Url::site("user/doLogout")?>">Logout</a>
		<?php } ?>
	</fieldset>
</div>