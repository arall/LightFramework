<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="">
		<meta name="author" content="">
		<title>LightFramework</title>
		<!--css-->
		<!-- Bootstrap -->
		<link href="<?=Url::template("css/bootstrap.min.css");?>" media="screen" rel="stylesheet" type="text/css" />
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
		<script src="<?=Url::template("js/jquery-1.10.2.min.js");?>" type="text/javascript"></script>
		<!-- Bootstrap -->
		<script src="<?=Url::template("js/bootstrap.min.js");?>" type="text/javascript"></script>
		<!-- JQuery Forms Plugin -->
		<script src="<?=Url::template("js/jquery.forms.js");?>" type="text/javascript"></script>
		<!-- Framework JS -->
		<script src="<?=Url::template("js/init.js");?>" type="text/javascript"></script>
		<!--/javascript-->
		<link rel="shortcut icon" href="<?=Url::template("img/favicon.png")?>">
	</head>
	<body>
		<div id="wrap">
			<!--navbar-->
			<?php $user = Registry::getUser(); ?>
			<div class="navbar navbar-inverse navbar-static-top" role="navigation">
				<div class="container">
					<div class="navbar-header">
						<a class="navbar-brand" href="<?=Url::site()?>">Project name</a>
						<?php $url = Registry::getUrl(); ?>
						<?php $active[$url->app][$url->action] = "active"; ?>
						<ul class="nav navbar-nav">
							<?php if(!$user->id){ ?>
							<li class="<?=$active['login']['index']?>">
								<a href="<?=Url::site("login")?>">
									<?=Registry::translate("MENU_LOGIN")?>
								</a>
							</li>
							<li class="<?=$active['login']['register']?>">
								<a href="<?=Url::site("login/register")?>">
									<?=Registry::translate("MENU_REGISTER")?>
								</a>
							</li>
							<?php }else{ ?>
							<li class="<?=$active['demo']['index']?>">
								<a href="<?=Url::site("demo")?>">
									<?=Registry::translate("MENU_DEMO")?>
								</a>
							</li>
							<li class="">
								<a href="<?=Url::site("login/doLogout")?>">
									<?=Registry::translate("MENU_LOGOUT")?>
								</a>
							</li>
							<?php } ?>
						</ul>
					</div>
				</div>
			</div>
			<!--/navbar-->
			<!--mainContainer-->
			<div class="container">
				<!--alerts-->
				<?php $messages = Registry::getMessages(); ?>
				<div id="mensajes-sys">
				<?php if($messages){ ?>
					<?php foreach($messages as $message){ ?>
						<?php if($message->message){ ?>
							<div class="alert alert-<?=$message->type?>">
								<button type="button" class="close" data-dismiss="alert">&times;</button>
								<?=$message->message?>
							</div>
						<?php } ?>
					<?php } ?>
				<?php } ?>
				</div>
				<!--/alerts-->
				<!--content-->
				<?=$content?>
				<!--/content-->
	      	</div>
	      	<!--/mainContainer-->
	    </div>

	    <!-- Debugging Modals -->
        <?php $config = Registry::getConfig(); ?>
        <?php if($config->get("debug")){ ?>
            <?php $debug = Registry::getDebug(); ?>
            <!-- Current Queries Debug Modal -->
            <?php $controller->setData("debug", $debug); ?>
            <?php $controller->setData("debugModalId", "Current"); ?>
            <?=$controller->view("modules.debugModalQueries");?>
            <!-- Previous Queries Debug Modal -->
            <?php if($_SESSION['debug']['queries']){ ?>
                <?php $controller->setData("debug", $_SESSION['debug']); ?>
                <?php $controller->setData("debugModalId", "Last"); ?>
                <?=$controller->view("modules.debugModalQueries");?>
            <?php } ?>
            <!-- Session Debug Modal -->
            <?=$controller->view("modules.debugModalSession");?>
            <!-- Current Messages Debug Modal -->
            <?php $controller->setData("debug", $debug); ?>
            <?php $controller->setData("debugModalId", "Current"); ?>
            <?=$controller->view("modules.debugModalMessages");?>
            <!-- Ajax Messages Debug Modal -->
            <?php $controller->setData("debugModalId", "Ajax"); ?>
            <?=$controller->view("modules.debugModalMessages");?>
        <?php } ?>
        <!-- /Debugging Modals -->

      	<!-- Footer -->
      	<footer class="footer">
      		<?php if($config->get("debug")){ ?>
                <!-- Debugging Menu -->
                <?php $controller->setData("debug", $debug); ?>
                <?=$controller->view("modules.debugMenu");?>
                <!-- /Debugging Menu -->
            <?php } ?>
      	</footer>
      	<!-- /Footer -->
	</body>
</html>