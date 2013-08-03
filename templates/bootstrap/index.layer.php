<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="">
		<meta name="author" content="">
		<title>LightFramework</title>
		<!--css-->
		<link href="<?=Url::template("css/style.css");?>" media="screen" rel="stylesheet" type="text/css" />
		<link href="<?=Url::template("css/bootstrap.min.css");?>" media="screen" rel="stylesheet" type="text/css" />
		<link href="<?=Url::template("css/bootstrap-responsive.min.css");?>" media="screen" rel="stylesheet" type="text/css" />
		<link href="<?=Url::template("css/custom.css");?>" media="screen" rel="stylesheet" type="text/css" />
		<!--/css-->
		<!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
	    <!--[if lt IE 9]>
	    	<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	    <![endif]-->
	    <link rel="shortcut icon" href="<?=Url::template("img/favicon.png")?>">
	</head>
	<body>
		<!--mainContainer-->
		<div class="container-fluid">
			<div class="row-fluid">
				<div class="span9">
					<!--alerts-->
					<?php $messages = Registry::getMessages(); ?>
			    	<div id="mensajes-sys">
			    		<?php if($messages){ ?>
				    		<?php foreach($messages as $message){ ?>
				    			<?php if($message->message){ ?>
									<div class="alert alert-<?=$message->type()?>">
										<button type="button" class="close" data-dismiss="alert">&times;</button>
										<?=$message->message?>
									</div>
								<?php } ?>
							<?php } ?>
						<?php } ?>
					</div>
					<!--/alerts-->
					<div class="hero-unit">
						<!--content-->
						<?=$content?>
						<!--/content-->
					</div>
				</div>
			</div>
			<hr>
			<!--footer-->
			<footer>
				<p>&copy; Company <?=date("Y")?></p>
			</footer>
			<!--/footer-->
			
      	</div>
      	<!--/mainContainer-->
		<!--javascript-->
		<script src="<?=Url::template("js/jquery-1.9.1.min.js");?>" type="text/javascript"></script>
		<script src="<?=Url::template("js/bootstrap.min.js");?>" type="text/javascript"></script>
		<script src="<?=Url::template("js/jquery.forms.js");?>" type="text/javascript"></script>
		<script src="<?=Url::template("js/init.js");?>" type="text/javascript"></script>
		<!--/javascript-->
	</body>
</html>