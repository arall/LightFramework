<?php defined('_EXE') or die('Restricted access'); ?>

<h1>
    <span class="glyphicon glyphicon-user"></span>
    <?=Registry::translate("VIEW_USERS_TITLE");?>
    <small>
        <?=Registry::translate("VIEW_USERS_SUBTITLE_LIST");?>
    </small>
</h1>

<div class="action">
    <a class="btn btn-primary ladda-button" href="<?=Url::site("admin/users/edit");?>" data-style="slide-left">
        <span class="glyphicon glyphicon-plus"></span>
        <?=Registry::translate("BTN_NEW");?>
    </a>
</div>

<div class="main">
    <form method="post" action="<?=Url::site("")?>">
        <input type="hidden" name="router" id="router" value="admin">
        <input type="hidden" name="app" id="app" value="users">
        <?=Helper::sortInputs();?>
        <?=Helper::paginationInputs();?>
        <?php if (count($results)) { ?>
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th><?=Helper::sortableLink("id", Registry::translate("VIEW_USERS_FIELDS_ID"));?></th>
                            <th><?=Helper::sortableLink("username", Registry::translate("VIEW_USERS_FIELDS_USERNAME"));?></th>
                            <th><?=Helper::sortableLink("statusId", Registry::translate("VIEW_USERS_FIELDS_STATUS"));?></th>
                            <th><?=Helper::sortableLink("roleId", Registry::translate("VIEW_USERS_FIELDS_ROLE"));?></th>
                            <th><?=Helper::sortableLink("email", Registry::translate("VIEW_USERS_FIELDS_EMAIL"));?></th>
                            <th><?=Helper::sortableLink("dateInsert", Registry::translate("VIEW_USERS_FIELDS_DATEINSERT"));?></th>
                            <th><?=Helper::sortableLink("dateUpdate", Registry::translate("VIEW_USERS_FIELDS_DATEUPDATE"));?></th>
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
                                        <?=Registry::translate($user->getStatusString());?>
                                    </span>
                                </td>
                                <td><?=Registry::translate($user->getRoleString());?></td>
                                <td><?=Helper::sanitize($user->email);?></td>
                                <td><?=Helper::humanDate($user->dateInsert);?></td>
                                <td><?=Helper::humanDate($user->dateUpdate);?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
                <?php $controller->setData("pag", $pag); ?>
                <?=$controller->view("modules.pagination");?>
            </div>
        <?php } else { ?>
            <blockquote>
                <p><?=Registry::translate("VIEW_USERS_LIST_NO_DATA");?></p>
            </blockquote>
        <?php } ?>
    </form>
</div>
