$(document).ready(function(){


	$("#btnSave").on('click', function() {

		var prod_code = $("#txtProdCode").val(),
			prod_name = $("#txtProdName").val(),
			price = parseFloat($("#txtPrice").val()),
			stock = $("#txtStock").val();

			
			if (prod_code == "" && prod_name == "" && price == "" && stock == "") {
				$("#requiredAlert").removeClass('hide');
			}
			if (prod_code == "") {
				$("#txtProdCode").addClass('required'); 
				$("#requiredAlert").removeClass('hide');	
			} 
			if (prod_name == "") {
				$("#txtProdName").addClass('required'); 
				$("#requiredAlert").removeClass('hide');
			} 
			if ($("#txtPrice").val() == "") {
				$("#txtPrice").addClass('required'); 
				$("#requiredAlert").removeClass('hide');
			} 
			if (stock == "") {
				$("#txtStock").addClass('required');
				$("#requiredAlert").removeClass('hide');
			}
			else {
				$("#requiredAlert").removeClass('hide');
				AddRequest(); 
			}

		function AddRequest()
		{
			$.ajax ({
				url: link + "/products/addProduct",
				method: "POST",
				data: {
					prod_code: prod_code,
					prod_name: prod_name,
					price: price,
					stock: stock
				},
				success: function(data) {
					if (data == "0") {
						$(".code-validation").removeClass('hide');
					} else {
						$(".code-validation").addClass('hide');
						alert("Product Successfully Added!");
						location.reload();
					}
				}
			});
		}

		$('#addProductModal').on('hidden.bs.modal', function () {
	    	$("#txtProdCode").removeClass('required');
	    	$("#txtProdName").removeClass('required');
	    	$("#txtPrice").removeClass('required');
	    	$("#txtStock").removeClass('required');
	    	$("#requiredAlert").addClass('hide');
		});


		$("#txtProdCode").on('blur', function() {
			if ($(this).val() != ""){
				$(this).removeClass('required');
			}
		});
		$("#txtProdName").on('blur', function() {
			if ($(this).val() != ""){
				$(this).removeClass('required');
			}
		});
		$("#txtPrice").on('blur', function() {
			if ($(this).val() != ""){
				$(this).removeClass('required');
			}
		});
		$("#txtStock").on('blur', function() {
			if ($(this).val() != ""){
				$(this).removeClass('required');
			}
		});
		

	});

	$("#txtPrice").on('blur', function() {
		if ($(this).val() != "") {
			$(this).val(formatNumber($(this).val()));
		} else {
			$(this).val("");
		}	
	});

	$("#editPrice").on('blur', function() {
		if ($(this).val() != "") {
			$(this).val(formatNumber($(this).val()));
		} else {
			$(this).val("");
		}	
	});

	
	function formatNumber(number)
	{
		return number = parseFloat(number).toFixed(2);
	}


	$("#btnSaveEdit").on('click', function() {
		
		var prod_code = $("#editProdCode").val(),
			prod_name = $("#editProdName").val(),
			price = parseFloat($("#editPrice").val()),
			stock = $("#editStock").val(),
			prod_id = $("#editProdId").val();

		$.ajax ({

			url: link + "/products/editProduct",
			method: "POST",
			data: {

				prod_code: prod_code,
				prod_name: prod_name,
				price: price,
				stock: stock,
				prod_id: prod_id
			},
			success: function(data) {
				if (data == "0") {
					$(".code-validation").removeClass('hide');
				} else {
					$(".code-validation").addClass('hide');
					alert("Product Successfully Updated!");
					location.reload();
				}
			}
		});

	});

	bindEditClick();
	bindDeleteClick();

	function bindEditClick() {

		$(".btnEdit").on('click', function() {

			$.ajax({

				url: link + "/products/selectSingleProduct/" + $(this).data('id'),
				method: "POST",
				data: { },
				dataType: "json",
				success: function(data) {
					$("#editProdCode").val(data.product_code);
					$("#editProdName").val(data.prod_name);
					$("#editPrice").val(data.price);
					$("#editStock").val(data.stock);
					$("#editProdId").val(data.prod_id);
					$("#editProductModal").modal('show');
				}
			});

		});

	}

	function bindDeleteClick()
	{
		$(".btnDelete").on('click', function() {

			$.ajax ({

				url: link + "/products/deleteProduct/" + $(this).data('id'),
				method: "POST",
				data: { },
				success: function(data) {
					alert("Product Successfully Deleted");
					location.reload();
				}
			});
		});
		
	}

	$("#txtSearchProd").on('keyup', function() {
		var trHTML = '';

		$.ajax ({
			url: link + "/products/searchProduct",
			method: "POST",
			data: { 
				search: $(this).val()
			},
			dataType: "json",
			success: function(data) {
				$.each(data, function(idx, key){
			    	trHTML += '<tr><td>' + key.prod_id + '</td>';
			    	trHTML += '<td>' + key.product_code + '</td>';
			    	trHTML += '<td>' + key.prod_name + '</td>';
			    	trHTML += '<td>' + key.price + '</td>';
			    	trHTML += '<td>' + key.stock + '</td>';
			    	trHTML += '<td><a href="#" class="btnEdit" data-id='+ key.prod_id +'><i class="fa fa-pencil-square-o fa-2x" aria-hidden="true" style="color:#000000"></i></a>&nbsp;'
					trHTML += '<a href="#" class="btnDelete" data-id='+key. prod_id+'><i class="fa fa-trash o fa-2x" aria-hidden="true" style="color:#000000"></i></a>&nbsp;</td>';
			    	trHTML += '</tr>';
				});
				$("#productTable tbody").html(trHTML);
				bindEditClick();
				bindDeleteClick();
			}
		});
	});


	$("#txtMySearch").on('keyup', function(e) {
		var trHTML = '';

			$.ajax ({
				url: link + "/products/searchProduct",
				method: "POST",
				data: { 
					search: $(this).val()
				},
				dataType: "json",
				success: function(data) {
					$.each(data, function(idx, key){
				    	trHTML += '<tr><td>' + key.product_code + '</td>';
				    	trHTML += '<td>' + key.prod_name + '</td>';
				    	trHTML += '<td>' + key.price + '</td>';
				    	if (key.stock == 0)
				    	{
				    		trHTML += '<td class="lblstock">' + key.stock + '</td>';
				    	} else {
				    		trHTML += '<td>' + key.stock + '</td>';
				    	}
				    	trHTML += '</tr>';
					});
					$("#productTable tbody").html(trHTML);
				}
			});
	});

});