/**
 * Ryan Saunders
 */
 var expanded_data = "";
 
// on page load...
$(function(){
	checkIfUnique('name', 'ability');
	checkIfUnique('name', 'skill');
	checkIfUnique('name', 'item');
	expandDatalist('name', 'item');

	checkDatalist();
	checkDiceInput();
	
});

function checkDiceInput()
{
	$(document).ready(function() {
        // check if the given dice is actually a valid dice combination
		// need to do the event handler this way so that it will fire when dynamically added elements match this event handler.  
		//Also required is the $(document).ready(function()...
		$(document).on("blur", '.input_dice', function(e) {
			var id = "#" + e.target.id;			
			var tooltip = id + "_tooltip";
			
			var input_val = $(this).val();
			if(input_val.length !== 0) {
				var dice_regex = /^((\d+)?(d)(4|6|8|10|12|20|2)(([-+*\/])(\d+))?)$|^(\d+)$/;
				if(dice_regex.test(input_val.replace(/ /g,'')))
				{
					$(id).removeClass();
					$(id).addClass("input_dice");
					$(id).addClass("input_confirmed");
					$(tooltip).html("");
					$(tooltip).removeClass();
					$(tooltip).addClass("input_tooltip");
				}
				else
				{
					$(id).removeClass();
					$(id).addClass("input_dice");
					$(id).addClass("input_error");
					$(tooltip).html("Must match dice structure (e.g. 2d6+1).");
					$(tooltip).removeClass();
					$(tooltip).addClass("input_tooltip");
					$(tooltip).addClass("input_tooltip_error");
				}
			}
			else {
				$(this).removeClass();
				$(id).addClass("input_dice");
				$(tooltip).html("");
				$(tooltip).removeClass();
				$(tooltip).addClass("input_tooltip");
			}
		});
	});
}


function checkDatalist()
{
	$(document).ready(function() {
        // check if input was actually in the datalist
		// need to do the event handler this way so that it will fire when dynamically added elements match this event handler.  
		//Also required is the $(document).ready(function()...
		$(document).on("blur", '.input_datalist', function(e) {
		//$('.input_datalist').on("blur", function(e) {
			var id = "#" + e.target.id;
			// get rid of _input
			
			var datalist_option = id + "_datalist" + " option";
			var tooltip = id + "_tooltip";
			
			var input_val = $(this).val();
			if(input_val.length !== 0) {
				// check if it matches an item in the options list
				var found_match = $(datalist_option).filter(function() {
					return this.value == input_val;
				}).val();
		
				if(found_match) {
					$(id).removeClass();
					$(id).addClass("input_datalist");
					$(id).addClass("input_confirmed");
					$(tooltip).html("");
					$(tooltip).removeClass();
					$(tooltip).addClass("input_tooltip");
				}
				else {
					$(id).removeClass();
					$(id).addClass("input_datalist");
					$(id).addClass("input_error");
					$(tooltip).html("Must be an item from the dropdown");
					$(tooltip).removeClass();
					$(tooltip).addClass("input_tooltip");
					$(tooltip).addClass("input_tooltip_error");
				}
			}
			else {
				$(this).removeClass();
				$(id).addClass("input_datalist");
				$(tooltip).html("");
				$(tooltip).removeClass();
				$(tooltip).addClass("input_tooltip");
			}
		});
    });
}

