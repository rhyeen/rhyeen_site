<?php
// assumes $mode is set
// variables
$folder_ext = '../../';
$singular_tag_cap = 'Ability';
$table_name = 'ability';
$unique_id = 'name';
$paragraph_desc_edit = "";
$paragraph_desc_create = 'Abilities are passive actions that are automatically applied or active actions that a player/creature can perform.';

// assumes $mode is set
require_once $folder_ext . 'php/form_helper_start.php';

// get ability types from server
$sql = "SELECT * FROM abilityType";
$statement = $database->prepare($sql);
$statement->execute();
$query_results = $statement->fetchAll(PDO::FETCH_ASSOC);

$html_form .= createDatalistInput($get_row['type'], $form_id, "type", "Type of ability:", $required, $query_results, "type", $L_DATALIST_HINT.'<br>'.$L_TYPE_ABILITY_HINT);

$sql = "SELECT * FROM target";
$statement = $database->prepare($sql);
$statement->execute();
$query_results = $statement->fetchAll(PDO::FETCH_ASSOC);

$html_form .= createDatalistInput($get_row['target'], $form_id, "target", "Target:", $required, $query_results, "target", $L_DATALIST_HINT.'<br>'.$L_TARGET_HINT);
$html_form .= createNumberInput($get_row['targetNum'], $form_id, "targetNum", "Number of targets:", "200", "0", NULL, $L_NUMBER_HINT.'<br>'.$L_NUM_TARGET_HINT);
$html_form .= createNumberInput($get_row['range'], $form_id, "range", "Range (ft):", "10000", "0", NULL, $L_NUMBER_HINT.'<br>'.$L_RANGE_HINT);
$html_form .= createNumberInput($get_row['radius'], $form_id, "radius", "Radius (ft):", "10000", "0", NULL, $L_NUMBER_HINT.'<br>'.$L_RADIUS_HINT);

$sql = "SELECT * FROM radiusType";
$statement = $database->prepare($sql);
$statement->execute();
$query_results = $statement->fetchAll(PDO::FETCH_ASSOC);

$html_form .= createDatalistInput($get_row['radiusType'], $form_id, "radiusType", "Radius type:", NULL, $query_results, 'radiusType', $L_DATALIST_HINT.'<br>'.$L_RADIUS_TYPE_HINT);
$html_form .= createTextareaInput($get_row['description'], $form_id, "description", "Description:", "7", $required, $L_DESCRIPTION_HINT);

require_once $folder_ext . 'php/form_helper_end.php';

?>