<?php

$css_file_main = $folder_ext . 'css/style.css';
$css_file_accordian = $folder_ext . 'css/form_accordian.css';
$css_file = array($css_file_main, $css_file_accordian);
$js_helper = $folder_ext . 'js/submit.js';
$js_ajax = $folder_ext . 'js/checkInput.js';
$js_form_hints = $folder_ext . 'js/form_hints.js';
$js_ui = "//code.jquery.com/ui/1.11.4/jquery-ui.js";
$js_array = array($js_helper, $js_ajax, $js_form_hints, $js_ui);
require_once $folder_ext . 'php/create_helper.php';
require_once $folder_ext . 'locales/labels.php';
// this will start a connection for us.
// all connection stuff is then done with $database
require_once $folder_ext . 'php/db/connection.php';

// php global variables
$html_input = "";
$html_form = "";
$head_input = "";
$required = "required";
$get_row = NULL;
$paragraph_desc = "";

try
{
	// user can copy a previous ability by setting GET
	// edit expects GET data
	$provided_data = $_GET['data'];
	
	if ($mode === 'edit')
	{
		
		if (!isset($provided_data) || empty($provided_data))
		{
			// redirect
			$status = "You cannot access the edit page directly.";
			header("Location: ../index.php?status=$status");
			exit(createErrorPage($css_file));
		}
		
		// retrieve the row
		$sql = 'SELECT * FROM '.$table_name.' WHERE '.$unique_id.'=:data';
		$statement = $database->prepare($sql);
		//	$post['column'] = 'data' --> $post['data'] = actual_data
		$statement->bindParam(':data', htmlspecialchars($provided_data));	
		$statement->execute();	
		$get_row = $statement->fetch(PDO::FETCH_ASSOC);
		
		// item must exist if we are editing it
		if (empty($get_row))
		{
			exit(createErrorPage($css_file));
		}
		
		$title = "Edit " . $singular_tag_cap;
		$form_id = $table_name . '_edit';
	}
	else
	{
		if (isset($provided_data) && !empty($provided_data))
		{
			$sql = 'SELECT * FROM '.$table_name.' WHERE '.$unique_id.'=:data';
			
			$statement = $database->prepare($sql);
			//	$post['column'] = 'data' --> $post['data'] = actual_data
			$statement->bindParam(':data', htmlspecialchars($provided_data));	
			$statement->execute();	
			$get_row = $statement->fetch(PDO::FETCH_ASSOC);
			
			// item must be unique
			if (empty($get_row))
			{
				exit(createErrorPage($css_file));
			}
		}
		
		$title = "Create New " . $singular_tag_cap;
		$form_id = $table_name;
		$paragraph_desc = $paragraph_desc_create;
	}
	
	$head_input = createHead($title, "", $css_file, $js_array);
	
	////
	// create the form
	$html_form .= '<form id="'.$form_id.'">';
	$html_form .= '<fieldset id="accordian-form">';
	
	// create a hidden input to store the input's name so we can know not to check it for uniqueness if the user has copied the form
	$unique_id_original = "original_" . $unique_id;
	$html_form .= createHiddenInput($get_row[$unique_id], $form_id, $unique_id_original);
	
	$unqiue_id_value = $singular_tag_cap . ' '.$unique_id.':';
	$html_form .= createTextInput($get_row[$unique_id], $form_id, $unique_id, $unqiue_id_value, "140", $required, $L_NAME_HINT);
}
catch (PDOException $e)
{
	$html_input = '<p style="color:red">ERROR:'.$e.'</p>';
}

function endForm()
{
	$html_form .= '</fieldset>'; 
	$html_form .= '<div class="hold_btn"><input id="'.$form_id.'_submit" class="btn confirm-btn" name="submit-button" type="submit" value="Submit"></div>';
	$html_form .= '<div class="hold_btn"><input class="btn danger-btn" name="reset-button" type="reset" value="Reset"></div>';
	$html_input .= $html_form;
}

function addHTML()
{
echo <<<HTML_TEXT
<!doctype html> 
<html>
	$head_input
<body>
	<div id="status" class="note"></div>
	<div class="page-container page-small">
		<h1>$title</h1>
		<p>$paragraph_desc</p>
		<hr>
		$html_input
		
		<!--<div id="status"></div>-->
	</div>
</body>
</html>
HTML_TEXT;
}


?>

