<?php defined('_EXE') or die('Restricted access'); ?>

<div class="well">
	<form class="form-horizontal ajax" method="post" name="registerForm" id="registerForm" action="<?=Url::site("user/doRegister")?>">
		<div class="control-group">
	    	<label class="control-label" for="username">Username</label>
	    	<div class="controls">
		    	<input type="text" id="username" name="username" placeholder="Username">
		    </div>
		</div>
		<div class="control-group">
	    	<label class="control-label" for="email">Email</label>
	    	<div class="controls">
		    	<input type="text" id="email" name="email" placeholder="Email">
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
			    <button type="submit" class="btn btn-primary">Register</button>
			</div>
		</div>
	</form>
</div>