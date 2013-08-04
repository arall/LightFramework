<?php defined('_EXE') or die('Restricted access'); ?>

<div class="well">
	<fieldset>
		<legend>Register</legend>
		<form class="form-horizontal ajax" method="post" name="registerForm" id="registerForm" action="<?=Url::site("user/doRegister")?>">
			<div class="form-group">
		    	<label class="control-label" for="username">Username</label>
			    <input type="text" class="form-control" id="username" name="username" placeholder="Username">
			</div>
			<div class="form-group">
		    	<label class="control-label" for="email">Email</label>
		    	<input type="text" class="form-control" id="email" name="email" placeholder="Email">
			</div>
			<div class="form-group">
		    	<label class="control-label" for="password">Password</label>
		    	<input type="password" class="form-control" id="password" name="password" placeholder="Password">
			</div>
			<div class="form-group">
		    	<button type="submit" class="btn btn-primary">Register</button>
			</div>
		</form>
	</fieldset>
</div>