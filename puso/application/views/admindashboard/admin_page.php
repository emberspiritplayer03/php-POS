<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php include_once('header.php'); ?>

<div class="container">

	<div class="row">
		<div class="col-md-8" style="height: 400px; padding:10px;">
			
			<div class="panel panel-default" style="border-radius: 0px!important; width: 100%; padding-bottom: 50px;">
				<div class="panel-heading">List of Administrators</div>

				<div class="panel-body">
					<div class="row body-panel" style="height: 20px;">
						<div class="col-md-12 add-area">
							<a id="addBtn" href="#" data-toggle="modal" data-target="#addAdminModal" class="btn btn-success"><i class="fa fa-user-plus fa-2x" aria-hidden="true"></i> ADD ADMIN</a>
							<!-- <a id="addBtn" href="#" data-toggle="modal" data-target="#addModal" class="btn btn-primary"><i class="fa fa-edit fa-2x" aria-hidden="true"></i> MODIFY MY ACCOUNT</a> -->
						</div>
					</div>
				</div>
				<!-- Table -->	
				<table class="table table-bordered" id="memberTable" style="width: 96%; margin-left: 15px;" >
					<thead>
						<tr>
							<th>#</th>
							<th>Username</th>
							<th>Last Name</th>
							<th>Middle Name</th>
							<th>First Name</th>
							<th>Gender</th>
							<th><center>Actions</center></th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($admins as $admin): ?>
							<tr>
								<td><?php echo $admin['user_id']; ?></td>
								<td><?php echo $admin['username']; ?></td>
								<td><?php echo $admin['last_name']; ?></td>
								<td><?php echo $admin['middle_name']; ?></td>
								<td><?php echo $admin['first_name']; ?></td>
								<td><?php echo $admin['gender']; ?></td>
								<td><center>
								<a href="#" class='btnEdit' data-id="<?php echo $admin['user_id']; ?>"><i class="fa fa-pencil-square-o fa-lg" aria-hidden="true" style="color:#000000"></i></a>&nbsp;
								<a href="#" class='btnDelete' data-id="<?php echo $admin['user_id']; ?>"><i class="fa fa-trash fa-lg" aria-hidden="true" style="color: #000000;"></i> </a></center>
								</td> 
							</tr>
						<?php endforeach; ?>
					</tbody>
				</table>

			</div>
		</div>

		<div class="col-md-4 bg-success" style="height: auto; margin-top: 10px; padding:20px;">  
			<h3>Generate Reports</h3>
			<h5>Reports with be generated in a Micorosoft Excel format document.</h5>
			<br>
			<div class="row">
				<div class="col-md-6">
					<a href="#" style="width: 100%;" class="btn btn-primary">Loans Report</a>
				</div>
				<div class="col-md-6">
					<a href="#" style="width: 100%;" class="btn btn-primary">Transactions Report</a>
				</div>
			</div>
			<br>
			<div class="row">
				<div class="col-md-6">
					<a href="#" style="width: 100%;" class="btn btn-success">List Of Member</a>
				</div>
				<div class="col-md-6">
					<a href="#" style="width: 100%;" class="btn btn-success">List Of Products</a>
				</div>
			</div>
		</div>

		<!-- Add Modal -->
		<div id="addAdminModal" class="modal fade" role="dialog">
			<div class="modal-dialog">
				<!-- Modal content-->
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title">Add New Admin</h4>
					</div>
					<div class="modal-body">
						<div class="row">
							<div class="col-md-12 addMember">
								<span>Last Name:</span>
								<input type="text" class="form-control add-name-labels" placeholder="Enter last name" id="txtLastName"/>
								
								<span>Middle Name:</span>
								<input type="text" class="form-control add-name-labels" placeholder="Enter middle name" id="txtMiddleName"/>
							
								<span>First Name:</span>
								<input type="text" class="form-control add-name-labels" placeholder="Enter first name" id="txtFirstName"/>
							
								<span>Username/Admin Code:</span>
								<input type="text" class="form-control add-name-labels" placeholder="ex. testadmin001 " id="txtAdminUName"/>
								<small><div class="uname-exist hide" style="color:red; margin-top: -10px; margin-bottom: 10px;">Username is already used</div></small>

								<span>Administrator Password:</span>
								<input type="password" class="form-control add-name-labels" id="txtAdminPass"/>

								<span>Gender:</span><br>
								<select class="btn btn-default" id="dropdownGender">
									<option class="form-control">Male</option>
									<option class="form-control">Female</option>
								</select>
							</div>
						</div>

					</div>
					<div class="modal-footer">
						<button type="button" id="btnSave" class="btn btn-success">Add New Admin</button>
						<button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
					</div>
				</div>
			</div>
		</div>

		<!-- edit -->
		<div id="editAdminModal" class="modal fade" role="dialog">
			<div class="modal-dialog">
				<!-- Modal content-->
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title">Add New Admin</h4>
					</div>
					<div class="modal-body">
						<div class="row">
							<div class="col-md-12 addMember">
								<input type="hidden" id="editHiddenId"></input>
								<span>Last Name:</span>
								<input type="text" class="form-control add-name-labels"  id="txtEditLastName"/>
								
								<span>Middle Name:</span>
								<input type="text" class="form-control add-name-labels" id="txtEditMiddleName"/>
							
								<span>First Name:</span>
								<input type="text" class="form-control add-name-labels" id="txtEditFirstName"/>
							
								<span>Username/Admin Code:</span>
								<input type="text" class="form-control add-name-labels"  id="txtEditAdminUName"/>
								<small><div class="uname-exist hide" style="color:red; margin-top: -10px; margin-bottom: 10px;">Username is already used</div></small>

								<span>Administrator Password:</span>
								<input type="password" class="form-control add-name-labels" id="txtEditAdminPass"/>

								<span>Gender:</span><br>
								<select class="btn btn-default" id="dropdownEditGender">
									<option class="form-control">Male</option>
									<option class="form-control">Female</option>
								</select>
							</div>
						</div>

					</div>
					<div class="modal-footer">
						<button type="button" id="btnSaveAdmin" class="btn btn-success">Update Admin</button>
						<button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
					</div>
				</div>
			</div>
		</div>


	</div>

	

	<script type="text/javascript" src="<?php echo base_url('assets/js/admin.js'); ?>"></script>
	<script>
		var link = "<?php echo site_url(); ?>";
	</script>	
</div>