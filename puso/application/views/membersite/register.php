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
		<h1>PUSO</h1><br/>
		<h5>Philippine Urban Solidarity Organization</h5>
		<h4>REGISTER</h4>

		<div class="checkbox">
			Already a member? <label><input type="checkbox" value="" id="yes">Yes</label>
		</div>
		<input type="text" placeholder="last name" id="txtLastName" class="form-control" /><br/>
		<input type="text" placeholder="middle name" id="txtMiddleName" class="form-control"/><br/>
		<input type="text" placeholder="first name" id="txtFirstName" class="form-control"/><br/>

		<button class="btn btn-success" id="btnRegister">Register</button>


	</div>
			
	<script type="text/javascript" src="<?php echo base_url('assets/js/register.js'); ?>"></script>
	<script>
		var link = "<?php echo site_url(); ?>";
	</script>
	</body>
