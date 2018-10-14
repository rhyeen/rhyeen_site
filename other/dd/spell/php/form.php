<?php
// assumes $mode is set
// variables
$folder_ext = '../../';
$singular_tag_cap = 'Spell';
$table_name = 'spell';
$unique_id = 'name';
$paragraph_desc_edit = "";
$paragraph_desc_create = 'Spells are actions that a player/creature can perform by consuming mana.  Spells are aquired by different classes at certain levels.';

// assumes $mode is set
require_once $folder_ext . 'php/form_helper_start.php';

$html_form .= createNumberInput($get_row['level'], $form_id, "level", "Level:", "20", "0", NULL, $L_DATALIST_ANY_HINT.'<br>'.$L_SPELL_LEVEL_HINT);

$html_form .= createNumberInput($get_row['manaCost'], $form_id, "manaCost", "Mana cost:", "1000", "0", NULL, $L_DATALIST_ANY_HINT.'<br>'.$L_MANA_COST_HINT);

$sql = "SELECT * FROM spell GROUP BY castTime";
$statement = $database->prepare($sql);
$statement->execute();
$query_results = $statement->fetchAll(PDO::FETCH_ASSOC);

$html_form .= createDatalistAnyInput($get_row['castTime'], $form_id, "castTime", "Cast time:", $required, $query_results, "castTime", $L_DATALIST_ANY_HINT.'<br>'.$L_CAST_TIME_HINT);

$sql = "SELECT * FROM spell GROUP BY components";
$statement = $database->prepare($sql);
$statement->execute();
$query_results = $statement->fetchAll(PDO::FETCH_ASSOC);

$html_form .= createDatalistAnyInput($get_row['components'], $form_id, "components", "Components:", NULL, $query_results, "components", $L_DATALIST_ANY_HINT.'<br>'.$L_COMPONENTS_HINT);

$sql = "SELECT * FROM spell GROUP BY duration";
$statement = $database->prepare($sql);
$statement->execute();
$query_results = $statement->fetchAll(PDO::FETCH_ASSOC);

$html_form .= createDatalistAnyInput($get_row['duration'], $form_id, "duration", "Duration:", NULL, $query_results, "duration", $L_DATALIST_ANY_HINT.'<br>'.$L_DURATION_HINT);

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

$html_form .= createDiceInput($get_row['damage'], $form_id, "damage", "Damage:", NULL, $L_DICE_HINT.'<br>'.$L_DAMAGE_HINT);
			
$sql = "SELECT * FROM damageType";
$statement = $database->prepare($sql);
$statement->execute();
$query_results = $statement->fetchAll(PDO::FETCH_ASSOC);

$html_form .= createDatalistInput($get_row['damageType'], $form_id, "damageType", "Damage type:", NULL, $query_results, "damageType", $L_DATALIST_HINT.'<br>'.$L_DAMAGE_TYPE_HINT);

$html_form .= createDiceInput($get_row['secondaryDamage'], $form_id, "secondaryDamage", "Secondary Damage:", NULL, $L_DICE_HINT.'<br>'.$L_SECONDARY_DAMAGE_HINT);

$html_form .= createDatalistInput($get_row['secondaryDamageType'], $form_id, "secondaryDamageType", "Secondary damage type:", NULL, $query_results, "damageType", $L_DATALIST_HINT.'<br>'.$L_SECONDARY_DAMAGE_TYPE_HINT);

$html_form .= createTextareaInput($get_row['description'], $form_id, "description", "Description:", "7", $required, $L_DESCRIPTION_HINT);

require_once $folder_ext . 'php/form_helper_end.php';

?>