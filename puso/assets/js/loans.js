$(document).ready(function(){


	$("#txtMemberCodeLoan").on('blur', function() {

		$.ajax ({
			url: link + "/transactions/getMemberbyCode",
			method: "POST",
			data: { 
				code: $(this).val()
			},
			dataType: "json",
			success: function(data) {
				if (data == false) {
					$(".not-allowed-loan").removeClass('hide');
					$("#loanValue").text("");
					$("#AmountToPay").text("");
					$("#txtLoanAmount").prop('disabled', true);
					$("#txtMemberCodeLoan").focus();
					$("#txtLoanAmount").val("");
					$("#loanFName").text("");
					$(".loan-member-alert").addClass('hide');
				} else {
					$(".not-allowed-loan").addClass('hide');
					$("#txtUserId").val(data.user_id);
					$(".loan-member-alert").addClass('hide')
					$("#txtLoanAmount").removeAttr('disabled');
					$("#txtLoanAmount").focus();
					$("#loanFName").text(data.first_name + " " + data.middle_name + " " + data.last_name);
				}	
				
			}
		});

	});

	$("#txtLoanAmount").on('blur', function() {
		if ($("#txtMemberCodeLoan").val() == "")
		{
			alert("enter Member code first");
			$(this).prop("disabled", true);
			$("#txtMemberCodeLoan").focus();
			$(this).val("");

		} else {
			if ($.isNumeric($(this).val())) {
				$("#loanValue").text("PHP " + formatNumber($(this).val())); 
				$("#AmountToPay").text("PHP " + computeAmountToPay($(this).val()))
				$(".enter-loan-amount").addClass('hide');
			}	
			else {
				$(".enter-loan-amount").removeClass('hide');
				$("#loanValue").text("");
				$("#txtLoanAmount").focus();
				$(this).val("");
			}
		}
	});

	function computeAmountToPay(loan_amount)
	{

		var profit_percent = 1.2 / 100;

		var profit = profit_percent * loan_amount;

		return formatNumber(parseFloat(loan_amount) + parseFloat(profit));

	}


	$("#btnSave").on('click', function() {

		var userId = $("#txtUserId").val(),
			loanAmount = $("#txtLoanAmount").val();

		if (userId == "" && loanAmount == "") {
			alert("Please enter the required fields");
		}

		$.ajax ({

			url: link + "/loans/addLoan",
			method: "POST",
			data: {
				userId: userId,
				loanAmount: loanAmount
			},
			success: function(data) {
				if (data == "true") {
					alert("Loan Successfully Saved");
					location.reload();
				} else {
					$(".loan-member-alert").text(data);
					$(".loan-member-alert").removeClass('hide');	
				}
				
			}
		});

	});

	$('#addLoanModal').on('hidden.bs.modal', function () {
    	$("#loanFName").text("");
    	$("#loanValue").text("");
    	$("#txtLoanAmount").val("");
    	$("#AmountToPay").text("");
    	$("#txtMemberCodeLoan").val("");
	});

	changeBalanceColor();



	var loandata = [];
	clickLink();
	clickBalance();

	function clickLink()
	{
		$(".linkMore").on('click', function() {
	
		$.ajax ({

				url: link + "/loans/selectSingleLoan/" + $(this).data('loan-id'),
				method: "POST",
				data: { },
				dataType: "json",
				success: function(data) {
					loandata = data;
					$("#loanMemberCode").text(data.username);
					$("#loanMemberName").text(data.last_name + " " + data.middle_name + " " + data.first_name);
					$("#loanMemberDate").text(formatNumber(data.original_loan_amount));

					if (data.is_expired == 1) {
						$("#loanMemberDeadline").text(data.loan_deadline).append("<strong><span class='lblexpired' style='color:red'> (EXPIRED)</span></strong>");
						$('.divExpired').removeClass('hide');
					} else {
						$("#loanMemberDeadline").text(data.loan_deadline);
						$('.divExpired').addClass('hide');
					}
					
					$("#loanMemberLastPayment").text(formatNumber(data.last_payment));
					
					if(data.last_payment_date == null) {
						$("#loanMemberLastPaymentDate").text("No payment made yet.");
						$(".showPaymentHistory").addClass('hide');
					} else {
						$("#loanMemberLastPaymentDate").text(data.last_payment_date);
						$(".showPaymentHistory").removeClass('hide');
					}

					if(data.balance == "0") {
						$("#loanBalance").css("background-color", "#0DAE30");
						$("#loanBalance").css("color", "white");
						$(".amount-input").addClass('hide');
						$('.divExpired').addClass('hide');
						$("#loanMemberDeadline").text(data.loan_deadline);
					} else {
						$("#loanBalance").css("background-color", "#FFF28B");
						$("#loanBalance").css("color", "black");
						$(".amount-input").removeClass('hide');
					}
					$("#loanBalance").text("BALANCE: PHP " + formatNumber(data.balance));
					$("#editUserId").val(data.user_id);
					$("#txtLoanId").val(data.loan_id);
					$("#hiddenBalance").val(data.balance);
					$("#hiddenLoanId").val(data.loan_id);

					$("#loanDetailsModal").modal('show');

				}
			});
	});
	}
	
	$("#btnUpdateLoan").on('click', function() {

		var last_payment = $("#txtLastPayment").val(),
			user_id = loandata.user_id,
			original_loan_amount = parseFloat(loandata.original_loan_amount),
			balance = parseFloat(loandata.balance),
			loan_deadline = loandata.loan_deadline,
			loan_date = loandata.loan_date;

			console.log('tesy');
			
		if (parseFloat(last_payment) > balance) {
			alert('Payment should not be higher than the loan amount');
		} else if (last_payment.length == 0) {
			alert('Please enter amount');
			$("#txtLastPayment").focus();
		}
		else {

			if (balance == 0) {
				alert("The loan is already paid");
			}
			else {
				$.ajax ({

					url: link + "/loans/editLoan",
					method: "POST",
					data: {
						user_id: user_id,
						loanId: loandata.loan_id,
						loanAmount: original_loan_amount,
						lastPayment: parseFloat(last_payment),
						balance: balance,
						loanDeadline: loan_deadline,
						loanDate: loan_date
					},
					dataType: "json",
					success: function(data) {
						alert("Payment Successfully Received");
						location.reload();
					}
				});
			} 
			
		}
	});

	function clickBalance()
	{
		$('#updateBalance').on('click', function() {

			var loan_id = $("#hiddenLoanId").val(),
				current_balance = parseFloat($("#hiddenBalance").val());

				$.ajax ({
					
					url: link + "/loans/updateExpiredBalance",
					method: "POST",
					data: {
						loanId: loan_id,
						balance: current_balance
					},
					dataType: "json",
					success: function(data) {
						$("#loanBalance").text("BALANCE: PHP " + formatNumber(data.balance));
						$(".lblexpired").addClass('hide');
						$("#loanMemberDeadline").text(data.loan_deadline);
						$(".divExpired").addClass('hide');
						alert("balance and loan deadline updated!");

					}
				});
		});
	}
	

	$(".showPaymentHistory").on('click', function() {

		var loan_id = $("#txtLoanId").val(),
			user_id = $("#editUserId").val()
			trHTML = '';

		$.ajax ({

			url: link + "/loans/viewPayment",
			method: "POST",
			data: {
				loanId: loan_id,
				userId: user_id
			},
			dataType: "json",
			success: function(data) {
				$.each(data, function(idx, key){
				    trHTML += '<tr><td>' + key.date_received + '</td><td>' + formatNumber(key.loan_payment) + '</td></tr>';
				});
				$("#paymentHistoryTitle").text("Payment History of " + $("#loanMemberCode").text());
				$("#paymentTable tbody").html(trHTML);
				$("#paymentTable").removeClass('hide');
			}
		});

		$("#historyModal").modal('show');
	});

	$('#loanDetailsModal').on('hidden.bs.modal', function () {
    	$("#paymentTable").addClass('hide');

    	$("#txtLastPayment").removeClass('hide');
		$("#editUserId").removeClass('hide');
		$(".user-paid").addClass('hide');
		$("#btnUpdateLoan").removeClass('hide');
	})

	function formatNumber(number)
	{
		return number = parseFloat(number).toFixed(2);
	}


	$("#txtSearchLoan").on('keyup', function() {
		var trHTML = '';

			$.ajax ({
				url: link + "/loans/searchLoan",
				method: "POST",
				data: { 
					search: $(this).val()
				},
				dataType: "json",
				success: function(data) {
					$.each(data, function(idx, key){

				    	if (key.is_expired == 1) {
				    		trHTML += '<tr class="expired-alert">';
				    	} else {
				    		trHTML += '<tr>';
				    	}
				    	trHTML += '<td>' + key.username + '</td>';	
				    	trHTML += '<td>' + key.last_name + '</td>';
				    	trHTML += '<td>' + key.first_name + '</td>';
				    	trHTML += '<td>' + formatNumber(key.original_loan_amount) + '</td>';
				    	trHTML += '<td>' + key.loan_date + '</td>';	
				    	trHTML += '<td>' + formatNumber(key.balance) + '</td>';
				    	trHTML += '<td>' + key.status + '</td>';
				    	trHTML += '<td><a href="#" class="linkMore" data-loan-id="'+ key.loan_id +'" >view details</a></td>';
				    	trHTML += '</tr>';


					});

					$("#loanTable tbody").html(trHTML);
					clickLink();
					clickBalance();

				}
			});

	});

	/* for member's site */

	function changeBalanceColor()
	{
		if ($("#balance").data('bal') == 0)
		{
			$(".lbl-balance").css("background-color", "#04B404");
			$(".lbl-balance").css("color", "#000000");
		}
		
	}

	function formatNumber(number)
	{
		return number = parseFloat(number).toFixed(2);
	}



		
});
