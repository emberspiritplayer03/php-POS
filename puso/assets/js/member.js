$(document).ready(function(){

	bindEditClick();
	bindDeleteClick();

	$('#btnSave').on('click', function() {

		var lastName = $("#txtLastName").val(),
			middleName = $("#txtMiddleName").val(),
			firstName = $("#txtFirstName").val(),
			address = $("#txtAddress").val(),
			gender = $("#dropdownGender").val();


			$.ajax({

				url: link + "/members/add",
				method: "POST",
				data: {
					lastName: lastName,
					middleName: middleName,
					firstName: firstName,
					address: address,
					gender: gender
				},
				success: function(data) {
					if ( data == "true") {
						location.reload();
						alert("Member Successfully Added!");
					}	
				}

			});
	});

	function bindEditClick()
	{
		$('.btnEdit').on('click', function() {

			$.ajax({

				url: link + "/members/selectSingle/"+ $(this).data('id'),
				method: "GET",
				dataType: "json",
				data: { },
				success: function(data) {
					$(".editTitle").text("Edit Member Profile of: " + data.username);
					$('#editLastName').val(data.last_name);
					$('#editMiddleName').val(data.middle_name);
					$('#editFirstName').val(data.first_name);
					$('#editAddress').val(data.address);
					$('#editdropdownGender').val(data.gender);
					$('#editUserId').val(data.user_id);
					$('#editModal').modal('show');
				}

			});
		});

	}

	function bindDeleteClick()
	{
		$(".btnDelete").on('click', function() {
			$.ajax ({
				url: link + "/members/deleteMember/" + $(this).data('id'),
				method: "POST",
				data: { },
				success: function(data) {
					if (data == "true") {
						location.reload();
						alert('Member Deleted');
					}	
				}
			});
		});
		
	}
	
	$('#btnSaveEdit').on('click', function() {

		var lastName = $("#editLastName").val(),
			middleName = $("#editMiddleName").val(),
			firstName = $("#editFirstName").val(),
			address = $("#editAddress").val(),
			gender = $("#editdropdownGender").val(),
			user_id = $("#editUserId").val();

		$.ajax ({
			url: link + "/members/editMember",
			method: "POST",
			data: {
				user_id: user_id,
				lastName: lastName,
				middleName: middleName,
				firstName: firstName,
				address: address,
				gender: gender
			},
			success: function(data) {
				if (data == "true") {
					location.reload();
					alert('edited successfully');
				}	
			}
		});
	});

	
	
	$("#txtSearchMember").on('keyup', function(e) {
		var trHTML = '',
			value = $(this).val(),
			minlength = 3;

			$.ajax ({
				url: link + "/members/searchMember",
				method: "POST",
				data: { 
					search: $(this).val()
				},
				dataType: "json",
				success: function(data) {
					$.each(data, function(idx, key){
				    	trHTML += '<tr><td>' + key.username + '</td>';
				    	trHTML += '<td>' + key.last_name + '</td>';
				    	trHTML += '<td>' + key.middle_name + '</td>';
				    	trHTML += '<td>' + key.first_name + '</td>';
				    	trHTML += '<td>' + key.address + '</td>';
				    	trHTML += '<td>' + key.gender + '</td>';
						trHTML += '<td><center><a href="#" class="btnEdit" data-id='+key.user_id+'><i class="fa fa-pencil-square-o fa-2x" style="color:#000000" aria-hidden="true"></i> </a>';
						trHTML += '<a href="#" class="btnDelete" data-id='+key.user_id+'><i class="fa fa-trash fa-2x" style="color:#000000" aria-hidden="true"></i> </a></td>';
				    	trHTML += '</tr>';
					});
					$("#memberTable tbody").html(trHTML);
					bindEditClick();
					bindDeleteClick();
				}
			});
	});


});