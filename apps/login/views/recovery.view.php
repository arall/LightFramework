<?php defined('_EXE') or die('Restricted access'); ?>

<div class="well">
    <fieldset>
        <legend>
            <?=Language::translate("VIEW_LOGIN_RECOVERY_TITLE");?>
        </legend>
        <p>
            <?=Language::translate("VIEW_LOGIN_RECOVERY_INFO"); ?>
        </p>
        <form class="form-horizontal" role="form" method="post" name="loginForm" id="loginForm" action="<?=Url::site("login/sendRecovery")?>">
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
                    <button class="btn btn-primary ladda-button" data-style="slide-left">
                        <span class="glyphicon glyphicon-ok"></span>
                        <?=Language::translate("BTN_SUBMIT");?>
                    </button>
                </div>
            </div>
        </form>
    </fieldset>
</div>
