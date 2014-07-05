<?php defined('_EXE') or die('Restricted access'); ?>

<!--alerts-->
<?php $messages = Registry::getMessages(); ?>
<div id="mensajes-sys">
<?php if ($messages) { ?>
    <?php foreach ($messages as $message) { ?>
        <?php if ($message->message) { ?>
            <div class="alert alert-<?=$message->type?>">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <?=$message->message?>
            </div>
        <?php } ?>
    <?php } ?>
<?php } ?>
</div>
<!--/alerts-->
