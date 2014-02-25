<?php defined('_EXE') or die('Restricted access'); ?>

<?php $user = Registry::getUser();?>

<h1>
	<span class="glyphicon glyphicon-wrench"></span>
	<?=Registry::translate("VIEW_ACCOUNT_TITLE");?>
	<small>
		<?=Registry::translate("VIEW_ACCOUNT_SUBTITLE_EDIT");?>
	</small>
</h1>

<div class="main">
	<form method="post" action="<?=Url::site();?>" class="form-horizontal ajax" role="form" autocomplete="off">
		<input type="hidden" name="app" id="app" value="account">
		<input type="hidden" name="action" id="action" value="save">
		<div class="row">
			<div class="col-md-12">
				<div class="panel panel-default">
					<div class="panel-heading">
						<?=Registry::translate("VIEW_ACCOUNT_PANEL_ACCOUNT_TITLE");?>
					</div>
				  	<div class="panel-body">
				  		<!-- Username -->
						<div class="form-group">
							<label class="col-sm-2 control-label">
								<?=Registry::translate("VIEW_ACCOUNT_FIELDS_USERNAME");?>
							</label>
							<div class="col-sm-10">
								<input type="text" id="name" name="name" class="form-control" value="<?=Helper::sanitize($user->username);?>">
							</div>
						</div>
						<!-- Email -->
						<div class="form-group">
							<label class="col-sm-2 control-label">
								<?=Registry::translate("VIEW_ACCOUNT_FIELDS_EMAIL");?>
							</label>
							<div class="col-sm-10">
								<input type="text" id="email" name="email" class="form-control" value="<?=Helper::sanitize($user->email);?>">
							</div>
						</div>
						<!-- Password -->
						<div class="form-group">
							<label class="col-sm-2 control-label">
								<?=Registry::translate("VIEW_ACCOUNT_FIELDS_PASSWORD");?>
							</label>
							<div class="col-sm-10">
								<input type="password" id="password" name="password" class="form-control">
							</div>
						</div>
						<!-- Buttons -->
						<div class="form-group">
							<label class="col-sm-2 control-label">
								<?=Registry::translate("VIEW_ACCOUNT_FIELDS_LANGUAGE");?>
							</label>
							<div class="col-sm-10">
								<select class="form-control" name="language" id="language">
									<?php $languages = Language::getLanguages(); ?>
									<?php $s = array(); ?>
									<?php $s[$user->language] = "selected"; ?>
									<?php foreach($languages as $lang){ ?>
										<option value="<?=$language?>" <?=$s[$lang]?>>
											<?=$lang;?>
										</option>
									<?php } ?>
								</select>
							</div>
						</div>
						<!-- Buttons -->
						<div class="form-group">
							<div class="col-sm-offset-2 col-sm-10">
								<a class="btn btn-default ladda-button" data-spinner-color="#000" data-style="slide-left" href="<?=Url::site();?>">
									<span class="ladda-label">
										<?=Registry::translate("BTN_CANCEL");?>
									</span>
								</a>
								<button class="btn btn-primary ladda-button" data-style="slide-left">
									<span class="ladda-label">
										<?=$user->id ? Registry::translate("BTN_SAVE") : Registry::translate("BTN_CREATE");?>
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