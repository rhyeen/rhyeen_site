<?php

$css_file_main = $folder_ext . 'css/style.css';
$css_file_accordian = $folder_ext . 'css/table_accordian.css';
$css_file = array($css_file_main, $css_file_accordian);
require_once $folder_ext . 'php/create_helper.php';
$js_helper = $folder_ext . 'js/table_view_helper.js';
$js_ui = "//code.jquery.com/ui/1.11.4/jquery-ui.js";

// this will start a connection for us.
// all connection stuff is then done with $database
require_once $folder_ext . 'php/db/connection.php';
require_once $folder_ext . 'php/icons/get_icons.php';

// php global variables
$html_input = "";
$head_input = "";
$status_input = "";
$id_input = "";
$before_body_input = "";
try
{
	//$_GET['status'] = 'Test';
	
	if (!empty($_GET['status']))
	{
		// for determining which table/column to lookup in sql
		$status_input = '<p>'.$_GET['status'].'</p>';
	}
	
	$id_input = $table_name .'_'. $unique_id;
	
	$sql = 'SELECT * FROM '.$table_name;
	
	$statement = $database->prepare($sql);
	$statement->execute();	
	$all_rows = $statement->fetchAll(PDO::FETCH_ASSOC);
	
	// TODO: if empty, it should just display a blank list with the ability to add more
	// item must be unique
	if (empty($all_rows))
	{
		exit(createErrorPage($css_file));
	}

	$title = "View " . $plural_tag;
	$head_input = createHead($title, "", $css_file, array($js_helper, $js_ui));

	$accordian_sections = array();
	foreach($all_rows as $row)
	{
		//								 exceptions
		$temp = createTableSection($row, $exceptions_to_accordian_content);
		$accordian_sections[] = createAccordionSection($row[$unique_id], $temp);
	}
	
	$accordian_input = createAccordion('accordion', 'accordion', $accordian_sections);
	$before_body_input .= getIcons();
	$html_input .= $accordian_input;

}
catch (PDOException $e)
{
	$html_input = '<p style="color:red">ERROR:'.$e->getMessage().'</p>';
}

echo <<<HTML_TEXT
<!doctype html> 
<html>
	$head_input
	
<body>
	$before_body_input

	<div id="extra"></div>
	<div id="status" class="note">$status_input</div>
	
	<div class="page-container page-small">
		
		<h1>$plural_tag</h1>
		<a href="create/index.php"><div class="hold_btn_right"><button class="btn confirm-btn">Create $singular_tag</button></div></a>
		<br>
        <hr>
		
    	$html_input
		
		
    </div>
	<!-- for determining which table/column to lookup in sql -->
	<div id="$id_input" class="unique-id" hidden></div>
</body>
</html>
HTML_TEXT;

?>