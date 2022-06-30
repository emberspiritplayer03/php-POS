<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php include_once('header.php'); ?>

<div class="container">
	<br>
	<div class="panel panel-default" style="border-radius: 0px!important; width: 100%; padding-bottom: 50px;">
		<!-- Default panel contents -->
		<div class="panel-heading">Loan Records</div>
		
		<div class="panel-body">
			<div class="row body-panel">
				<div class="col-md-6 add-area">
					<a id="addLoanBtn" href="#" data-toggle="modal" class="btn btn-success" data-target="#addLoanModal"><i class="fa fa-book fa-2x" aria-hidden="true"></i> ADD LOAN</a><br>
					<span style="font-size: 15px;">Search Loan Records:</span>
					<input type="text" id="txtSearchLoan" placeholder="Enter Keyword here" class="form-control"/>
				</div>
			</div>
		</div>
		<!-- Table -->
		<table class="table table-bordered" id="loanTable" style="width: 96%; margin-left: 15px;">
			<thead>
				<tr>
					<th>Member code</th>
					<th>Last Name</th>
					<th>First Name</th>
					<th>Loan Amount</th>
					<th>Loan Date</th>
					<th>Balance</th>
					<th>Status</th>
					<th>Action</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach($loan_records as $loans): ?>
					<tr <?php echo ($loans['is_expired'] == true) ? 'class="expired-alert"' : ''?>>
						<td><?php echo $loans['username'];?></td>
						<td><?php echo $loans['last_name'];?></td>
						<td><?php echo $loans['first_name'];?></td>
						<td><?php echo number_format($loans['original_loan_amount'], 2);?></td>
						<td><?php echo $loans['loan_date'];?></td>
						<td><?php echo number_format($loans['balance'], 2);?>
						<td><?php echo $loans['status'];?></td>
						<td><a href="#" class="linkMore" data-loan-id="<?php echo $loans['loan_id'];?>">view details</a> </td>
					</tr>

				<?php endforeach; ?>
			</tbody>
		</table>
	</div>

	<!-- Add Modal -->
	<div id="addLoanModal" class="modal fade" role="dialog">
		<div class="modal-dialog">
			<!-- Modal content-->
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Add New Loan Record</h4>
				</div>


				<div class="modal-body">
					
					<div class="row">

						<div class="col-md-6 loan-memberside">
							<span class="loan-labels">Member code:</span>
							<input type="text" class="form-control" placeholder="Member code" id="txtMemberCodeLoan"></input>
							<div style="margin-top:-10px;" class="not-allowed-loan hide"><small style="color: red;">Non-members are not allowed to apply for loan</small></div> 
							<input type="hidden" id="txtUserId" />

							<span style="color:black">Loan Amount:</span>
							<input type="text" class="form-control" placeholder="PHP ( 500 - 10,000 )" id="txtLoanAmount"/>
							<small><div style="margin-top:-10px; color:red;" class="enter-loan-amount hide">Please enter valid amount</div></small>

							<span>Select purpose of Loan</span><br>
							<select class="btn btn-default" id="txtLoanPurpose">
								<option>Loan Option 1</option>
								<option>Loan Option 2</option>
							</select>	
						</div>

						<div class="col-md-6 loan-info">
							<div class="loan-fullname" style="margin-top: 10px;">
								<span class="loan-labels">Member Name: </span><br>
								<span id="loanFName"></span>
								<div class="loan-member-alert hide" style="color:red;">asdfasd</div>
							</div>

							<div class="loan-payment">
								<span>Original Loan Amount:</span><br>
								<span class="loan-value"><strong id="loanValue"></strong></span><br>
								<div><small>+ Interest rate: 1.2% for the first month</small></div>

								<div style="margin-top: 20px;">Amount to Pay <small>(interest included)</small></div>
								<span class="loan-value"><strong id="AmountToPay"></strong></span>
							</div>
						</div>
				
					</div>

				</div>

				<div class="modal-footer">
					<button type="button" style="height:45px;" id="btnSave" class="btn btn-primary">Save Loan</button>
					<button type="button" style="height:45px;" class="btn btn-default" data-dismiss="modal">Cancel</button>
				</div>
			</div>
		</div>
	</div>


	<!-- details modal -->
	<div id="loanDetailsModal" class="modal fade" role="dialog" data-backdrop="static" data-keyboard="false">
		<div class="modal-dialog">
			<!-- Modal content-->
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title"></h4>
				</div>
				<div class="modal-body">
					<div class="row">
						
						<div class="col-md-8 divExpired hide" style="height: 50px; padding-top: 5px; background-color: #d9534f; color:white;">
							The loan has expired. The interest rate for the remaining balance will be 3%. Click the update interest button to apply.
						</div>
						<div class="col-md-4 divExpired hide" style="height: 50px; ">
							<a href="#" class="btn btn-danger" id="updateBalance"><i class="fa fa-edit fa-lg"></i> Update Interest</a>
						</div>
						<input type="hidden" id="hiddenBalance">
						<input type="hidden" id="hiddenLoanId">
						<div class="col-md-6 loan-details-side">
								<table class="table table-borderless" id="tblLoanDetails">
								<thead>
									<tr>
										<th colspan="2" style="background-color: white!important;">Loan Details</th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td class="loan-details-labels">Member Code:</td>
										<td id="loanMemberCode" class="loan-details-value"></td>
									</tr>
									<tr>
										<td class="loan-details-labels">Member Name:</td>
										<td id="loanMemberName" class="loan-details-value"></td>
									</tr>
									<tr>
										<td class="loan-details-labels">Loan Amount:</td>
										<td id="loanMemberDate" class="loan-details-value"></td>
									</tr>
									<tr>
										<td class="loan-details-labels">Loan Deadline:</td>
										<td id="loanMemberDeadline" class="loan-details-value"> </td>
									</tr>
									<tr>
										<td class="loan-details-labels">Last Payment: </td>
										<td id="loanMemberLastPayment" class="loan-details-value"></td>
									</tr>
									<tr>
										<td class="loan-details-labels">Loan Payment Date: </td>
										<td id="loanMemberLastPaymentDate" class="loan-details-value"></td>
									</tr>
									<tr>
										<td></td>
										<td class="loan-details-value"><a href="#" class="showPaymentHistory"> View Payment History</a></td>
									</tr>
								</tbody>
							
								</table>
						</div>

						<div class="col-md-6 right-loan">
							<div id="loanBalance">
							</div>
						
							<input type="hidden" id="editUserId" /> 
							<input type="hidden" id="txtLoanId" /> 

							<div class="amount-input">
								<span>Payment Amount: </span>
								<input type="text" class="form-control" id="txtLastPayment" placeholder="">
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" id="btnUpdateLoan" class="btn btn-success">Update Loan</button>
					<button type="button" class="btn btn-danger" data-dismiss="modal">Discard Changes</button>
				</div>
			</div>
		</div>
	</div>

	<div id="historyModal" class="modal fade" role="dialog">
		<div class="modal-dialog">
			<!-- Modal content-->
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title" id="paymentHistoryTitle"></h4>
				</div>
				<div class="modal-body">
					<div class="row" style="padding: 20px;">
						<table class="table table-bordered" id="paymentTable">
							<thead>
								<tr>
									<th style="font-size: 10px!important; text-align: center; background-color: white;">DATE</th>
									<th style="font-size: 10px!important; text-align: center; background-color: white;" >AMOUNT PAID</th>
								</tr>
							</thead>
							<tbody style="text-align: center;">
							</tbody>
						</table>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">close</button>
				</div>
			</div>
		</div>
	</div>

	<script type="text/javascript" src="<?php echo base_url('assets/js/loans.js'); ?>"></script>
	<script>
		var link = "<?php echo site_url(); ?>";
	</script>	
</div>

