<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php include_once('header.php'); ?>

<div class="container">
	<br>
	<div class="panel panel-default" style="border-radius: 0px!important; width: 100%; padding-bottom: 50px;">
	<div class="panel-heading">List of Members</div>
		
		<div class="panel-body">
			<div class="row body-panel">
				<div class="col-md-6 add-area">
					<a id="addBtn" href="#" data-toggle="modal" data-target="#addModal" class="btn btn-success"><i class="fa fa-user-plus fa-2x" aria-hidden="true"></i> ADD MEMBER</a>
					<br>
					<span style="font-size: 15px;">Search Member:</span>
					<input type="text" id="txtSearchMember" placeholder="Enter search keyword here" class="form-control"/>
				</div>
			</div>
		</div>

		<!-- Table -->	
		<table class="table table-bordered" id="memberTable" style="width: 96%; margin-left: 15px;" >
			<thead>
				<tr>
					<th>Member Code</th>
					<th>Last Name</th>
					<th>Middle Name</th>
					<th>First Name</th>
					<th>Address</th>
					<th>Gender</th>
					<th><center>Actions</center></th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($test as $users): ?>
					<tr>
						<td><?php echo $users['username']; ?></td>
						<td><?php echo $users['last_name']; ?></td>
						<td><?php echo $users['middle_name']; ?></td>
						<td><?php echo $users['first_name']; ?></td>
						<td><?php echo $users['address']; ?></td>
						<td><?php echo $users['gender']; ?></td>
						<td><center>
						<a href="#" class='btnEdit' data-id="<?php echo $users['user_id']; ?>"><i class="fa fa-pencil-square-o fa-2x" aria-hidden="true" style="color:#000000"></i></a>&nbsp;
						<a href="#" class='btnDelete' data-id="<?php echo $users['user_id']; ?>"><i class="fa fa-trash fa-2x" aria-hidden="true" style="color: #000000;"></i> </a></center>
						</td> 
					</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
		
	</div>
	<br/>
	<center><div class="alert alert-success hide" role="alert" id="add-success">Member Successfully Added!</div></center>

	<!-- Add Modal -->
	<div id="addModal" class="modal fade" role="dialog">
		<div class="modal-dialog">
			<!-- Modal content-->
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Add New Member</h4>
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
						
							<span>Home Address: </span>
							<textarea class="form-control" id="txtAddress" placeholder="Complete address"></textarea>

							<span>Gender:</span><br>
							<select class="btn btn-default" id="dropdownGender">
								<option class="form-control">Male</option>
								<option class="form-control">Female</option>
							</select>
						</div>
					</div>

				</div>
				<div class="modal-footer">
					<button type="button" id="btnSave" class="btn btn-success">Add Member</button>
					<button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
				</div>
			</div>
		</div>
	</div>

	<!-- Modal -->
	<div id="editModal" class="modal fade" role="dialog">
		<div class="modal-dialog">
			<!-- Modal content-->
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title editTitle"></h4>
				</div>
				<div class="modal-body">
					<input type="hidden" id="editUserId"/>
					<span>Last Name:</span>
					<input type="text" class="form-control add-name-labels" placeholder="Last name" id="editLastName"/>
					<span>Middle Name:</span>
					<input type="text" class="form-control add-name-labels" placeholder="Middle name" id="editMiddleName"/>
					<span>First Name:</span>
					<input type="text" class="form-control add-name-labels" placeholder="First name" id="editFirstName"/>
					<span>Home Address: </span>
					<textarea class="form-control" id="editAddress" placeholder="Address"></textarea>
					<span>Gender:</span><br>
					<select class="btn btn-default" id="editdropdownGender">
						<option class="form-control">Male</option>
						<option class="form-control">Female</option>
					</select>
				</div>
				<div class="modal-footer">
					<button type="button" id="btnSaveEdit" class="btn btn-success">Save Changes</button>
					<button type="button" class="btn btn-danger" data-dismiss="modal">Discard Changes</button>
				</div>
			</div>
		</div>
	</div>

	<script type="text/javascript" src="<?php echo base_url('assets/js/member.js'); ?>"></script>
	<script>
		var link = "<?php echo site_url(); ?>";
	</script>	
</div>