<?php defined('_EXE') or die('Restricted access'); ?>

<?php
//Toolbar
Toolbar::addTitle(Language::translate("VIEW_DEMO_TITLE"), "glyphicon-user", Language::translate("VIEW_DEMO_SUBTITLE_LIST"));
//New button
Toolbar::addButton(
    array(
        "title" => Language::translate("BTN_NEW"),
        "app" => "demo",
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
        <input type="hidden" name="app" id="app" value="demo">
        <input type="hidden" name="action" id="action" value="">
        <!-- Sortable -->
        <?=Helper::sortInputs();?>
        <?=Helper::paginationInputs();?>
        <!-- Filters -->
        <div class="row filters">
            <!-- Search -->
            <div class="col-sm-3 col-xs-6 filter">
                <?=HTML::search();?>
            </div>
        </div>
        <!-- Results -->
        <?php if (count($results)) { ?>
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th><?=Helper::sortableLink("demo.id", Language::translate("VIEW_DEMO_FIELDS_ID"));?></th>
                            <th><?=Helper::sortableLink("demo.string", Language::translate("VIEW_DEMO_FIELDS_STRING"));?></th>
                            <th><?=Helper::sortableLink("user.userId", Language::translate("VIEW_DEMO_FIELDS_USER"));?></th>
                            <th><?=Helper::sortableLink("demo.dateInsert", Language::translate("VIEW_DEMO_FIELDS_DATEINSERT"));?></th>
                            <th><?=Helper::sortableLink("demo.dateUpdate", Language::translate("VIEW_DEMO_FIELDS_DATEUPDATE"));?></th>
                            <th></th>
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
                                <td>
                                    <?=HTML::formLink("btn-xs btn-primary", "pencil", Url::site("demo/edit/".$demo->id)); ?>
                                    <?=HTML::formLink("btn-xs btn-danger", "remove", Url::site("demo/delete/".$demo->id), null, null, Language::translate("VIEW_DEMO_CONFIRM_DELETE")); ?>
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
                <p><?=Language::translate("VIEW_DEMO_LIST_NO_DATA");?></p>
            </blockquote>
        <?php } ?>
    </form>
</div>
