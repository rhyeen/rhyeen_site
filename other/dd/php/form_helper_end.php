<?php

$html_form .= '</fieldset>'; 
$html_form .= '<div class="hold_btn"><input id="'.$form_id.'_submit" class="btn confirm-btn" name="submit-button" type="submit" value="Submit"></div>';
$html_form .= '<div class="hold_btn"><input class="btn danger-btn" name="reset-button" type="reset" value="Reset"></div>';
$html_form .= '<div class="hold_btn"><input class="btn" name="back-button" type="button" value="Go Back" onclick="window.location.href=\'../index.php\'"></div>';
$html_input .= $html_form;

require_once $folder_ext . 'php/icons/get_icons.php';
$before_body_input .= getIcons();

echo <<<HTML_TEXT
<!doctype html> 
<html>
	$head_input
<body>
	$before_body_input

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

?>

