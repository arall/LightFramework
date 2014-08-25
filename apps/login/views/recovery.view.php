<?php defined('_EXE') or die('Restricted access'); ?>

<div class="well">
    <fieldset>
        <legend>
            <?=Language::translate("VIEW_LOGIN_RECOVERY_TITLE");?>
        </legend>
        <p>
            <?=Language::translate("VIEW_LOGIN_RECOVERY_INFO"); ?>
        </p>
        <form class="form-horizontal" role="form" method="post">
            <!-- Email -->
            <div class="form-group">
                <label for="login" class="col-sm-1 control-label">
                    <?=Language::translate("VIEW_LOGIN_RECOVERY_FIELDS_EMAIL");?>
                </label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="email" name="email">
                </div>
            </div>
            <!-- Buttons -->
            <div class="form-group">
                <div class="col-sm-offset-1 col-sm-10">
                    <?=Html::formButton("btn-primary", "ok", Language::translate("BTN_SUBMIT"), array(
                            "data-app" => "login",
                            "data-action" => "sendRecovery",
                            "data-noAjax" => true,
                        )
                    );?>
                </div>
            </div>
        </form>
    </fieldset>
</div>
