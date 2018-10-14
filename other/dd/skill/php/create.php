<?php

require_once '../../php/db/connection.php';
require_once '../../php/submit_helper.php';

$json_return['status'] = "NA";
$json_return['message'] = "Could not add skill.";

try
{
	// variables
	$table = 'skill';
	$unique_id = 'name';
	$original_unique_id = 'original_' . $unique_id;
	$exceptions = array($original_unique_id);
	$primary_key = array($unique_id, 'rpg');
	
	checkDataUnique($database, $_POST, $table, $unique_id, $json_return);
	
	checkValidEnum($_POST['attribute'], array('STR', 'DEX', 'INF', 'WIS'), $json_return);
	checkInputExists($_POST, 'type', $json_return);
	checkInputExists($_POST, 'description', $json_return);
	
	if($json_return['status'] === "OK")
	{
		$_POST['rpg'] = 'dales';
		insertInto($table, $_POST, $exceptions, $primary_key, $database, $json_return);
	}
}
catch (PDOException $e)
{
	$json_return['status'] = "FAILED";
	$json_return['message'] = $e->getMessage();
}

// send json
header("Content-Type: application/json", true);

echo json_encode($json_return);

?>