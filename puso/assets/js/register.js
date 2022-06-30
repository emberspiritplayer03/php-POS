$(document).ready(function(){


$("#btnRegister").on('click', function() {

	var last_name = $("#txtLastName").val(),
		middle_name = $("#txtMiddleName").val(),
		first_name = $("#txtFirstName").val();


	if ($('#yes').is(":checked")) {

		$.ajax ({

			url: link + "/register/compareMember",
			method: "POST",
			data: {
				lastName: last_name,
				middleName: middle_name,
				firstName: first_name
			},
			success: function(data) {
				console.log(data);
			}
		});


	}
});

});