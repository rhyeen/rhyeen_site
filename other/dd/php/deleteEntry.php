<?php

require_once 'db/connection.php';

$json_return['status'] = "OK";
$json_return['message'] = "";

try
{
	if( isset($_POST['data']) && isset($_POST['table']) && isset($_POST['column']))
	{	
		// TODO: check validity of table to avoid sql injection
		$table = $_POST['table'];
		$column = $_POST['column'];
		$sql = 'DELETE FROM '.$table.' WHERE '.$column.'=:data';
		
		$statement = $database->prepare($sql);
		$statement->bindParam(':data', htmlspecialchars($_POST['data']));	
		$result = $statement->execute();	
	
		if(!$result)
		{
			$json_return['status'] = "FAILED";
			$json_return['message'] = "Could not delete from database.";
		}
		else
		{
			$json_return['message'] = "Succesfully deleted!";
		}
	}
}
catch (PDOException $e)
{
	$json_return['status'] = "FAILED";
	$json_return['message'] = $e->getMessage();
}

/* Send as JSON */
header("Content-Type: application/json", true);

echo json_encode($json_return);

?>