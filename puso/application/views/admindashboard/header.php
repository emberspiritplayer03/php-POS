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

	<body>

		<header>
			<nav class="navbar navbar-inverse nav">
				<div class="container-fluid">
				
					<ul class="nav navbar-nav navbar-left">
						<li class="<?php echo ($page == 'home') ? 'active' : ''; ?>"><a href="<?php echo site_url('welcome'); ?>"><i class="fa fa-home fa-lg"></i> Home </a></li>
						<li class="<?php echo ($page == 'transactions') ? 'active' : ''; ?>"><a href="<?php echo site_url('transactions'); ?>"><i class="fa fa-money fa-lg"></i> Transactions </a></li>
						<li class="<?php echo ($page == 'members') ? 'active' : ''; ?>"><a href="<?php echo site_url('members');?>"><i class="fa fa-user fa-lg"></i> Members </a></li>
						<li class="<?php echo ($page == 'loans') ? 'active' : ''; ?>"><a href="<?php echo site_url('loans');?>"><i class="fa fa-book fa-lg"></i> Loans </a></li>
						<li class="<?php echo ($page == 'products') ? 'active' : ''; ?>"><a href="<?php echo site_url('products');?>"><i class="fa fa-product-hunt fa-lg"></i> Products </a></li>
					</ul>
					<ul class="nav navbar-nav navbar-right">
						<li class="<?php echo ($page == 'admins') ? 'active' : ''; ?>"><a href="<?php echo site_url('admins'); ?>"><i class="fa fa-user fa-lg"></i> Hi <?php echo $session_array['first_name']; ?>!</a></li>
						<li><a href="<?php echo site_url('logout'); ?>"><i class="fa fa-sign-out fa-lg"></i> Logout </a></li>
					</ul>
				</div>
			</nav>
		</header>

			

	</body>

