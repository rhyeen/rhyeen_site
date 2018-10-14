<?php

require_once '../../php/db/connection.php';
require_once '../../php/submit_helper.php';

$json_return['status'] = "NA";
$json_return['message'] = "Could not edit ability.";

try
{
	// variables
	$table = 'ability';
	$unique_id = 'name';
	$original_unique_id = 'original_' . $unique_id;
	$exceptions = array($original_unique_id);
	$primary_key = array($unique_id, 'rpg');
	
	if (inputExists($_POST, $unique_id) && $_POST[$unique_id] !== $_POST[$original_unique_id])
		checkDataUnique($database, $_POST, $table, $unique_id, $json_return);
	
	checkDataValid($database, $_POST, 'abilityType', 'type', $json_return);
	checkDataValid($database, $_POST, 'target', 'target', $json_return);
		
	if (inputExists($_POST, 'radiusType'))
		checkDataValid($database, $_POST, 'radiusType', 'radiusType', $json_return);
	
	checkInputExists($_POST, 'description', $json_return);
	
	if($json_return['status'] === "OK")
	{	
		// add rpg
		$_POST['rpg'] = 'dales';
		insertAndDeleteEdit($table, $_POST, $exceptions, $primary_key, $database, $json_return, $unique_id);
	}
}
catch (PDOException $e)
{
	$json_return['status'] = "FAILED";
	$json_return['message'] = "ERROR: " . $e->getMessage();
}

// send json
header("Content-Type: application/json", true);
echo json_encode($json_return);

?>