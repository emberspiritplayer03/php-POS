$(document).ready(function(){



	$('#btnSave').on('click', function() {

		var lastName = $("#txtLastName").val(),
			middleName = $("#txtMiddleName").val(),
			firstName = $("#txtFirstName").val(),
			gender = $("#dropdownGender").val(),
			userName = $("#txtAdminUName").val(),
			password = $("#txtAdminPass").val();


			$.ajax({

				url: link + "/admins/addAdmin",
				method: "POST",
				data: {
					lastName: lastName,
					middleName: middleName,
					firstName: firstName,
					gender: gender,
					userName: userName,
					password: password
				},
				success: function(data) {
					if ( data == "true") {
						location.reload();
						alert("Admin Successfully Added!");
					}	
				}

			});
	});

	$("#txtAdminUName").on('blur', function() {

		var userName = $(this).val();

		$.ajax({

			url: link + "/admins/checkIfUsernameExist",
			method: "POST",
			data: {
				username: userName,
			},
			success: function(data) {
				if (data == "1") {
					$(".uname-exist").removeClass('hide');
					$("#btnSave").prop("disabled", "true");
				} else {
					$(".uname-exist").addClass('hide');
					$("#btnSave").prop("disabled", false);
				}
			}

		});

	});

	$(".btnEdit").on('click', function() {

			$.ajax({

				url: link + "/admins/fetchSingleAdmin/" + $(this).data('id'),
				method: "POST",
				data: {
				},
				dataType: "json",
				success: function(data) {
					$("#txtEditLastName").val(data.last_name);
					$("#txtEditMiddleName").val(data.middle_name);
					$("#txtEditFirstName").val(data.first_name);
					$("#dropdownEditGender").val(data.gender);
					$("#txtEditAdminUName").val(data.username);
					$("#txtEditAdminPass").val(data.password);
					$("#editHiddenId").val(data.user_id);

					$("#editAdminModal").modal("show");
				}

			});

	});

	$("#btnSaveAdmin").on('click', function() {

		var lastName = $("#txtEditLastName").val(),
			middleName = $("#txtEditMiddleName").val(),
			firstName = $("#txtEditFirstName").val(),
			gender = $("#dropdownEditGender").val(),
			userName = $("#txtEditAdminUName").val(),
			password = $("#txtEditAdminPass").val(),
			user_id = $("#editHiddenId").val();

			$.ajax({

				url: link + "/admins/editAdmin",
				method: "POST",
				data: {
					lastName: lastName,
					middleName: middleName,
					firstName: firstName,
					gender: gender,
					userName: userName,
					password: password,
					user_id: user_id
				},
				success: function(data) {
					if ( data == "true") {
						location.reload();
						alert("Admin Successfully Edited!");
					}	
				}

			});
	});


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

});