<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<!DOCTYPE html>
<html lang="en">

	<head>
		<meta charset="utf-8">
		<title>Welcome to CodeIgniter</title>
		<!-- Bootstrap -->
		<link href="<?php echo base_url('assets/css/bootstrap.min.css');?>" rel="stylesheet">
		<!-- Custom CSS -->
		<link href="<?php echo base_url('assets/css/custom.css');?>" rel="stylesheet">
		<link href="<?php echo base_url('assets/font-awesome/css/font-awesome.min.css');?>" rel="stylesheet">
		<link href='https://fonts.googleapis.com/css?family=Lobster' rel='stylesheet' type='text/css'>
		<link href='https://fonts.googleapis.com/css?family=Noto+Sans' rel='stylesheet' type='text/css'>
		<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
		<script src="<?php echo base_url('assets/js/jquery-1.11.1.min.js') ?>"></script>
		<!-- Include all compiled plugins (below), or include individual files as needed -->
		<script src="<?php echo base_url('assets/js/bootstrap.min.js');?>"></script>
	</head>

	<body class="login-page">
		<header>
		
		</header>

	<div class="container">
	<br><br>
		
		<div class="row">
			<div class="col-md-4 as">
			</div>
			<div class="col-md-4 as">
				<div class="row">
					<div class="col-md-12 loginpanel">

						<div class="innerbox">
							<center><span><i class="fa fa-user fa-5x"></i></span></center>
							<br>
							<h5>Username: </h5>
							<center><input type="text" id="txtUsername" class="form-control login-text"></center>
							<h5>Password: </h5>
							<center><input type="password" id="txtPassword" class="form-control login-text"/><br/></center>
							<div class="message hide"></div>
							<button class="btn btn-primary" id="btnLogin">LOGIN</button>
							
						</div>

					</div>
				</div>
			</div>
			<div class="col-md-4">
			</div>
		</div>

		


	</div>
			
	<script type="text/javascript" src="<?php echo base_url('assets/js/login.js'); ?>"></script>
	<script>
		var link = "<?php echo site_url(); ?>";
	</script>	
	</body>