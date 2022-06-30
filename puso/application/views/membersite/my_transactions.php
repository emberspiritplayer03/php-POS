<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php include('member_header.php'); ?>

<div class="container">
<br>
	<div class="row">
		<div class="col-md-6">
			
			<div>Please select what kind of transaction you want to view.</div>
			<select class="btn btn-primary" id="ddpTrans" style="font-size: 18px;">
				<option></option>
				<option>Cashout Transactions</option>
				<option>Credit Transactions</option>
			</select>
		</div>
	</div>
	<br>
	<div class="row hide" id="paidTransactions">
		<?php if(isset($transaction_codes) && !empty($transaction_codes)): ?>
		<div class="col-md-6">
			<!-- Table -->
			<div style="font-size: 18px; margin-bottom: 10px;">List of Transactions you have made</div>
			<div style="margin-top:-10px; margin-bottom: 10px;"><small>(Click the confirmation code to view the transaction details.)</small></div>
			<div style="height: 250px;">
				<table class="table" id="tblConfirmation" style="width: 80%;">
					<thead>
						<tr>
							<th>CONFIRMATION CODE</th>
							<th>TRANSACTION DATE</th>
						</tr>
					</thead>
					<tbody>	
					
						<?php foreach($transaction_codes as $codes): ?>
							<tr>
								<td><a href="#" class="confirmation_link" data-code="<?php echo $codes['confirmation_code'];?>"><?php echo $codes['confirmation_code']; ?></a></td>
								<td><?php echo date("l, F d, Y  (h:i A)", strtotime($codes['transaction_date'])); ?></td>
							</tr>
						<?php endforeach; ?>
					
					</tbody>
				</table>
				
			</div>
			
		</div>

		
		<div style="width:50%; margin-left:50%; margin-bottom: 5px; margin-top: 10px; background-color: #333; color:white;font-size: 20px; height: 50px; padding: 10px;">
			<span>TOTAL AMOUNT OF TRANSACTION:</span> 
			<span id="totalTransAmount"></span>
		</div>
		<div class="col-md-6" style="padding:10px; height: 400px; overflow-y: auto; background-color: #FFFFAF; ">
			<table class="table table-bordered hide" id="transactionTable" style="margin-top: 0px;">
				<thead>
					<tr><th style="background-color: #fff!important;" colspan="4">Products bought</th></tr>
					<tr>
						<th style="background-color: #333!important; color:white;">Product Code</th>
						<th style="background-color: #333!important; color:white;">Price</th>
						<th style="background-color: #333!important; color:white;">Quantity</th>
						<th style="background-color: #333!important; color:white;">Amount</th>
					</tr>
				</thead>
				<tbody>	
				</tbody>
			</table>
		</div>
		<?php else: ?>
			<center><h3>You dont have any transactions yet.</h3></center>
		<?php endif; ?>
	</div>

	<div class="row hide" id="creditTransactions">
		<?php if(isset($credit_transaction_codes) && !empty($credit_transaction_codes)): ?>
		<div class="col-md-6">
			<!-- Table -->
			<div style="font-size: 18px; margin-bottom: 10px;">Pending Credit Made</div>
			<div style="margin-top:-10px; margin-bottom: 10px;"><small>(Click the confirmation code to view the transaction details.)</small></div>
			<div style="height: 250px;">
				<table class="table" id="tblConfirmation" style="width: 80%;">
					<thead>
						<tr>
							<th>CONFIRMATION CODE</th>
							<th>TRANSACTION DATE</th>
						</tr>
					</thead>
					<tbody>	
					
						<?php foreach($credit_transaction_codes as $codes): ?>
							<tr>
								<td><a href="#" class="confirmation_link2" data-code="<?php echo $codes['confirmation_code'];?>"><?php echo $codes['confirmation_code']; ?></a></td>
								<td><?php echo date("l, F d, Y  (h:i A)", strtotime($codes['transaction_date'])); ?></td>
							</tr>
						<?php endforeach; ?>
					
					</tbody>
				</table>
			</div>
			
		</div>

		
		<div style="width:50%; margin-left:50%; margin-bottom: 5px; margin-top: 10px; background-color: #333; color:white;font-size: 20px; height: 50px; padding: 10px;">
			<span>TOTAL AMOUNT OF TRANSACTION:</span> 
			<span id="totalTransAmount2"></span>
		</div>
		<div class="col-md-6" style="padding:10px; height: 400px; overflow-y: auto; background-color: #FFFFAF; ">
			<table class="table table-bordered hide" id="transactionTable2" style="margin-top: 0px;">
				<thead>
					<tr><th style="background-color: #fff!important;" colspan="4">Products bought</th></tr>
					<tr>
						<th style="background-color: #333!important; color:white;">Product Code</th>
						<th style="background-color: #333!important; color:white;">Price</th>
						<th style="background-color: #333!important; color:white;">Quantity</th>
						<th style="background-color: #333!important; color:white;">Amount</th>
					</tr>
				</thead>
				<tbody>	
				</tbody>
			</table>
			<?php else: ?>
			<center><h3>You dont have any credited transactions yet.</h3></center>
			<?php endif; ?>
		</div>
		
	</div>



	<script type="text/javascript" src="<?php echo base_url('assets/js/transaction.js'); ?>"></script>
	<script>
		var link = "<?php echo site_url(); ?>";
	</script>	

</div>