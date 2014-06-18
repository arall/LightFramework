<?php defined('_EXE') or die('Restricted access'); ?>

<h1>
    <span class="glyphicon glyphicon-star"></span>
    <?=Registry::translate("VIEW_DEMO_TITLE");?>
    <small>
        <?=Registry::translate("VIEW_DEMO_SUBTITLE_LIST");?>
    </small>
</h1>

<div class="action">
    <a class="btn btn-primary ladda-label ladda-button" data-style="slide-left" href="<?=Url::site("demo/edit");?>">
        <span class="glyphicon glyphicon-plus"></span>
        <?=Registry::translate("BTN_NEW");?>
    </a>
</div>

<div class="main">
    <form method="post" action="<?=Url::site("demo")?>">
        <?=Helper::sortInputs();?>
        <?=Helper::paginationInputs();?>
        <?php if (count($results)) { ?>
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th><?=Helper::sortableLink("demo.id", Registry::translate("VIEW_DEMO_FIELDS_ID"));?></th>
                            <th><?=Helper::sortableLink("demo.string", Registry::translate("VIEW_DEMO_FIELDS_STRING"));?></th>
                            <th><?=Helper::sortableLink("user.userId", Registry::translate("VIEW_DEMO_FIELDS_USER"));?></th>
                            <th><?=Helper::sortableLink("demo.dateInsert", Registry::translate("VIEW_DEMO_FIELDS_DATEINSERT"));?></th>
                            <th><?=Helper::sortableLink("demo.dateUpdate", Registry::translate("VIEW_DEMO_FIELDS_DATEUPDATE"));?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($results as $result) { ?>
                            <?php $demo = $result['demo']; ?>
                            <?php $user = $result['user']; ?>
                            <tr>
                                <td><?=$demo->id;?></td>
                                <td>
                                    <a href="<?=Url::site("demo/edit/".$demo->id);?>">
                                        <?=Helper::sanitize($demo->string);?>
                                    </a>
                                </td>
                                <td>
                                    <span class="label label-default">
                                        <?=Helper::sanitize($user->username);?>
                                    </span>
                                </td>
                                <td><?=Helper::humanDate($demo->dateInsert);?></td>
                                <td><?=Helper::humanDate($demo->dateUpdate);?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
                <?php $controller->setData("pag", $pag); ?>
                <?=$controller->view("modules.pagination");?>
            </div>
        <?php } else { ?>
            <blockquote>
                <p><?=Registry::translate("VIEW_DEMO_LIST_NO_DATA");?></p>
            </blockquote>
        <?php } ?>
    </form>
</div>
