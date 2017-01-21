function validateFirstName() {
	if ($('#fn').val().length == 0) {
		displayErrorMessage("First Name is required");
		$('#fn').addClass("error");
	} else {
		$('#fn').removeClass("error");
	}
}

function validateLastName() {
	if ($('#ln').val().length == 0) {
		displayErrorMessage("Last Name is required");
		$('#ln').addClass("error");
	} else {
		$('#ln').removeClass("error");
	}
}

function validateMiddleInitial() {
	var miLength = $('#mi').val().length;
	if (miLength > 1) {
		if (!miLength < 3) {
			displayErrorMessage("Last Name is required");
			$('#mi').addClass("error");
		}
	} else {
		$('#mi').removeClass("error");
	}
}

function validatePhoneNumber() {
	var phone = $('#phone').val().replace(/\D+/g, '');
	$('#phone').val(phone); // = phone;
	if (phone.length != 10) {
		displayErrorMessage("First Name is required");
		$('#phone').addClass("error");
	} else {
		$('#phone').removeClass("error");
	}

}

function validateEmail() {
	var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
	if (!emailReg.test($('#em').val())) {
		displayErrorMessage("First Name is required");
		$('#em').addClass("error");
	} else {
		$('#em').removeClass("error");
	}
}

function displayValidationError(errMsg) {
	alert(errMsg);
}