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
        <!-- Custom CSS -->
        <link href="<?=Url::template("css/custom.css");?>" media="screen" rel="stylesheet" type="text/css" />
        <!--/javascript-->
        <link rel="shortcut icon" href="<?=Url::template("img/favicon.png")?>">
    </head>
    <body class="error">
        <div class="container">
            <div class="row">
                <div class="span12">
                    <div class="jumbotron error-div">
                        <h1>Error! :(</h1>
                        <p>
                            <!--content-->
                            <?=$content?>
                            <!--/content-->
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
