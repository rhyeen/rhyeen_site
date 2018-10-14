<?php

require_once '../../php/db/connection.php';
require_once '../../php/submit_helper.php';

$json_return['status'] = "NA";
$json_return['message'] = "Could not add item.";
$items_data = NULL;


try
{
	// variables
	$table = 'item';
	$unique_id = 'name';
	$original_unique_id = 'original_' . $unique_id;
	// all values in the main table that are not in the sub-tables
	// ex) what columns are in items that are not in armor
	$exceptions = array($original_unique_id, 'weight', 'value', 'primaryType', 'secondaryType', 'description');
	$primary_key = array($unique_id, 'rpg');
	
	checkDataUnique($database, $_POST, $table, $unique_id, $json_return);
	
	checkDataValid($database, $_POST, 'itemType', 'primaryType', $json_return);
	
	//checkCombinedDataValid($database, $_POST, 'itemType', 'secondaryType', 'primaryType', $json_return, $exceptions);
	
	checkInputExists($_POST, 'description', $json_return);
	
	$_POST['rpg'] = 'dales';
	
	// now check individual item types
	if($_POST['primaryType'] === 'Ammunition')
	{
		checkInputExists($_POST, 'quantityForValue', $json_return);
		checkInputExists($_POST, 'type', $json_return);
		
		if($json_return['status'] === "OK")
			insertInto('ammunition', $_POST, $exceptions, $primary_key, $database, $json_return);
	}
	else if($_POST['primaryType'] === 'Arcane')
	{
		checkDataValid($database, $_POST, 'rarity', 'rarity', $json_return);
		
		if($json_return['status'] === "OK")
			insertInto('arcane', $_POST, $exceptions, $primary_key, $database, $json_return);
	}
	else if($_POST['primaryType'] === 'Valuable')
	{
		checkDataValid($database, $_POST, 'rarity', 'rarity', $json_return);
		
		if($json_return['status'] === "OK")
			insertInto('valuable', $_POST, $exceptions, $primary_key, $database, $json_return);
	}
	else if($_POST['primaryType'] === 'Armor')
	{
		checkDataValid($database, $_POST, 'itemType', 'secondaryType', $json_return);
		
		if($json_return['status'] === "OK")
			insertInto('armor', $_POST, $exceptions, $primary_key, $database, $json_return);
	}
	else if($_POST['primaryType'] === 'Consumable')
	{
		checkDataValid($database, $_POST, 'rarity', 'rarity', $json_return);
		
		// if locality exists, it must be because it is an ingredient
		if (inputExists($_POST, 'locality') && $_POST['secondaryType'] !== 'Ingredient')
		{
			$json_return['status'] = "FAILED";
			$json_return['error']['locality'] = "Only Ingredients have locality.";
		}
			
		
		if($json_return['status'] === "OK")
			insertInto('consumable', $_POST, $exceptions, $primary_key, $database, $json_return);
	}
	else if($_POST['primaryType'] === 'Melee Weapon' || $_POST['primaryType'] === 'Ranged Weapon' )
	{
		checkDiceValid($_POST, 'damage', $json_return);
		
		if (inputExists($_POST, 'property'))
				checkDiceValid($_POST, 'secondaryDamage', $json_return);
		
		checkDataValid($database, $_POST, 'damageType', 'damageType', $json_return);
		if (inputExists($_POST, 'property'))
			checkDataValid($database, $_POST, 'property', 'property', $json_return);
		if($_POST['primaryType'] === 'Ranged Weapon')
			checkDataValid($database, $_POST, 'ammunition', 'ammunitionType', $json_return);
		
		if (inputExists($_POST, 'secondaryDamageType'))
			// TODO: doesn't actually check secondaryDamageType, just checks damageType, modify checkDataValid to include ability to rename the field
			checkDataValid($database, $_POST, 'damageType', 'damageType', $json_return);
			
		if($json_return['status'] === "OK")
			insertInto('consumable', $_POST, $exceptions, $primary_key, $database, $json_return);
	}
	else if($_POST['primaryType'] === 'Gear' || $_POST['primaryType'] === 'Miscellaneous' || $_POST['primaryType'] === 'Tool')
	{
		// do nothing more
	}
	else
	{
		$json_return['status'] = "FAILED";
		$json_return['message'] = 'Not a recognized type.';
	}
	// if everything is still ok after primaryType pass, add to item's table.
	if($json_return['status'] === "OK")
	{
		$items_data['rpg'] = $_POST['rpg'];
		$items_data['name'] = $_POST['name'];
		$items_data['weight'] = $_POST['weight'];
		$items_data['value'] = $_POST['value'];
		$items_data['primaryType'] = $_POST['primaryType'];
		$items_data['secondaryType'] = $_POST['secondaryType'];
		$items_data['description'] = $_POST['description'];
		insertInto($table, $items_data, NULL, $primary_key, $database, $json_return);
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