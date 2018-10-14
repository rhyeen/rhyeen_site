<?php

require_once 'db/connection.php';
require_once 'submit_helper.php';

$json_return['status'] = "NA";
$json_return['message'] = "";

try
{
	if( isset($_POST['data']) && isset($_POST['table']) && isset($_POST['column']))
	{	
		checkValidUnique($_POST['data'], $_POST['column'], $json_return);
		checkDataUnique2($database, $_POST, $_POST['table'], $_POST['column'], 'data', $json_return);
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