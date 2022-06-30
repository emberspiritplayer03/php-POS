<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php include('member_header.php'); ?>

<div class="container">
<br>	
	<?php if (isset($loan_data) && !$loan_data['status'] == 'PAID'):?>
	<div class="row" id="myLoanDetails">
		<div class="col-md-6" style="height: 340px; background-color: #FDFDDD;">
			<div class="row">
				<div class="col-md-12" style="padding-top: 20px;">
					<div class="row" style="margin-bottom: 10px;">
						<div class="col-md-6" style="height: 50px; text-align: center; padding-top: 10px;">
							<span class="myloans-label">LOAN AMOUNT:</span>
						</div>
						<div class="col-md-6 myloans-div" style="height: 50px; text-align: center; padding-top: 10px;">
							<span class="myloans-label">PHP <?php echo number_format($loan_data['original_loan_amount'], 2); ?></span>
						</div>
					</div>
					<div class="row" style="margin-bottom: 10px;">
						<div class="col-md-6" style="height: 50px; text-align: center; padding-top: 10px;">
							<span class="myloans-label">DATE OF LOAN:</span>
						</div>
						<div class="col-md-6 myloans-div" style="height: 50px; text-align: center; padding-top: 10px;">
							<span class="myloans-label"><?php echo date("F d, Y", strtotime($loan_data['loan_date'])); ?></span>
						</div>
					</div>
					<div class="row" style="margin-bottom: 10px;">
						<div class="col-md-6" style="height: 50px; text-align: center; padding-top: 10px;">
							<span class="myloans-label">LOAN DEADLINE:</span>
						</div>
						<div class="col-md-6 myloans-div" style="height: 50px; text-align: center; padding-top: 10px;">
							<span class="myloans-label"><?php echo date("F d, Y", strtotime($loan_data['loan_deadline'])); ?></span>
						</div>
					</div>
					<div class="row" style="margin-bottom: 10px;">
						<div class="col-md-6" style="height: 50px; text-align: center; padding-top: 10px;">
							<span class="myloans-label">REMAINING BALANCE:</span><br>
							<small>(Interest included)</small>
						</div>
						<div class="col-md-6 myloans-div" style="height: 50px; text-align: center; padding-top: 10px;">
							<span class="myloans-label">PHP <?php echo number_format($amount_to_pay, 2); ?></span>
						</div>
					</div>
					<div class="row" style="margin-bottom: 10px;">
						<div class="col-md-6" style="height: 50px; text-align: center; padding-top: 10px;">
							<span class="myloans-label">STATUS:</span><br>
						</div>
						<div class="col-md-6 myloans-div <?php echo ($loan_data['status'] == 'NOT PAID' ? 'not-paid' : 'paid')?>" style="height: 50px; text-align: center; padding-top: 10px;">
							<span class="myloans-label"><?php echo $loan_data['status']; ?></span>
						</div>
					</div>

						
				</div>
			</div>

		</div>

		<div class="col-md-6">
			<div class="row">
				<div class="col-md-12" style="padding-top: 20px; height:340px; background-color: #FDFDDD; ">
			
					<div class="loan-balance">
						<span style="font-size:18px;">Payment Record</span>
						<table class="table table-bordered" id="paymentTable">
							<thead>
								<tr style="text-align: center;">
									<th style="background-color: white!important;">DATE OF PAYMENT</th>
									<th style="background-color: white!important;">AMOUNT PAID</th>
								</tr>
							</thead>
							<tbody>
								
								<?php foreach($payment_history as $payment): ?>
									<tr>
										<td><?php echo date("F d, Y", strtotime($payment['date_received'])); ?></td>
										<td><?php echo number_format($payment['loan_payment'], 2); ?></td>
									</tr>
								<?php endforeach; ?>
								
							</tbody>
						</table>
						<br>
					</div>

					<div class="row bg-success" style="margin-left:70px; padding:10px; margin-top: 30px; width: 90%;" >
						<span>The balance changes when the loan expired because the interest is moving up from 1.2% to 3% for the remaining amount you haven't paid.</span>
					</div>
				</div>
			</div>
		</div>

	</div>
	<?php else: ?>
		<center><h3>You have no current loan</h3></center>
	<?php endif; ?>
	<script type="text/javascript" src="<?php echo base_url('assets/js/loans.js'); ?>"></script>
	<script>
		var link = "<?php echo site_url(); ?>";
	</script>	
</div>