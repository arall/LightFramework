<?php defined('_EXE') or die('Restricted access'); ?>

<div class="well">
    <fieldset>
        <legend>
            <?=Language::translate("VIEW_LOGIN_RESTORE_TITLE");?>
        </legend>
        <form class="form-horizontal ajax" role="form" method="post" name="loginForm" id="loginForm" action="<?=Url::site("login/changePassword")?>">
            <input type="hidden" name="recoveryHash" value="<?=$user->recoveryHash?>">
            <!-- Password -->
            <div class="form-group">
                <label for="login" class="col-sm-2 control-label">
                    <?=Language::translate("VIEW_LOGIN_RESTORE_FIELDS_PASSWORD");?>
                </label>
                <div class="col-sm-10">
                    <input type="password" class="form-control" id="password" name="password">
                </div>
            </div>
            <!-- Repeat Password -->
            <div class="form-group">
                <label for="login" class="col-sm-2 control-label">
                    <?=Language::translate("VIEW_LOGIN_RESTORE_FIELDS_REPEAT_PASSWORD");?>
                </label>
                <div class="col-sm-10">
                    <input type="password" class="form-control" id="password2" name="password2">
                </div>
            </div>
            <!-- Buttons -->
            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                    <button class="btn btn-primary ladda-button" data-style="slide-left">
                        <span class="glyphicon glyphicon-ok"></span>
                        <?=Language::translate("BTN_SAVE");?>
                    </button>
                </div>
            </div>
        </form>
    </fieldset>
</div>
