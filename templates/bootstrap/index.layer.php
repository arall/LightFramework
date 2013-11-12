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
	    <link rel="shortcut icon" href="<?=Url::template("img/favicon.png")?>">
	</head>
	<body>
		<!--navbar-->
		<?php $user = Registry::getUser(); ?>
		<div class="navbar navbar-inverse navbar-static-top" role="navigation">
			<div class="container">
				<div class="navbar-header">
					<a class="navbar-brand" href="<?=Url::site()?>">Project name</a>
					<?php $url = Registry::getUrl(); ?>
					<?php $active[$url->app][$url->action] = "active"; ?>
					<ul class="nav navbar-nav">
						<li class="<?=$active['demo']['index']?>">
							<a href="<?=Url::site()?>">Home</a>
						</li>
						<?php if(!$user->id){ ?>
						<li class="<?=$active['login']['index']?>">
							<a href="<?=Url::site("login")?>">Login</a>
						</li>
						<li class="<?=$active['login']['register']?>">
							<a href="<?=Url::site("login/register")?>">Register</a>
						</li>
						<?php }else{ ?>
						<li class="">
							<a href="<?=Url::site("login/doLogout")?>">Logout</a>
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
	</body>
</html>