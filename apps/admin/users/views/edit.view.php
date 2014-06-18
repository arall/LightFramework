<?php defined('_EXE') or die('Restricted access'); ?>

<?php $currentUser = Registry::getUser();?>

<h1>
    <span class="glyphicon glyphicon-user"></span>
    <?=Language::translate("VIEW_USERS_TITLE");?>
    <small>
        <?=$user->id ? Language::translate("VIEW_USERS_SUBTITLE_EDIT") : Language::translate("VIEW_USERS_SUBTITLE_NEW");?>
    </small>
</h1>

<div class="main">
    <form method="post" name="mainForm" id="mainForm" action="<?=Url::site();?>" class="form-horizontal ajax" role="form" autocomplete="off">
        <input type="hidden" name="router" id="router" value="admin">
        <input type="hidden" name="app" id="app" value="users">
        <input type="hidden" name="action" id="action" value="save">
        <input type="hidden" name="id" value="<?=$user->id?>">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <?=Language::translate("VIEW_USERS_PANEL_USER_TITLE");?>
                    </div>
                    <div class="panel-body">
                        <div class="form-group">
                            <label class="col-sm-2 control-label">
                                <?=Language::translate("VIEW_USERS_FIELDS_STATUS");?>
                            </label>
                            <div class="col-sm-10">
                                <input type="checkbox" class="switch" name="statusId" id="statusId" value="1" <?php if($user->statusId) echo "checked";?>>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">
                                <?=Language::translate("VIEW_USERS_FIELDS_ROLE");?>
                            </label>
                            <div class="col-sm-10">
                                <select class="form-control" name="roleId" id="roleId">
                                    <?php $s = array(); ?>
                                    <?php $s[$user->roleId] = "selected"; ?>
                                    <?php foreach ($user->roles as $roleId=>$roleString) { ?>
                                        <?php if ($currentUser->roleId>$roleId || $currentUser->roleId>=2) { ?>
                                            <option value="<?=$roleId?>" <?=$s[$roleId]?>>
                                                <?=Language::translate($roleString);?>
                                            </option>
                                        <?php } ?>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">
                                <?=Language::translate("VIEW_USERS_FIELDS_USERNAME");?>
                            </label>
                            <div class="col-sm-10">
                                <input type="text" id="username" name="username" class="form-control" value="<?=Helper::sanitize($user->username);?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">
                                <?=Language::translate("VIEW_USERS_FIELDS_EMAIL");?>
                            </label>
                            <div class="col-sm-10">
                                <input type="text" id="email" name="email" class="form-control" value="<?=Helper::sanitize($user->email);?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">
                                <?=Language::translate("VIEW_USERS_FIELDS_PASSWORD");?>
                            </label>
                            <div class="col-sm-10">
                                <input type="password" id="password" name="password" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">
                                <?=Language::translate("VIEW_USERS_FIELDS_LANGUAGE");?>
                            </label>
                            <div class="col-sm-10">
                                <select class="form-control" name="language" id="language">
                                    <?php $languages = Language::getLanguages(); ?>
                                    <?php $s = array(); ?>
                                    <?php $s[$user->language] = "selected"; ?>
                                    <?php foreach ($languages as $lang) { ?>
                                        <option value="<?=$language?>" <?=$s[$lang]?>>
                                            <?=Language::translate($lang);?>
                                        </option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <?php if ($user->id) { ?>
                                    <button class="btn btn-danger ladda-button delete" data-style="slide-left" confirm="<?=Language::translate("VIEW_USERS_CONFIRM_DELETE")?>">
                                        <span class="glyphicon glyphicon-remove"></span>
                                        <?=Language::translate("BTN_DELETE");?>
                                    </button>
                                <?php } ?>
                                <a class="btn btn-primary ladda-button" data-style="slide-left" href="<?=Url::site("admin/users");?>">
                                    <span class="glyphicon glyphicon-chevron-left"></span>
                                    <?=Language::translate("BTN_CANCEL");?>
                                </a>
                                <button class="btn btn-success ladda-button" data-style="slide-left">
                                    <span class="glyphicon glyphicon-ok"></span>
                                    <?=$user->id ? Language::translate("BTN_SAVE") : Language::translate("BTN_NEW");?>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
