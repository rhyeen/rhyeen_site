<?php
// assumes $mode is set
// variables
$folder_ext = '../../';
$singular_tag_cap = 'Item';
$table_name = 'item';
$unique_id = 'name';
$paragraph_desc_edit = "";
$paragraph_desc_create = 'Items are objects that can be carried and used by characters.';

// assumes $mode is set
require_once $folder_ext . 'php/form_helper_start.php';


$html_form .= createNumberInput($get_row['weight'], $form_id, "weight", "Weight (lbs):", "10000", "0", NULL, $L_NUMBER_HINT.'<br>'.$L_WEIGHT_HINT);
$html_form .= createNumberInput($get_row['value'], $form_id, "value", "Value (gold):", "1000000", "0", NULL, $L_NUMBER_HINT.'<br>'.$L_VALUE_HINT);

// get ability types from server
$sql = "SELECT * FROM itemType GROUP BY primaryType";
$statement = $database->prepare($sql);
$statement->execute();
$query_results = $statement->fetchAll(PDO::FETCH_ASSOC);

$html_form .= createDatalistInputExpand($get_row['primaryType'], $form_id, "primaryType", "Primary type:", $required, $query_results, "primaryType", $L_DATALIST_HINT.'<br>'.$L_PRIMARY_TYPE_ITEM_HINT);

// extra area where all the expanded form fields can go
$html_form .= '<div id="'.$table_name.'_expand"></div>';


$html_form .= createTextareaInput($get_row['description'], $form_id, "description", "Description:", "7", $required, $L_DESCRIPTION_HINT);

require_once $folder_ext . 'php/form_helper_end.php';

?>