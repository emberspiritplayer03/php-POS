$(document).ready(function(){

	$("#txtUsername").on('keyup', function() {
		if ($(this).val().length == 0)
		{
			$('.message').addClass('hide');
		}
	});

	$("#txtPassword").on('keyup', function() {
		if ($(this).val().length == 0)
		{
			$('.message').addClass('hide');
		}
	});

	$("#btnLogin").on('click', function(){

		var userName = $("#txtUsername").val(),
			password = $("#txtPassword").val();

		$.ajax ({

			url: link + "/login/checkLogin",
			method: "POST",
			data: {
				userName: userName,
				password: password
			},
			success: function(data) {
				
				if (data == "user") {
					location.href = link + "/UserHome";
				} else if (data == "admin") {
					location.href = link + "/welcome";
				} else if (data == "0"){
					$(".message").text("Incorrect Username/Password");
					$(".message").removeClass('hide').fadeIn('slow');
				}
				
			}

		});
	});

});
