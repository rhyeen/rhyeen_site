/**
 * Ryan Saunders
 */
 
/* Attempted, didn't work.  Can try later.
// all inputs that errored when they came back from the failed submission
// this is used to remove errors that are fixed after a resubmission
var previous_errored_input = [];
var previous_errored_tooltip = [];*/
// on page load...
$(function(){
	submitForm('ability');
	submitForm('skill');
	submitForm('item');
	
	// make it so buttons don't get focus boxes
	$(".btn").click(function(e) {
		$(this).blur();
	});
});

function submitForm(table)
{
	// prevent form from submitting
	var table_id = "#" + table;
	$(table_id).submit(function(e) {
		e.preventDefault();
		var id = "#" + e.target.id;
		// submit through ajax
		var url = '../php/create.php';
		$("#status").html("<p>Sending to server...</p>");
		sendFormToServer(id, url);
	});
	
	// prevent form from submitting
	var table_id_edit = "#" + table + "_edit";
	$(table_id_edit).submit(function(e) {
		e.preventDefault();
		var id = "#" + e.target.id;
		// submit through ajax
		//$("#status").html("<p>Sending to server...</p>");
		var url = '../php/edit.php';
		sendFormToServer(id, url);
	});
}

function capitalizeFirst(string)
{
	return string.charAt(0).toUpperCase() + string.slice(1);
}

function sendFormToServer(form_id, url)
{	
	$.ajax(
	{
		type:'POST',
		url: url,
		// $_POST['data'] = data
		data: $(form_id).serialize(),
		// expected return type
		dataType: "json",
		success: function(response)
		{
			if(response.status === 'OK') {
				// if it is the edit page, redirect to view page with status update
				if (form_id.indexOf("_edit") >= 0) {
					var status = response.message
					window.location.href = "../index.php?status=" + status;
				}
				else
					$("#status").html("<p>"+ response.message +"</p>");
			}
			else {
				if(response.error !== null && typeof response.error !== 'undefined') {
					/*
					// remove all previous errors
					var i;
					for(i = 0; i < previous_errored_input.length; i++) {
						$(previous_errored_input[i]).removeClass();
					}
					previous_errored_input = [];
					
					for(i = 0; i < previous_errored_tooltip.length; i++) {
						$(previous_errored_tooltip[i]).removeClass();
						$(tooltip).addClass("input_tooltip");
					}
					previous_errored_tooltip = [];*/
					
					$.each(response.error, function(key, value) {
						$("#status").html('<p class="error">'+key+value+'</p>');
						var id = "#" + key + "_" + form_id.slice(1);
						
						var tooltip = id + "_tooltip";
						$(id).removeClass();
						$(id).addClass("input_error");
						$(tooltip).html(value);
						$(tooltip).removeClass();
						$(tooltip).addClass("input_tooltip");
						$(tooltip).addClass("input_tooltip_error");
						
						/*
						// add to previous error list
						previous_errored_input.push(id);
						previous_errored_tooltip.push(tooltip);*/
					});
				}
				$("#status").html('<p class="error">'+response.message+'</p>');
			}
		},
		error: function( response, options, error )
		{
			$("#status").html('<p class="error">Something went wrong. Contact the webmaster and provide the following error:<br>' + error + '</p>');
		}
	});

    // return false to disable the submit button
    return false;
}