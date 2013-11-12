<?php defined('_EXE') or die('Restricted access'); ?>

<div class="well">
	<fieldset>
		<legend>Login</legend>
		<?php $user = Registry::getUser(); ?>
		<?php if(!$user->id){ ?>
			<form class="form-horizontal ajax" role="form" method="post" name="loginForm" id="loginForm" action="<?=Url::site("login/doLogin")?>">
				<div class="form-group">
				    <label for="login" class="col-sm-2 control-label">Username</label>
				    <div class="col-sm-10">
				    	<input type="text" class="form-control" id="login" name="login" placeholder="Username / email">
				    </div>
				</div>
				<div class="form-group">
				    <label for="login" class="col-sm-2 control-label">Password</label>
				    <div class="col-sm-10">
				    	<input type="password" class="form-control" id="password" name="password" placeholder="Password">
				    </div>
				</div>
				<div class="form-group">
				    <div class="col-sm-offset-2 col-sm-10">
				    	<a href="<?=Url::site("login/register")?>" class="btn btn-default" />Register</a>
				    	<button type="submit" class="btn btn-primary">Sign in</button>
				    </div>
				</div>
			</form>
		<?php }else{ ?>
			<h3>Hi there <?=$user->username?>! :)</h3>
			<a class="btn btn-primary" href="<?=Url::site("login/doLogout")?>">Logout</a>
		<?php } ?>
	</fieldset>
</div>