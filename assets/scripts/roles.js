

var roles = {};

roles.addRole = function () {
	asengine.removeErrorMessages();
	var role = $("#role-name");

	if($.trim(role.val()) == "") {
		asengine.displayErrorMessage(role);
		return;
	}

	$.ajax({
		url: 'ASEngine/ASAjax.php',
		type: 'POST',
		data: {
			action: "addRole",
			role  : role.val()
		},
		success: function (result) {
			try {
				var res = JSON.parse(result);

				if(res.status == "success") {
					var html  = '<tr class="role-row">';
					html += '<td>'+role.val()+'</td>';
					html += '<td>0</td>';
					html += '<td><button type="button" class="btn btn-danger btn-sm" onclick="roles.deleteRole(this,'+res.roleId+');">';
					html += '<i class="icon-trash glyphicon glyphicon-trash"></i> Delete';
					html += '</button>';
					html += '</td>';
					html += '</tr>';

					$(".roles-table").append(html);
				}
				else
					asengine.displayErrorMessage(role, res.message);
			}
			catch(e) {
				alert('Error while updating database.')
			}
			


		}
	});
		
}


roles.deleteRole = function (element, roleId) {
	var t = confirm("Are you sure?");
	if(t) {
		$.ajax({
			url: 'ASEngine/ASAjax.php',
			type: 'POST',
			data: {
				action: "deleteRole",
				roleId: roleId
			},
			success: function () {
				$(element).parents(".role-row").fadeOut("slow", function () {
					$(this).remove();
				});
			}
		});
	}
};