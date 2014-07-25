<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="">
        <?php $config = Registry::getConfig(); ?>
        <title><?=$config->get("title");?></title>
        <!--css-->
        <!-- Bootstrap -->
        <link href="<?=Url::template("css/bootstrap.min.css");?>" media="screen" rel="stylesheet" type="text/css" />
        <!-- Bootstrap Switch Plugin -->
        <link href="<?=Url::template("css/bootstrap-switch.min.css");?>" media="screen" rel="stylesheet" type="text/css" />
        <!-- Bootstrap Ladda Plugin -->
        <link href="<?=Url::template("css/ladda-themeless.min.css");?>" media="screen" rel="stylesheet" type="text/css" />
        <!-- Custom CSS -->
        <link href="<?=Url::template("css/custom.css");?>" media="screen" rel="stylesheet" type="text/css" />
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
          <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->
        <!--/css-->
        <!--javascript-->
        <!-- JQuery -->
        <script src="<?=Url::template("js/jquery-2.1.0.min.js");?>" type="text/javascript"></script>
        <!-- Bootstrap -->
        <script src="<?=Url::template("js/bootstrap.min.js");?>" type="text/javascript"></script>
        <!-- JQuery Forms Plugin -->
        <script src="<?=Url::template("js/jquery.forms.js");?>" type="text/javascript"></script>
        <!-- Bootstrap Switch Plugin -->
        <script src="<?=Url::template("js/bootstrap-switch.min.js");?>" type="text/javascript"></script>
        <!-- Bootstrap Ladda Plugin -->
        <script src="<?=Url::template("js/spin.min.js");?>" type="text/javascript"></script>
        <script src="<?=Url::template("js/ladda.min.js");?>" type="text/javascript"></script>
        <!-- Framework JS -->
        <script src="<?=Url::template("js/lightFramework.js");?>" type="text/javascript"></script>
        <script src="<?=Url::template("js/init.js");?>" type="text/javascript"></script>
        <!--/javascript-->
        <link rel="shortcut icon" href="<?=Url::template("img/favicon.png")?>">
    </head>
    <body>
        <div id="wrap">

            <!-- topMenu -->
            <?=$controller->view("modules.topMenu");?>
            <!--/topMenu-->

            <!--mainContainer-->
            <div class="container">

                <!--messages-->
                <?=$controller->view("modules.messages");?>
                <!--/messages-->

                <!--content-->
                <?=$content?>
                <!--/content-->

              </div>
              <!--/mainContainer-->

        </div>

        <!-- Debug -->
        <?=$controller->view("modules.debug.menu");?>
        <!-- /Debug -->

    </body>
</html>
