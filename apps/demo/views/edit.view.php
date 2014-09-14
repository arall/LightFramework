<?php defined('_EXE') or die('Restricted access'); ?>

<?php
//Edit / New
if ($demo->id) {
    $subtitle = Language::translate("VIEW_DEMO_SUBTITLE_EDIT");
    $title = Language::translate("BTN_SAVE");
} else {
    $subtitle = Language::translate("VIEW_DEMO_SUBTITLE_NEW");
    $title =  Language::translate("BTN_NEW");
}
//Toolbar
Toolbar::addTitle(Language::translate("VIEW_DEMO_TITLE"), "glyphicon-user", $subtitle);
if ($user->id) {
    //Delete button
    Toolbar::addButton(
        array(
            "title" => Language::translate("BTN_DELETE"),
            "link" => Url::site("demo/delete/".$demo->id),
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
        "link" => Url::site("demo"),
        "class" => "primary",
        "spanClass" => "chevron-left",
    )
);
//Save button
Toolbar::addButton(
    array(
        "title" => $title,
        "app" => "demo",
        "action" => "save",
        "class" => "success",
        "spanClass" => "ok",
    )
);
//Render
Toolbar::render();
?>

<div class="main">
    <form method="post" id="mainForm" action="<?=Url::site();?>" class="form-horizontal ajax" role="form" autocomplete="off">
        <input type="hidden" name="app" id="app" value="demo">
        <input type="hidden" name="action" id="action" value="save">
        <input type="hidden" name="id" value="<?=$demo->id?>">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <?=Language::translate("VIEW_DEMO_PANEL_DEMO_TITLE");?>
                    </div>
                    <div class="panel-body">
                        <!-- String -->
                        <div class="form-group">
                            <label for="string" class="col-sm-2 control-label">
                                <?=Language::translate("VIEW_DEMO_FIELDS_STRING");?>
                            </label>
                            <div class="col-sm-10">
                                <input type="text" id="string" name="string" class="form-control" value="<?=Helper::sanitize($demo->string);?>">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
