<?php defined('_EXE') or die('Restricted access'); ?>

<?php $user = Registry::getUser(); ?>
<?php $config = Registry::getConfig(); ?>

<div class="navbar navbar-default navbar-inverse navbar-fixed-top" role="navigation">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand logo" href="<?=Url::site();?>">
                <?=$config->get("title");?>
            </a>
        </div>
        <div class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
                <?php $url = Registry::getUrl(); ?>
                <?php $active[$url->app][$url->action] = "active"; ?>
                <?php if(!$user->id){ ?>
                    <li class="<?=$active['login']['index']?>">
                        <a href="<?=Url::site("login")?>">  
                            <span class="glyphicon glyphicon-log-in"></span>
                            <?=Registry::translate("MENU_LOGIN")?>
                        </a>
                    </li>
                    <li class="<?=$active['login']['register']?>">
                        <a href="<?=Url::site("login/register")?>">
                            <span class="glyphicon glyphicon-plus"></span>
                            <?=Registry::translate("MENU_REGISTER")?>
                        </a>
                    </li>
                <?php }else{ ?>
                    <li class="<?=$active['demo']['index']?>">
                        <a href="<?=Url::site("demo")?>">
                            <span class="glyphicon glyphicon-star"></span>
                            <?=Registry::translate("MENU_DEMO")?>
                        </a>
                    </li>
                    <li class="<?=$active['account']['index']?>">
                        <a href="<?=Url::site("account")?>">
                            <span class="glyphicon glyphicon-wrench"></span>
                            <?=Registry::translate("MENU_ACCOUNT")?>
                        </a>
                    </li>
                    <?php if($user->roleId==2){ ?>
                        <li class="<?=$active['users']['index']?>">
                            <a href="<?=Url::site("users")?>">
                                <span class="glyphicon glyphicon-user"></span>
                                <?=Registry::translate("MENU_USERS")?>
                            </a>
                        </li>
                    <?php } ?>
                <?php } ?>
            </ul>
            <?php if($user->id){ ?>
                <ul class="nav navbar-nav navbar-right">
                    <?php $languages = Language::getLanguages(); ?>
                    <?php if(count($languages)){ ?>
                        <li>
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <?=Registry::translate("MENU_LANGUAGE")?>
                                <b class="caret"></b>
                            </a>
                            <ul class="dropdown-menu">
                                <?php foreach($languages as $lang){ ?>
                                    <li>
                                        <a href="<?=Url::site("?lang=".$lang);?>">
                                            <?=Registry::translate(strtoupper($lang));?>
                                        </a>
                                    </li>
                                <?php } ?>
                            </ul>
                        </li>
                    <?php } ?>
                    <li>
                        <a href="<?=Url::site("login/doLogout");?>">
                            <span class="glyphicon glyphicon-off"></span>
                            <?=Registry::translate("MENU_LOGOUT")?>
                            <small><i>(<?=$user->username;?>)</i></small>
                        </a>
                    </li>
                </ul>
            <?php } ?>
        </div>
    </div>
</div>