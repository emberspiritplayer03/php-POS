<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php include_once('header.php'); ?>


<div class="container">
	
		<a id="btnStartTrans" class="btn btn-primary btn-lg" href="#" data-toggle="modal" data-target="#transModal">START NEW TRANSACTION</a>

		<a id="btnCreditPayment" class="btn btn-primary btn-lg" href="#" data-toggle="modal" data-target="#creditPaymentModal">CREDIT PAYMENTS</a>
		

		<div id="transModal" class="modal fade" role="dialog" style="width: 100%;" data-backdrop="static" data-keyboard="false">
			<div class="modal-dialog">
				<!-- Modal content-->
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title">New Transaction</h4>
					</div>
					<div class="modal-body myBox">
									
						<div class="row" style="height: 300px;">
		
							<div class="col-md-5" style="height: 300px;">
								<div class="row">	
									<div class="col-md-12 group1">
										<span style="color:black">Member code:</span>
										<input type="text" class="form-control transUserId" placeholder="Member code" id="txtMemberCode" />
										<input type="hidden" id="txtUserId" />
										
										<span style="color:black">Product:</span>
										<input type="text" class="form-control" placeholder="Product code or name" id="txtProduct"/>

										<span style="color:black">Quantity:</span>
										<input type="number" class="form-control txtquantity" min="1" id="txtQuantity" disabled="true"/>

										<button class="btn btn-success" id="btnAddProd">Add product</button>
										<button class="btn btn-default" id="btnCancel">clear</button>
									</div>
								</div>
							</div>

							<div class="col-md-7" style="height: 200px;">
								<div class="row">
									<div class="col-md-12 product-area" style="padding-top: 10px">
										<span style="color: black; font-size: 15px;">PRODUCT DETAILS:</span>
										<div class="prod-info hide">
											<input type="hidden" class="prd-id"/>
											<span class="labels">Product Name: </span><span class="prd-name lblresults"></span><br/>
											<span class="labels">Product Code: </span><span class="prd-code lblresults"></span><br/>
											<span class="labels">Product Price: </span><span class="prd-price lblresults"></span><br/>
											<span class="labels">Product Stock: </span><span class="prd-stock lblresults"></span>
										</div>
									</div>
								</div>
								
								<div class="row">
									<div class="col-md-12 table-area">
										<span style="color: black; font-size: 15px;">ORDER SUMMARY</span>
										<br>
										<table class="table table-bordered" id="tblTrans">
											<thead>
												<tr style="height: 10px; text-align: center; font-size:10px;">
													<td>code</td>
													<td>price</td>
													<td>quantity</td>
													<td>amount</td>
													<td>remove</i></td>
												</tr>
											</thead>
											<tbody>

											</tbody>
										</table>
									</div>
								</div>
							</div>

						</div>


						<div class="row transmodal-upper" style="margin-top: 20px;"> 
							<div class="col-md-5 bg-success">
								<span>Credit Transaction?</span>
								<select class="btn btn-primary" id="is_credit">
									<option>No</option> 
									<option>Yes</option>
								</select>
							</div>
							<div class="col-md-7 amount-total" style="height: 50px;">
								<div>		
									<span>TOTAL AMOUNT: PHP </span><span id="totalAmount"></span>
								</div>
							</div>
						</div>		

					</div>
					<div class="modal-footer">

						<button type="button" id="btnSaveTrans" class="btn btn-success">Save Transaction</button>
						<button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
					</div>
				</div>
			</div>
		</div>


		<!-- Modal -->
		<div id="creditPaymentModal" class="modal fade" role="dialog">
			<div class="modal-dialog">
				<!-- Modal content-->
				<div class="modal-content" style="width:100%;">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4>Pay Credit</h4>
					</div>
					<div class="modal-body">
						<div class="row">
							<div class="col-md-12" style="height: 300px; padding:10px;">
								<span style="color:black">Member code:</span>								
								<input type="text" class="form-control transUserId" placeholder="Member code" id="payMemberCode" />
								<small><div style="color:red; margin-top: -10px;" class="mem-not-found hide">Member with the code provided not found</div></small>
								<input type="hidden" id="payUserId" />
								<div class="row" style="padding: 15px; font-size: 15px; text-align: center;">
									<div class="col-md-4" style="padding-top:5px; height: 50px; border: solid 1px #FFFFAF;">
										<span>TRANSACTION CODE</span>
									</div>

									<div class="col-md-4" style="padding-top:5px; height: 50px; border: solid 1px #FFFFAF;">
										<span>TRANSACTION DATE</span>
									</div>									

									<div class="col-md-4" style="padding-top:5px; height: 50px; border: solid 1px #FFFFAF;">
										<span>AMOUNT TO PAY</span>
									</div>
								</div>
								<div class="row" style="padding: 15px; margin-top: -30px; font-size: 18px; text-align: center;">
									<div class="col-md-4" style="padding-top:5px;height: 55px; background-color: #FFFFAF;">
										<div id="payCode"></div>
									</div>

									<div class="col-md-4" style="padding-top:5px;height: 55px; background-color: #FFFFAF;">
										<div id="payTransDate"></div>
									</div>									

									<div class="col-md-4" style="padding-top:5px;height: 55px; background-color: #FFFFAF;">
										<div id="payTotAmount"></div>
									</div>
								</div>

								<div>Enter Payment:</div>
								<input type="text" id="txtPaymentCredit"></input>
								<button id="btnPayCredit" class="btn btn-success" >Pay Credit</button>
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					</div>
				</div>
			</div>
		</div>


		<script type="text/javascript" src="<?php echo base_url('assets/js/transaction.js'); ?>"></script>
		<script>
			var link = "<?php echo site_url(); ?>";
		</script>
	</div>


	