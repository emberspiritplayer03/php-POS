<!DOCTYPE html>
<html lang="en">

	<head>
		<meta charset="utf-8">
		<title>Home</title>
		<!-- Bootstrap -->
		<link href="<?php echo base_url('assets/css/bootstrap.min.css');?>" rel="stylesheet">
		<!-- Custom CSS -->
		<link href="<?php echo base_url('assets/css/custom.css');?>" rel="stylesheet">
		<link href="<?php echo base_url('assets/font-awesome/css/font-awesome.min.css');?>" rel="stylesheet">
		<link href='https://fonts.googleapis.com/css?family=Lobster' rel='stylesheet' type='text/css'>
		<link href='https://fonts.googleapis.com/css?family=Noto+Sans' rel='stylesheet' type='text/css'>
		<link href='https://fonts.googleapis.com/css?family=Russo+One' rel='stylesheet' type='text/css'>
		<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
		<script src="<?php echo base_url('assets/js/jquery-1.11.1.min.js') ?>"></script>
		<!-- Include all compiled plugins (below), or include individual files as needed -->
		<script src="<?php echo base_url('assets/js/bootstrap.min.js');?>"></script>
	</head>

	<body class="login-page">
		<div class="main-header">
			<img class="img-rounded" src="<?php echo base_url('assets/img/new.png');?>" alt="logo" id="logo">
			<div style="background-color: rgba(0, 0, 0, 0.1);; height: 70px; margin-top: -70px;">
			</div>
			<center style="margin-top: -65px; font-size: 40px; color:white">PHILIPPINE URBAN SOLIDARITY ORGANIZATION</center>

			
		</div>
		<header>
			<nav class="navbar navbar-inverse nav">
				<div class="container">

					<ul class="nav navbar-nav navbar-left">
						<li class="<?php echo ($page == 'userhome') ? 'active' : ''; ?>"><a href="<?php echo site_url('UserHome'); ?>"><i class="fa fa-home fa-lg"></i> Home </a></li>
						<li class="<?php echo ($page == 'mytrans') ? 'active' : ''; ?>"><a href="<?php echo site_url('membersite/MyTransactions'); ?>"><i class="fa fa-money fa-lg"></i> My Transactions </a></li>
						<li class="<?php echo ($page == 'myloans') ? 'active' : ''; ?>"><a href="<?php echo site_url('membersite/MyLoans'); ?>" ><i class="fa fa-book fa-lg"></i> My Current Loan </a></li>
						<li class="<?php echo ($page == 'myproducts') ? 'active' : ''; ?>"><a href="<?php echo site_url('membersite/MyProducts'); ?>"><i class="fa fa-product-hunt fa-lg"></i> Products </a></li>
					</ul>

					<ul class="nav navbar-nav navbar-right">
						<li><a href="<?php echo site_url('UserHome'); ?>"><i class="fa fa-user fa-lg"></i> Hi <?php echo $session_array['first_name']; ?>!</a></li>
						<li><a href="<?php echo site_url('logout'); ?>"><i class="fa fa-sign-out fa-lg"></i> Logout </a></li>
					</ul>
				</div>
			</nav>
		</header>

		<body>

		</body>