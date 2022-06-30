$(document).ready(function(){
	
	var memberdata = [],
		temp_table_data = [];

	$('#btnStartTrans').on('click', function() {

		$.ajax ({
			url: link + "/transactions/deleteTempTrans",
			method: "POST",
			data: { },
			dataType: "json",
			success: function(data) {

			}
		});

	});

	$("#txtMemberCode").on('blur', function() {

		if ($(this).val().length == 0) {
			memberdata = [];
		} else {
			$.ajax ({
				url: link + "/transactions/getMemberbyCode",
				method: "POST",
				data: { 
					code: $(this).val()
				},
				dataType: "json",
				success: function(data) {
					if (data == false) {
						$("#txtUserId").val("0");
						$(".lblfname").text("NOT A MEMBER");
						$(".lbllname").text("");
					}
					else {
						checkIfhasExisingLoan(data.user_id);

						$("#txtUserId").val(data.user_id);
						$(".lblfname").text(data.first_name);
						$(".lbllname").text(data.last_name);
					}

				}
			});
		}

		function checkIfhasExisingLoan(user_id)
		{
			$.ajax ({
				url: link + "/transactions/checkIfHasCredit",
				method: "POST",
				data: { 
					user_id: user_id
				},
				dataType: "json",
				success: function(data) {
					if (data == 1) {
						alert("Member has existing credits");
						$("#btnAddProd").prop("disabled", "true");
						$("#btnSaveTrans").prop("disabled", "true");
					} else {
						//$("#btnAddProd").prop("disabled", false);
						$("#btnSaveTrans").prop("disabled", false);
					}
				}
			});
		}
		
	});


	$("#payMemberCode").on('blur', function() {

		$.ajax ({
			url: link + "/transactions/getMemberbyCode",
			method: "POST",
			data: { 
				code: $(this).val()
			},
			dataType: "json",
			success: function(data) {
				if (data == false) {
					$(".mem-not-found").removeClass("hide");
					$("#payMemberCode").focus();
				}
				else {
					getCreditDetails(data.user_id);
					$("#payUserId").val(data.user_id);
					$(".mem-not-found").addClass("hide");
				}

			}
		});

		function getCreditDetails(user_id)
		{
			$.ajax ({
				url: link + "/transactions/selectCreditDetails",
				method: "POST",
				data: { 
					user_id: user_id
				},
				dataType: "json",
				success: function(data) {
					if (data == "0") {
						$("#payCode").text("NO");
						$("#payTransDate").text("CREDIT");
						$("#payTotAmount").text("FOUND");
						$("#txtPaymentCredit").prop("disabled", "true");
						$("#btnPayCredit").prop("disabled", "true");
					} else {
						$("#payTransDate").text(data.transaction_date);
						$("#payTotAmount").text(formatNumber(data.total_amount));
						$("#payCode").text(data.confirmation_code);
					}
					

				}
			});
		}
		
	});

	$("#ddpTrans").on('change', function() {

		if ($(this).val() == "Cashout Transactions") {
			$("#paidTransactions").removeClass('hide');
			$("#creditTransactions").addClass('hide');
		} else if ($(this).val() == "Credit Transactions") {
			$("#creditTransactions").removeClass('hide');	
			$("#paidTransactions").addClass('hide');
			$("#transactionTable2").addClass('hide');
			$(".prodBought2").addClass('hide');
			$("#totalTransAmount2").text("");
		} else {
			$("#paidTransactions").addClass('hide');
			$("#creditTransactions").addClass('hide');
		}
	})



	$("#btnPayCredit").on('click', function(){
		var payment = parseFloat($("#txtPaymentCredit").val()),
			confirmation_code = $("#payCode").text(),
			amountToPay = parseFloat($("#payTotAmount").text()),
			user_id = $("#payUserId").val(),
			transDate = $("#payTransDate").text();

			if ($("#payMemberCode").val() == "") {
				alert("Please enter the member code");
			} else {
				$.ajax ({
					url: link + "/transactions/payCredit",
					method: "POST",
					data: { 
						user_id: user_id,
						payment: payment,
						amountToPay: amountToPay,
						transDate: transDate
					},
					dataType: "json",
					success: function(data) {
						alert("Credit paid successfully");

					}
				});
			}

			
	});

	$('#creditPaymentModal').on('hidden.bs.modal', function () {
		$(".mem-not-found").addClass("hide");
		$("#payCode").text("");
		$("#payTransDate").text("");
		$("#payTotAmount").text("");
		$("#payMemberCode").val("");
		$("#txtPaymentCredit").prop("disabled", false);
		$("#txtPaymentCredit").val("");
		$("#btnPayCredit").prop("disabled", false);
	});

	$("#is_credit").on('change', function() {

		if ($("#txtMemberCode").val().length == 0) {
			alert("Non-members are not allowed to credit");
			$("#is_credit").val("No");
		}
	});


	$("#txtProduct").on('blur', function() {
		if ($(this).val().length == 0 ) {
			$("#txtQuantity").prop("disabled", 'true');
		}
	});

	$("#txtQuantity").on('blur', function() {
		if ($(this).val() == "") {
			alert("Please enter quantity");
			$($(this).focus());
			$("#btnAddProd").prop("disabled", 'true');
		} else {
			$("#btnAddProd").removeAttr("disabled");
		}
	});

	$('#txtProduct').on('keyup', function() {

		$.ajax ({
			url: link + "/transactions/getProductDetailsByName",
			method: "POST",
			data: { 
				product: $(this).val()
			},
			dataType: "json",
			success: function(data) {
				if (data == "0") {
					$(".no-prod").removeClass('hide');
					$(".prod-info").addClass('hide');
					$("#btnAddProd").prop('disabled', 'true');
				} else {
					$(".prod-info").removeClass('hide');
					$(".no-prod").addClass('hide');
					$(".prd-code").text(data.product_code);
					$(".prd-name").text(data.prod_name);
					$(".prd-price").text(formatNumber(data.price));
					$(".prd-stock").text(data.stock);
					$(".prd-id").text(data.prod_id);

					if ($(".prd-stock").text() == "0") {
						$("#btnAddProd").prop('disabled', 'true');
						$('#txtQuantity').prop('disabled', 'true');
					} else {
						$("#btnAddProd").removeAttr('disabled');
						$('#txtQuantity').removeAttr('disabled');
					}
				}
				
			}
		});
	});

	$("#btnAddProd").on('click', function() {


		var quantity = $(".txtquantity").val(),
			prod_id = $(".prd-id").text(),
			prod_code = $(".prd-code").text(),
			user_id = $("#txtUserId").val(),
			price = $(".prd-price").text();

			if(user_id == "") {
				user_id = 0;
			}

			if(quantity == "") {
				alert("please enter quantity");
				$("#txtQuantity").focus();
			} else {
				addProdAjax();
			}

			
			function addProdAjax()
			{
				$.ajax ({
					url: link + "/transactions/insertProduct",
					method: "POST",
					data: { 
						prod_id: prod_id,
						prod_code: prod_code,
						quantity: quantity,
						user_id: user_id,
						price: price
					},
					dataType: "json",
					success: function(data) {
						if (data == "not enough stock") {
							alert('Not enough stock');
							$("#txtQuantity").val("1");
						} else {
							$("#txtProduct").val("");
							$("#txtQuantity").prop("disabled", true);
							$("#txtQuantity").val("1");
							getTempTrans(user_id);
							getTotalAmountAdd();
						}
						
					}
				});
			}

			
	});


	function getTotalAmountAdd()
	{
		$.ajax ({
				url: link + "/transactions/getTotalAmount",
				method: "POST",
				data: { },
				dataType: "json",
				success: function(data) {
					if (data != null)
						$("#totalAmount").text(formatNumber(data));
					else 
						$("#totalAmount").text(formatNumber("0"));
				}
			});
	}

	function getTempTrans(user_id)
	{

		var trHTML = '';

		$.ajax ({
			url: link + "/transactions/getTemporaryTable",
			method: "POST",
			data: { },
			dataType: "json",
			success: function(data) {
				temp_table_data = data;
				$.each(data, function(idx, key){
			    	trHTML += '<tr style="height: 10px; text-align: center; font-size:10px;"><td>' + key.product_code + '</td>';
			    	trHTML += '<td>' + key.price + '</td>';
			    	trHTML += '<td>' + key.quantity + '</td>';
			    	trHTML += '<td>' + formatNumber(key.amount) + '</td>';
			    	//trHTML += '<td><button class="btnRemove" data-userid = '+ key.user_id+' data-id='+key.temp_id+'>remove</button></td>';
			    	trHTML += '<td><a href="#" class="btnRemove" data-userid='+key.user_id+' data-id='+key.temp_id+'><i class="fa fa-trash"></a></td>'
			    	trHTML += '</tr>';
				});
				$("#tblTrans tbody").html(trHTML);
				$("#tblTrans").removeClass('hide');
				removeItem();
			}
		});
	}

	function removeItem()
	{

		$(".btnRemove").on('click', function() {
			var trHTML = '';
			$.ajax ({
				url: link + "/transactions/removeItem/"+ $(this).data('id'),
				method: "POST",
				data: { },
				dataType: "json",
				success: function(data) {
					$.each(data, function(idx, key){
				    	trHTML += '<tr style="height: 10px; text-align: center; font-size:10px;"><td>' + key.product_code + '</td>';
				    	trHTML += '<td>' + key.price + '</td>';
				    	trHTML += '<td>' + key.quantity + '</td>';
				    	trHTML += '<td>' + formatNumber(key.amount) + '</td>';
				    	//trHTML += '<td><button class="btnRemove" data-userid = '+ key.user_id+' data-id='+key.temp_id+'>remove</button></td>';
				    	trHTML += '<td><a href="#" class="btnRemove" data-userid='+key.user_id+' data-id='+key.temp_id+'><i class="fa fa-trash"></a></td>'
				    	trHTML += '</tr>';
					});
				$("#tblTrans tbody").html(trHTML);
				$("#tblTrans").removeClass('hide');
				removeItem();
				getTotalAmountAdd();
				}
			});
		});

	}

	$("#btnSaveTrans").on('click', function() {

		if (temp_table_data.length == 0) {
			alert('no data to be saved');
		} else {
			var is_credit = $("#is_credit").val();

			$.ajax ({
				url: link + "/transactions/saveTransaction",
				method: "POST",
				data: { 
					is_credit: is_credit
				},
				dataType: "json",
				success: function(data) {
					if (data == true) {
						alert("Transaction saved");
						$('#transModal').modal('toggle');
					}
				}
			});
		}		
	});

	// when modal is closed, warning that transaction will be voided
	$('#transModal').on('hidden.bs.modal', function () {
		$("#txtProduct").val("");
		$("#txtUserId").val("");
		$("#tblTrans").addClass("hide");
		$(".prod-info").addClass('hide');
		$("#totalAmount").text("");
		$("#txtMemberCode").val("");
		$("#is_credit").val("No");

		$.ajax ({
			url: link + "/transactions/deleteTempTrans",
			method: "POST",
			data: { },
			dataType: "json",
			success: function(data) {
			}
		});
	});

	function formatNumber(number)
	{
		return number = parseFloat(number).toFixed(2);
	}


	// member site

	$(".confirmation_link").on('click', function() {
		var trHTML = '';
		var code = $(this).data('code');

		$.ajax ({
			url: link + "/membersite/MyTransactions/getTransactionsByCode",
			method: "POST",
			data: { 
				code: $(this).data('code')
			},
			dataType: "json",
			success: function(data) {
				$.each(data, function(idx, key){
			    	trHTML += '<tr><td>' + key.prod_name + '</td>';
			    	trHTML += '<td>' + key.price + '</td>';
			    	trHTML += '<td>' + key.quantity + '</td>';
			    	trHTML += '<td>' + formatNumber(key.amount) + '</td>';
			    	trHTML += '</tr>';
				});
				getTotalAmount(code);
				$("#transactionTable tbody").html(trHTML);
				$("#transactionTable").removeClass('hide');
				$(".prodBought").removeClass('hide');
			}
		});

	});


	$(".confirmation_link2").on('click', function() {
		var trHTML = '';
		var code = $(this).data('code');

		$.ajax ({
			url: link + "/membersite/MyTransactions/getTransactionsByCode",
			method: "POST",
			data: { 
				code: $(this).data('code')
			},
			dataType: "json",
			success: function(data) {
				$.each(data, function(idx, key){
			    	trHTML += '<tr><td>' + key.prod_name + '</td>';
			    	trHTML += '<td>' + key.price + '</td>';
			    	trHTML += '<td>' + key.quantity + '</td>';
			    	trHTML += '<td>' + formatNumber(key.amount) + '</td>';
			    	trHTML += '</tr>';
				});
				getTotalAmount2(code);
				$("#transactionTable2 tbody").html(trHTML);
				$("#transactionTable2").removeClass('hide');
				$(".prodBought2").removeClass('hide');
			}
		});

	});

	function getTotalAmount(conf_code)
	{
		$.ajax ({
			url: link + "/membersite/MyTransactions/getTotalAmountbyCode",
			method: "POST",
			data: { 
				code: conf_code
			},
			dataType: "json",
			success: function(data) {
				$("#totalTransAmount").text("PHP " + formatNumber(data));
			}

		});
	}

	function getTotalAmount2(conf_code)
	{
		$.ajax ({
			url: link + "/membersite/MyTransactions/getTotalAmountbyCode",
			method: "POST",
			data: { 
				code: conf_code
			},
			dataType: "json",
			success: function(data) {
				$("#totalTransAmount2").text("PHP " + formatNumber(data));
			}

		});

	}



});