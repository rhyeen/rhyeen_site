<?php

require_once 'config.php';
	
// when querying a database, put everything in try/catch blocks
try
{
	// build the database connection
	$database = new PDO("mysql:host=$server_name;dbname=$db_name;charset=utf8", $db_user_name, $db_password);
	$database->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	// Needed for the prepare and execution of query and for verifying the content.
	$database->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
}
catch (PDOException $e)
{
	echo "<p>ERROR: $e</p>";
}

?>

