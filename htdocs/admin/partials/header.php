<?php require(dirname(__file__) . '/../../../private/orm.php');
require(dirname(__file__) . '/../../../private/auth.php');
open_database(); ?><!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<title>Feed the Meetup</title>
		<link rel="stylesheet" href="/admin/css/bootstrap.css" />
		<script src="/jquery.min.js"></script>
		<script src="/admin/js/bootstrap.min.js"></script>
	</head>
	<body>
		<nav class="navbar navbar-default" role="navigation">
			<div class="container-fluid">
				<!-- Brand and toggle get grouped for better mobile display -->
				<div class="navbar-header">
					<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
						<span class="sr-only">Toggle navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<a class="navbar-brand" href="/admin/">Feed the Meetup</a>
				</div>

				<!-- Collect the nav links, forms, and other content for toggling -->
				<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
					<ul class="nav navbar-nav">
						<li>
							<a href="/admin/users/">Users</a>
						</li>
						
						<li>
							<a href="/admin/menus/">Menus</a>
						</li>
						
						<li>
							<a href="/admin/quotations/">Quotations</a>
						</li>
						
						<li>
							<a href="/admin/eventtypes/">Event types</a>
						</li>
						
						<li>
							<a href="/admin/mealprices/">Meal prices</a>
						</li>
					</ul>
					
					<ul class="nav navbar-nav pull-right">
						<li>
							<a href="/admin/logout.php">Log out</a>
						</li>
					</ul>
				</div><!-- /.navbar-collapse -->
			</div><!-- /.container-fluid -->
		</nav>
		
		<div class="container">
			<?php if(isset($_GET['message'])) {
				$msg = '';
				$msg_type = 'info';
				
				switch($_GET['message']) {
					case 'inserted':
						$msg = 'The ' . (isset($_GET['model']) ? $_GET['model'] : 'item') . ' has been created.';
						$msg_type = 'success';
						break;
					case 'deleted':
						$msg = 'The ' . (isset($_GET['model']) ? $_GET['model'] : 'item') . ' has been deleted.';
						$msg_type = 'success';
				}
				
				if($msg) { ?>
					<div class="alert alert-<?php echo $msg_type; ?>"><?php echo $msg; ?></div>
				<?php }
			}