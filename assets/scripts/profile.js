$(document).ready(function () {
	$(".form-horizontal").submit(function () {
    	return false;
    });
     $("#change_password").click(function () { 
        if(profile.validatePasswordUpdate())
            profile.updatePassword(); 
    });
    $("#update_details").click(function () {
        profile.updateDetails();
    });
});



/** PROFILE NAMESPACE
 ======================================== */

var profile = {};


/**
 * Updates user password.
 */
profile.updatePassword = function() {
        //turn on button loading state
        asengine.loadingButton($("#change_password"), "Updating...");
    
        //encrypt passwords before sending them through the network
	var newPass = CryptoJS.SHA512($("#new_password").val()).toString();
	var oldPass = CryptoJS.SHA512($("#old_password").val()).toString();
        
        //send data to server
	$.ajax({
		url: "ASEngine/ASAjax.php",
		type: "POST",
		data: {
			action	 : "updatePassword",
			oldpass  : oldPass,
			newpass  : newPass
		},
		success: function (result) {
                        //return button to normal state
                        asengine.removeLoadingButton($("#change_password"));
                        
			if(result == "") {
                                //display success message
				asengine.displaySuccessMessage(
                                        $("#form-changepassword"),
                                        "Password updated successfully."
                                    );
			}
			else {
                                //display error message
				asengine.displayErrorMessage($("#old_password"), result);
			}
		}
	});
};


/**
 * Validate password update form.
 * @returns {Boolean} TRUE if form is valid, FALSE otherwise.
 */
profile.validatePasswordUpdate = function () {
    
        //remove all error messages if there are some
	asengine.removeErrorMessages();
	
        //get all data from form
	var oldpass  = $("#old_password"),
            newpass  = $("#new_password"),
            confpass = $("#new_password_confirm"),
            valid    = true;
		
        //check if field is empty
	if($.trim(oldpass.val()) == "") {
		valid = false;
		asengine.displayErrorMessage(oldpass, "Field cannot be empty!");
	}
	
        //check if field is empty
	if($.trim(newpass.val()) == "") {
		valid = false;
		asengine.displayErrorMessage(newpass, "Field cannot be empty!");
	}
	
        //check if field is empty
	if($.trim(confpass.val()) == "") {
		valid = false;
		asengine.displayErrorMessage(confpass, "Field cannot be empty!");
	}
	
        //check if password and confirm new password are equal
	if($.trim(confpass.val()) != $.trim(newpass.val()) ) {
		valid = false;
		asengine.displayErrorMessage(newpass);
		asengine.displayErrorMessage(confpass, "Passwords don't match.");
	}
	
	return valid;
	
};


/**
 * Updates user details.
 */
profile.updateDetails = function () {
        //remove error messages if there are any
	asengine.removeErrorMessages();
        
        //turn on button loading state
        asengine.loadingButton($("#update_details"), "Updating...");
        
        //prepare data that will be sent to server
	var data = {
		action : "updateDetails",
		details: {
			first_name: $("#first_name").val(),
			last_name : $("#last_name").val(),
			address	  : $("#address").val(),
			phone	  : $("#phone").val(),
			dibs_merchant_id : $("#dibs_merchant_id").val()
		}
	};
        
        //send data to server
	$.ajax({
		url: "ASEngine/ASAjax.php",
		type: "POST",
		data: data,
		success: function (result) {
                        //return button to normal state
                        asengine.removeLoadingButton($("#update_details"));
                        
			if(result == "") {
				asengine.displaySuccessMessage($("#form-details"),"Details updated successfully.");
			}
			else {
                                //display error messages
				console.log(result);
				asengine.displayErrorMessage($("#form-details input"));
				asengine.displayErrorMessage(
                                        $("#phone"), 
                                        "Error while updating database. Please try again."
                                    );
			}
		}
	});
};