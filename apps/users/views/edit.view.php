<?php defined('_EXE') or die('Restricted access'); ?>

<?php $currentUser = Registry::getUser();?>

<h1>
	<span class="glyphicon glyphicon-user"></span>
	<?=Registry::translate("VIEW_USERS_TITLE");?>
	<small>
		<?=$user->id ? Registry::translate("VIEW_USERS_SUBTITLE_EDIT") : Registry::translate("VIEW_USERS_SUBTITLE_NEW");?>
	</small>
</h1>

<div class="main">
	<form method="post" name="mainForm" id="mainForm" action="<?=Url::site();?>" class="form-horizontal ajax" role="form" autocomplete="off">
		<input type="hidden" name="app" id="app" value="users">
		<input type="hidden" name="action" id="action" value="save">
		<input type="hidden" name="id" value="<?=$user->id?>">
		<div class="row">
			<div class="col-md-12">
				<div class="panel panel-default">
					<div class="panel-heading">
						<?=Registry::translate("VIEW_USERS_PANEL_USER_TITLE");?>
					</div>
				  	<div class="panel-body">
				    	<div class="form-group">
							<label class="col-sm-2 control-label">
								<?=Registry::translate("VIEW_USERS_FIELDS_STATUS");?>
							</label>
							<div class="col-sm-10">
								<input type="checkbox" name="statusId" id="statusId" value="1" <?php if($user->statusId) echo "checked";?>>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label">
								<?=Registry::translate("VIEW_USERS_FIELDS_ROLE");?>
							</label>
							<div class="col-sm-10">
								<select class="form-control" name="roleId" id="roleId">
									<?php $s = array(); ?>
									<?php $s[$user->roleId] = "selected"; ?>
									<?php foreach($user->roles as $roleId=>$roleString){ ?>
										<?php if($currentUser->roleId>$roleId || $currentUser->roleId>=2){ ?>
											<option value="<?=$roleId?>" <?=$s[$roleId]?>>
												<?=Registry::translate($roleString);?>
											</option>
										<?php } ?>
									<?php } ?>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label">
								<?=Registry::translate("VIEW_USERS_FIELDS_USERNAME");?>
							</label>
							<div class="col-sm-10">
								<input type="text" id="username" name="username" class="form-control" value="<?=Helper::sanitize($user->username);?>">
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label">
								<?=Registry::translate("VIEW_USERS_FIELDS_EMAIL");?>
							</label>
							<div class="col-sm-10">
								<input type="text" id="email" name="email" class="form-control" value="<?=Helper::sanitize($user->email);?>">
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label">
								<?=Registry::translate("VIEW_USERS_FIELDS_PASSWORD");?>
							</label>
							<div class="col-sm-10">
								<input type="password" id="password" name="password" class="form-control">
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label">
								<?=Registry::translate("VIEW_USERS_FIELDS_LANGUAGE");?>
							</label>
							<div class="col-sm-10">
								<select class="form-control" name="language" id="language">
									<?php $languages = Language::getLanguages(); ?>
									<?php $s = array(); ?>
									<?php $s[$user->language] = "selected"; ?>
									<?php foreach($languages as $lang){ ?>
										<option value="<?=$language?>" <?=$s[$lang]?>>
											<?=Registry::translate($lang);?>
										</option>
									<?php } ?>
								</select>
							</div>
						</div>
						<div class="form-group">
							<div class="col-sm-offset-2 col-sm-10">
								<?php if($user->id){ ?>
									<button class="btn btn-danger ladda-button delete" data-style="slide-left" confirm="<?=Registry::translate("VIEW_USERS_CONFIRM_DELETE")?>">
										<span class="ladda-label">
											<?=Registry::translate("BTN_DELETE");?>
										</span>
									</button>
								<?php } ?>
								<a class="btn btn-default ladda-button" data-spinner-color="#000" data-style="slide-left" href="<?=Url::site("users");?>">
									<span class="ladda-label">
										<?=Registry::translate("BTN_CANCEL");?>
									</span>
								</a>
								<button class="btn btn-primary ladda-button" data-style="slide-left">
									<span class="ladda-label">
										<?=$user->id ? Registry::translate("BTN_SAVE") : Registry::translate("BTN_NEW");?>
									</span>
								</button>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</form>
</div>