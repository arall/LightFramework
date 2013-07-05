<?php defined('_EXE') or die('Restricted access');?>

<?php $user = Registry::getUser(); ?>
<?php if(!$user->id){ ?>
	<form class="form-horizontal formAjax" method="post" name="loginForm" id="loginForm" action="<?=Url::app("acceso")?>">
		<div class="control-group">
	    	<label class="control-label" for="username">Username</label>
	    	<div class="controls">
		    	<input type="text" id="username" name="username" placeholder="Demo">
		    </div>
		</div>
		<div class="control-group">
	    	<label class="control-label" for="password">Password</label>
	    	<div class="controls">
		    	<input type="password" id="password" name="password" placeholder="Demo">
		    </div>
		</div>
		<div class="control-group">
	    	<div class="controls">
			    <button type="submit" class="btn">Login</button>
			</div>
		</div>
	</form>
<?php }else{ ?>
	<h3>Hi there <?=$user->username?>! :)</h3>
	<a class="btn" href="<?=Url::app("acceso/logout")?>">Logout</a>
<?php } ?>