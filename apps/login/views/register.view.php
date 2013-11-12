<?php defined('_EXE') or die('Restricted access'); ?>

<div class="well">
	<fieldset>
		<legend>Register</legend>
		<form class="form-horizontal ajax" role="form" method="post" name="registerForm" id="registerForm" action="<?=Url::site("login/doRegister")?>">
			<div class="form-group">
			    <label for="login" class="col-sm-2 control-label">Username</label>
			    <div class="col-sm-10">
			    	<input type="text" class="form-control" id="username" name="username" placeholder="Username">
			    </div>
			</div>
			<div class="form-group">
			    <label for="email" class="col-sm-2 control-label">Email</label>
			    <div class="col-sm-10">
			    	<input type="text" class="form-control" id="email" name="email" placeholder="Email">
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
			    	<button type="submit" class="btn btn-primary">Submit</button>
			    </div>
			</div>
		</form>
	</fieldset>
</div>