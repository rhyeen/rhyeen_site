<?php
// assumes $mode is set
// variables
$folder_ext = '../../';
$singular_tag_cap = 'Skill';
$table_name = 'skill';
$unique_id = 'name';
$paragraph_desc_edit = "";
$paragraph_desc_create = 'Skills are active actions that a player/creature can perform.  This is usually done outside of combat. Skill success is determined by a d20 roll against a DM defined difficulty. Skills have modifiers that can modify the d20 roll.';

// assumes $mode is set
require_once $folder_ext . 'php/form_helper_start.php';

$html_form .= createDatalistInput($get_row['attribute'], $form_id, "attribute", "Attribute:", $required, array('STR','DEX','INF','WIS'), NULL, $L_DATALIST_HINT.'<br>'.$L_ATTRIBUTE_HINT);

$sql = "SELECT * FROM skill GROUP BY type";
$statement = $database->prepare($sql);
$statement->execute();
$query_results = $statement->fetchAll(PDO::FETCH_ASSOC);

$html_form .= createDatalistAnyInput($get_row['type'], $form_id, "type", "Type:", $required, $query_results, "type", $L_DATALIST_ANY_HINT.'<br>'.$L_SKILL_TYPE_HINT);

$html_form .= createTextareaInput($get_row['description'], $form_id, "description", "Description:", "7", $required, $L_DESCRIPTION_HINT);

require_once $folder_ext . 'php/form_helper_end.php';

?>