function expandDatalist(unique_id, table)
{
	// if the beginning value isn't blank, we are editing and should expand the form.
	if($('.input_datalist_expand').val())
	{
		expandForm($('.input_datalist_expand').val(), unique_id, table);
	}
	
	
	
	// only expand if the input value has actually changed.
	// so everytime the box if focues, record what the value was
	// before it loses focus
	$('.input_datalist_expand').focus(function(e) {
		expanded_data = $(this).val();
	});
	
	// check if input was actually in the datalist
	// if in datalist, expand form to include new fields
	// only expand if the input value has actually changed.
	// based on the selected value.
	$('.input_datalist_expand').blur(function(e) {
		var id = "#" + e.target.id;		
		var datalist_option = id + "_datalist" + " option";
		var tooltip = id + "_tooltip";
		
		var input_val = $(this).val();
		if(input_val.length !== 0 && expanded_data !== input_val) {
			// check if it matches an item in the options list
			var found_match = $(datalist_option).filter(function() {
				return this.value == input_val;
			}).val();
	
			if(found_match) {
				$(id).removeClass();
				$(id).addClass("input_confirmed");
				$(tooltip).html("");
				$(tooltip).removeClass();
				$(tooltip).addClass("input_tooltip");
				expandForm(input_val, unique_id, table);
			}
			else {
				$(id).removeClass();
				$(id).addClass("input_error");
				$(tooltip).html("Must be an item from the dropdown");
				$(tooltip).removeClass();
				$(tooltip).addClass("input_tooltip");
				$(tooltip).addClass("input_tooltip_error");
			}
		}
		else {
			$(this).removeClass();
			$(tooltip).html("");
			$(tooltip).removeClass();
			$(tooltip).addClass("input_tooltip");
		}
	});
}

function checkIfUnique(unique_id, table)
{
	var id_check = '#' + unique_id + '_' + table;
	$(id_check).blur(function(e) {
		var id = "#" + e.target.id;
		var tooltip = id + "_tooltip";
		if($(this).val().length !== 0) {
			sendInputToServer(table, unique_id, $(this).val(), id, '../../php/checkInputUnique.php');
		}
		else {
			$(this).removeClass();
			$(tooltip).html("");
			$(tooltip).removeClass();
			$(tooltip).addClass("input_tooltip");
		}
	});
	
	var id_check_edit = '#' + unique_id + '_' + table + '_edit';
	$(id_check_edit).blur(function(e) {
		var original_name_id = '#original_' + unique_id + '_' + table + '_edit';
		var original_name = $(original_name_id).val();
		//$("#status").html($(this).val() + " " + original_name);
		var id = "#" + e.target.id;
		var tooltip = id + "_tooltip";
		if($(this).val().length !== 0) {
			if($(this).val() !== original_name)
				sendInputToServer(table, unique_id, $(this).val(), id, '../../php/checkInputUnique.php');
		}
		else {
			$(this).removeClass();
			$(tooltip).html("");
			$(tooltip).removeClass();
			$(tooltip).addClass("input_tooltip");
		}
	});
}

function expandForm(selected_data, unique_id, table)
{
	// get the edit's unique_id and send that as well
	var original_unique_id = '#original_' + unique_id + '_' + table + '_edit';
	var original_id = $(original_unique_id).val();
	
	$.ajax(
	{
		type:'POST',
		url: '../php/expand.php',
		// $_POST['data'] = data
		data: {
			data: selected_data,
			id: original_id,
			form: table
			},
		// expected return type
		dataType: "json",
		success: function(response)
		{
			if(response.status === 'OK') {
				var expand_id = "#" + table + "_expand";
				$(expand_id).html(response.form_extra);
				
				// refresh the accordion to include the new fields
				$("#accordian-form").accordion("refresh");
			}
			else {
				$("#status").html('<p class="error">Something went wrong. Contact the webmaster and provide the following error:<br>' + response.message + '</p>');
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

function sendInputToServer(table, column, data, input_id, url)
{	
	var tooltip = input_id + "_tooltip";
	$.ajax(
	{
		type:'POST',
		url: url,
		// $_POST['data'] = data
		data: {
			table: table,
			column: column,
			data: data
			},
		// expected return type
		dataType: "json",
		success: function(response)
		{
			if(response.status === 'OK') {
				$(input_id).removeClass();
				$(input_id).addClass("input_confirmed");
				$(tooltip).html("");
				$(tooltip).removeClass();
				$(tooltip).addClass("input_tooltip");
			}
			else {
				if(response.error !== null) {
					$.each(response.error, function(key, value) {
						$(input_id).removeClass();
						$(input_id).addClass("input_error");
						$(tooltip).html(value);
						$(tooltip).removeClass();
						$(tooltip).addClass("input_tooltip");
						$(tooltip).addClass("input_tooltip_error");
					});
				}
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