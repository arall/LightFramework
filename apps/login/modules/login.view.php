<?php defined('_EXE') or die('Restricted access'); ?>

<div class="row">
    <div class="col-xs-offset-3 col-xs-6">
        <div class="well">
            <fieldset>
                <legend>
                    <?=Language::translate("VIEW_LOGIN_LOGIN_TITLE");?>
                </legend>
                <?php $user = Registry::getUser(); ?>
                <?php if (!$user->id) { ?>
                    <form class="form-horizontal ajax" role="form" method="post">
                        <!-- Username -->
                        <div class="form-group">
                            <label for="login" class="col-sm-4 control-label">
                                <?=Language::translate("VIEW_LOGIN_LOGIN_FIELDS_USERNAME");?>
                            </label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="login" name="login" placeholder="<?=Language::translate("VIEW_LOGIN_LOGIN_FIELDS_USERNAME");?>">
                            </div>
                        </div>
                        <!-- Password -->
                        <div class="form-group">
                            <label for="password" class="col-sm-4 control-label">
                                <?=Language::translate("VIEW_LOGIN_LOGIN_FIELDS_PASSWORD");?>
                            </label>
                            <div class="col-sm-8">
                                <input type="password" class="form-control" id="password" name="password" placeholder="<?=Language::translate("VIEW_LOGIN_LOGIN_FIELDS_PASSWORD");?>">
                            </div>
                        </div>
                        <!-- Buttons -->
                        <div class="form-group">
                            <div class="col-sm-offset-4 col-sm-8">
                                <?=HTML::formButton("btn-primary", null, Language::translate("VIEW_LOGIN_LOGIN_TITLE"), array(
                                        "data-app" => "login",
                                        "data-action" => "doLogin"
                                    )
                                );?>
                                <a href="<?=Url::site("login/recovery");?>">
                                    <?=Language::translate("VIEW_LOGIN_LOGIN_RECOVERY");?>
                                </a>
                            </div>
                        </div>
                    </form>
                <?php } else { ?>
                    <h3>Hi there <?=$user->username?>! :)</h3>
                    <?=HTML::formLink("btn-primary", "off", Url::site("login/doLogout"), Language::translate("BTN_LOGOUT"));?>
                <?php } ?>
            </fieldset>
        </div>
    </div>
</div>
