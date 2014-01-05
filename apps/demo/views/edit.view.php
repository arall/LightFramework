<?php defined('_EXE') or die('Restricted access'); ?>

<h1>
	<?=Registry::translate("VIEW_DEMO_TITLE");?> 
	<small>
		<?=$demo->id ? Registry::translate("VIEW_DEMO_SUBTITLE_EDIT") : Registry::translate("VIEW_DEMO_SUBTITLE_NEW");?>
	</small>
</h1>

<div class="main">
	<form method="post" action="<?=Url::site();?>" class="form-horizontal ajax" role="form" autocomplete="off">
		<input type="hidden" name="app" value="demo">
		<input type="hidden" name="action" value="save">
		<input type="hidden" name="id" value="<?=$demo->id?>">
		<div class="row">
			<div class="col-md-12">
				<div class="panel panel-default">
					<div class="panel-heading">
						<?=Registry::translate("VIEW_DEMO_PANEL_DEMO_TITLE");?> 
					</div>
				  	<div class="panel-body">
				    	<div class="form-group">
							<label for="string" class="col-sm-2 control-label">
								<?=Registry::translate("VIEW_DEMO_FIELDS_STRING");?> 
							</label>
							<div class="col-sm-10">
								<input type="text" id="string" name="string" class="form-control" value="<?=Helper::sanitize($demo->string);?>" placeholder="<?=Registry::translate("VIEW_DEMO_FIELDS_STRING_PLACEHOLDER")?>">
							</div>
						</div>
						<div class="form-group">
							<div class="col-sm-offset-2 col-sm-10">
								<a class="btn btn-default" href="<?=Url::site("demo");?>">
									<?=Registry::translate("VIEW_BTN_CANCEL");?> 
								</a>
								<button class="btn btn-primary">
									<?=$demo->id ? Registry::translate("VIEW_BTN_SAVE") : Registry::translate("VIEW_BTN_CREATE");?>
								</button>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</form>
</div>