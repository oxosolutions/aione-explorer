
/** USERS NAMESPACE
 ======================================== */

var users = {};

users.displayInfo = function (userId) {
    var username    = $("#modal-username"),
        email       = $("#modal-email"),
        firstName   = $("#modal-first-name"),
        lastName    = $("#modal-last-name"),
        address     = $("#modal-address"),
        phone       = $("#modal-phone"),
        ajaxLoading = $("#ajax-loading"),
        detailsBody = $("#details-body"),
        modal       = $("#modal-user-details");

   //display modal
   modal.modal('show');

   // set username (title of modal window) to loading...
   username.text("Loading...");
   
   //display ajax loading gif
   ajaxLoading.show();
   
   //hide details body
   detailsBody.hide();
   
   $.ajax({
       url: "ASEngine/ASAjax.php",
       type: "POST",
       data: {
           action: "getUserDetails",
           userId: userId
       },
       success: function (result) {
           //parse result as JSON
           var res = JSON.parse(result);
           
           //update modal fields
           username .text(res.username);
           email    .text(res.email);
           firstName.text(res.first_name);
           lastName .text(res.last_name);
           address  .text(res.address);
           phone    .text(res.phone);
           
           //hide ajax loading
           ajaxLoading.hide();
           
           //display user info
           detailsBody.show();
       }
   });
   


};


/**
 * Deletes an user.
 * @param {object} element Clicked DOM element.
 * @param {int} userId Id of user that will be deleted.
 */
users.deleteUser = function (element, userId) {
        //get whole user row that will be deleted
	var userRow = $(element).parents(".user-row");
        
        //ask admin to confirm that he want to delete this user
	var c = confirm("Are you sure?");
	if(c) {
                //confimed
                
                //send data to server
		$.ajax({
			type: "POST",
			url: "ASEngine/ASAjax.php",
			data: {
				action: "deleteUser",
				userId: userId
			},
			success: function (result) {
				console.log(result);
                                
                                //remove user row from table
				userRow.fadeOut(600, function () {
					$(this).remove();
				});
			}
		});
	}
};


/**
 * Changes user's role.
 * @param {Object} Clicked DOM element.
 * @param {int} userId User ID.
 */
users.changeRole = function (element, role, userId) {
  console.log(role);
  //send data to server
	$.ajax({
		type: "POST",
		url: "ASEngine/ASAjax.php",
		data: {
			action: "changeRole",
			userId: userId,
      role  : role
		},
		success: function (newRole) {
      //change button text
			element.text(newRole);
		}
	});
};


users.roleChanger = function (element, userId) {
    $("#modal-change-role").modal({
        keyboard: false,
        backdrop: "static",
        show: true
    });

    console.log(userId);
   
   //find elements needed for changing text
    var userRoleSpan = $(element).parents(".btn-group").find(".user-role");

    $("#change-role-button").unbind().bind('click', function () {
        var newRole = $("#select-user-role").val();
        users.changeRole(userRoleSpan, newRole, userId);
    });
};
