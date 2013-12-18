<?php defined('_EXE') or die('Restricted access'); ?>

<div class="well">
	<fieldset>
		<legend>
			<?=Registry::translate("VIEW_LOGIN_REGISTER_TITLE");?>
		</legend>
		<form class="form-horizontal ajax" role="form" method="post" name="registerForm" id="registerForm" action="<?=Url::site("login/doRegister")?>">
			<div class="form-group">
			    <label for="login" class="col-sm-2 control-label">
			    	<?=Registry::translate("VIEW_LOGIN_REGISTER_FIELDS_USERNAME");?>
			    </label>
			    <div class="col-sm-10">
			    	<input type="text" class="form-control" id="username" name="username" placeholder="<?=Registry::translate("VIEW_LOGIN_REGISTER_FIELDS_USERNAME_PLACEHOLDER");?>">
			    </div>
			</div>
			<div class="form-group">
			    <label for="email" class="col-sm-2 control-label">
			    	<?=Registry::translate("VIEW_LOGIN_REGISTER_FIELDS_EMAIL");?>
			    </label>
			    <div class="col-sm-10">
			    	<input type="text" class="form-control" id="email" name="email" placeholder="<?=Registry::translate("VIEW_LOGIN_REGISTER_FIELDS_EMAIL_PLACEHOLDER");?>">
			    </div>
			</div>
			<div class="form-group">
			    <label for="login" class="col-sm-2 control-label">
			    	<?=Registry::translate("VIEW_LOGIN_REGISTER_FIELDS_PASSWORD");?>
			    </label>
			    <div class="col-sm-10">
			    	<input type="password" class="form-control" id="password" name="password" placeholder="<?=Registry::translate("VIEW_LOGIN_REGISTER_FIELDS_PASSWORD_PLACEHOLDER");?>">
			    </div>
			</div>
			<div class="form-group">
			    <div class="col-sm-offset-2 col-sm-10">
			    	<button type="submit" class="btn btn-primary">
			    		<?=Registry::translate("VIEW_BTN_SUBMIT");?>
			    	</button>
			    </div>
			</div>
		</form>
	</fieldset>
</div>