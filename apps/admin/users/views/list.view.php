<?php defined('_EXE') or die('Restricted access'); ?>

<?php
//Toolbar
Toolbar::addTitle(Language::translate("VIEW_USERS_TITLE"), "glyphicon-user", Language::translate("VIEW_USERS_SUBTITLE_LIST"));
//New button
Toolbar::addButton(
    array(
        "title" => Language::translate("BTN_NEW"),
        "app" => "users",
        "action" => "edit",
        "class" => "success",
        "spanClass" => "plus",
        "noAjax" => true,
    )
);
//Render
Toolbar::render();
?>

<div class="main">
    <form method="post" id="mainForm" name="mainForm" action="<?=Url::site()?>">
        <input type="hidden" name="router" id="router" value="admin">
        <input type="hidden" name="app" id="app" value="users">
        <input type="hidden" name="action" id="action" value="">
        <!-- Sortable Fields-->
        <?=Html::sortInputs();?>
        <!-- Pagination Fields -->
        <?=Html::paginationInputs();?>
        <!-- Filters -->
        <div class="row filters">
            <!-- Search -->
            <div class="col-sm-3 col-xs-6 filter">
                <?=HTML::search();?>
            </div>
            <!-- Status -->
            <div class="col-sm-3 col-xs-6 col-md-2 filter">
                <?php $userNull = new User(); ?>
                <?=HTML::select("statusId", $userNull->statuses, $_REQUEST["statusId"], array("class" => "change-submit"), array("id" => "-1", "display" => Language::translate("VIEW_USERS_FIELDS_STATUS"))); ?>
            </div>
        </div>
        <!-- Results -->
        <?php if (count($results)) { ?>
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th><?=Html::sortableLink("id", Language::translate("VIEW_USERS_FIELDS_ID"));?></th>
                            <th><?=Html::sortableLink("username", Language::translate("VIEW_USERS_FIELDS_USERNAME"));?></th>
                            <th><?=Html::sortableLink("statusId", Language::translate("VIEW_USERS_FIELDS_STATUS"));?></th>
                            <th><?=Html::sortableLink("roleId", Language::translate("VIEW_USERS_FIELDS_ROLE"));?></th>
                            <th><?=Html::sortableLink("email", Language::translate("VIEW_USERS_FIELDS_EMAIL"));?></th>
                            <th><?=Html::sortableLink("dateInsert", Language::translate("VIEW_USERS_FIELDS_DATEINSERT"));?></th>
                            <th><?=Html::sortableLink("dateUpdate", Language::translate("VIEW_USERS_FIELDS_DATEUPDATE"));?></th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($results as $user) { ?>
                            <tr>
                                <td><?=$user->id;?></a></td>
                                <td>
                                    <a href="<?=Url::site("admin/users/edit/".$user->id);?>">
                                        <?=Helper::sanitize($user->username);?>
                                    </a>
                                </td>
                                <td>
                                    <span class="label label-<?=$user->getStatusCssString();?>">
                                        <?=Language::translate($user->getStatusString());?>
                                    </span>
                                </td>
                                <td><?=Language::translate($user->getRoleString());?></td>
                                <td><?=Helper::sanitize($user->email);?></td>
                                <td><?=Helper::humanDate($user->dateInsert);?></td>
                                <td><?=Helper::humanDate($user->dateUpdate);?></td>
                                <td>
                                    <?=HTML::formLink("btn-xs btn-primary", "pencil", Url::site("admin/users/edit/".$user->id)); ?>
                                    <?=HTML::formLink("btn-xs btn-danger", "remove", Url::site("admin/users/delete/".$user->id), null, null, Language::translate("VIEW_USERS_CONFIRM_DELETE")); ?>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
                <?php $controller->setData("pag", $pag); ?>
                <?=$controller->view("modules.pagination");?>
            </div>
        <?php } else { ?>
            <blockquote>
                <p><?=Language::translate("VIEW_USERS_LIST_NO_DATA");?></p>
            </blockquote>
        <?php } ?>
    </form>
</div>
