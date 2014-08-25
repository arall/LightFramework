<?php defined('_EXE') or die('Restricted access'); ?>

<?php $user = Registry::getUser();?>

<?php
//Toolbar
Toolbar::addTitle(Language::translate("VIEW_ACCOUNT_TITLE"), "glyphicon-user", Language::translate("VIEW_ACCOUNT_SUBTITLE_EDIT"));
//Cancel button
Toolbar::addButton(
    array(
        "title" => Language::translate("BTN_CANCEL"),
        "link" => Url::site(),
        "class" => "primary",
        "spanClass" => "chevron-left",
        "noAjax" => true,
    )
);
//Save button
Toolbar::addButton(
    array(
        "title" => Language::translate("BTN_SAVE"),
        "app" => "account",
        "action" => "save",
        "class" => "success",
        "spanClass" => "ok",
    )
);
//Render
Toolbar::render();
?>

<div class="main">
    <form method="post" id="mainForm" name="mainForm" action="<?=Url::site()?>"  class="form-horizontal ajax" role="form">
        <input type="hidden" name="app" id="app" value="account">
        <input type="hidden" name="action" id="action" value="save">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <?=Language::translate("VIEW_ACCOUNT_PANEL_ACCOUNT_TITLE");?>
                    </div>
                    <div class="panel-body">
                        <!-- Username -->
                        <div class="form-group">
                            <label class="col-sm-2 control-label">
                                <?=Language::translate("VIEW_ACCOUNT_FIELDS_USERNAME");?>
                            </label>
                            <div class="col-sm-10">
                                <input type="text" id="username" name="username" class="form-control" value="<?=Helper::sanitize($user->username);?>">
                            </div>
                        </div>
                        <!-- Email -->
                        <div class="form-group">
                            <label class="col-sm-2 control-label">
                                <?=Language::translate("VIEW_ACCOUNT_FIELDS_EMAIL");?>
                            </label>
                            <div class="col-sm-10">
                                <input type="text" id="email" name="email" class="form-control" value="<?=Helper::sanitize($user->email);?>">
                            </div>
                        </div>
                        <!-- Password -->
                        <div class="form-group">
                            <label class="col-sm-2 control-label">
                                <?=Language::translate("VIEW_ACCOUNT_FIELDS_PASSWORD");?>
                            </label>
                            <div class="col-sm-10">
                                <input type="password" id="password" name="password" class="form-control">
                            </div>
                        </div>
                        <!-- Language -->
                        <div class="form-group">
                            <label class="col-sm-2 control-label">
                                <?=Language::translate("VIEW_ACCOUNT_FIELDS_LANGUAGE");?>
                            </label>
                            <div class="col-sm-10">
                                <?=Html::select("language", Language::getLanguages(), $user->language, array("id" => "language")); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
