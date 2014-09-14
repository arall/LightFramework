<?php defined('_EXE') or die('Restricted access'); ?>

<?php $currentUser = Registry::getUser();?>

<?php
//Edit / New
if ($user->id) {
    $subtitle = Language::translate("VIEW_USERS_SUBTITLE_EDIT");
    $title = Language::translate("BTN_SAVE");
} else {
    $subtitle = Language::translate("VIEW_USERS_SUBTITLE_NEW");
    $title =  Language::translate("BTN_NEW");
}
//Toolbar
Toolbar::addTitle(Language::translate("VIEW_USERS_TITLE"), "glyphicon-user", $subtitle);
if ($user->id) {
    //Delete button
    Toolbar::addButton(
        array(
            "title" => Language::translate("BTN_DELETE"),
            "link" => Url::site("admin/users/delete/".$user->id),
            "class" => "danger",
            "spanClass" => "remove",
            "confirmation" => Language::translate("VIEW_USERS_CONFIRM_DELETE"),
        )
    );
}
//Cancel button
Toolbar::addButton(
    array(
        "title" => Language::translate("BTN_CANCEL"),
        "link" => Url::site("admin/users/"),
        "class" => "primary",
        "spanClass" => "chevron-left",
    )
);
//Save button
Toolbar::addButton(
    array(
        "title" => $title,
        "app" => "users",
        "action" => "save",
        "class" => "success",
        "spanClass" => "ok",
    )
);
//Render
Toolbar::render();
?>

<div class="main">
    <form method="post" name="mainForm" id="mainForm" action="<?=Url::site();?>" class="form-horizontal ajax" role="form">
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
                                <input type="hidden" name="statusId" value="0">
                                <input type="checkbox" class="switch" name="statusId" id="statusId" value="1" <?php if($user->statusId) echo "checked";?>>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">
                                <?=Language::translate("VIEW_USERS_FIELDS_ROLE");?>
                            </label>
                            <div class="col-sm-10">
                                <?=Html::select("roleId", $user->roles, $user->roleId, array("id" => "roleId")); ?>
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
                                <?=Html::select("language", Language::getLanguages(), $user->language, array("id" => "language")); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
