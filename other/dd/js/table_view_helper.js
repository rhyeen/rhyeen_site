/**
 * Ryan Saunders
 */
// on page load...
$(function(){
	$(".accordion").accordion({
		collapsible: true,
		heightStyle: "content"	
	});
	
	$(".icon").click(function(e) {
		
		var id = $(this).parent().attr('id');
		var index = id.indexOf('_');
		var name = id.substring(0, index);
		var action = id.substring(index+1);
		name = insertSpace(name);
		if(action === 'delete')
		{
			showDeleteBox(name);
		}
		else if(action === 'edit')
		{
			window.location.href = "edit/index.php?data=" + name;
		}
	});
	

});

function getIcon(part_id, extra_class)
{
	return '<div class="icon ' + extra_class + '"><svg viewBox="0 0 32 32"><use xlink:href="#' + part_id + '_icon"></use></svg></div>';	
}

function showDeleteBox(name)
{
	var text = 'Delete ' + name + '?';
	var html_input = '<div class="popup-box">';
	html_input += getIcon('attention', 'icon_color_inform');
	html_input += '<p style="text-align:center">'+text+'</p>'
	html_input += '<div class="hold_all_btn">';
	html_input += '<div class="hold_btn"><button id="'+name+'_confirmdelete" class="btn danger-btn confirm">Delete</button></div>';
	html_input += '<div class="hold_btn_right"><button class="btn confirm">Cancel</button></div>';
	html_input += '</div></div>';
	$("#extra").html(html_input);
	
	$(".confirm").click(function(e) {
		var id = e.target.id;
		var index = id.indexOf('_');
		var action = id.substring(index+1);
		var name = id.substring(0, index);
		if(action === 'confirmdelete')
		{
			sendDelete(name);
			$("#extra").html("");
		}
		// assume it was a cancel
		else
		{
			$("#extra").html("");
		}
	});
}

////
// because id or class cannot have space, we needed to add SPC as a space
// now we should correct the space as expected
function insertSpace(value)
{
	var regex = new RegExp('SPC', 'g');
	return value.replace(regex, ' ');
}

////
// because id or class cannot have space, we need to add SPC as a space
function removeSpace(value)
{
	return value.replace(/\s/g, 'SPC');
}

////
// assumes there is a .unique-id element that contains #table_column
function sendDelete(name)
{
	var id = $(".unique-id").attr('id');
	
	if(typeof id === 'undefined')
	{
		$("#status").html("<p>This page is not set up correctly.</p>");
		return;
	}
	
	var index = id.indexOf('_');
	var column = id.substring(index+1);
	var table = id.substring(0, index);
	
	$.ajax(
	{
		type:'POST',
		url: '../php/deleteEntry.php',
		// $_POST['data'] = data
		data: {
			table: table,
			column: column,
			data: name
			},
		// expected return type
		dataType: "json",
		success: function(response)
		{
			if(response.status === 'OK') {
				// remove entry from table
				accordchild = removeSpace(name);
				accordchild = "#" + accordchild + "_accordchild";
				$(accordchild).next().remove();
				$(accordchild).remove();
			}
			else {
				$("#status").html('<p>'+response.message+'</p>');
			}
		},
		error: function( response, options, error )
		{
			$("#status").html('<p>Something went wrong. Contact the webmaster and provide the following error:<br>' + error + '</p>');
		}
	});

    // return false to disable the submit button
    return false;
	
}