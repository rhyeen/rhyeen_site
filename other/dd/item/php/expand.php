<?php

require_once '../../php/db/connection.php';
require_once '../../php/create_helper.php';
require_once '../../locales/labels.php';


$json_return['status'] = "NA";
$json_return['message'] = "Could not add item.";
$json_return['form_extra'] = "";
$get_row = NULL;
$required = "required";

try
{
	if( isset($_POST['data']) && isset($_POST['form']))
	{	
		$json_return['status'] = "OK";
		$json_return['message'] = "Expanding form...";
		
		// if the id is given, we are editing and should grab that entry's subtable information
		if (isset($_POST['id']) && 
		($_POST['data'] == 'Ammunition' || $_POST['data'] == 'Arcana' ||
		$_POST['data'] == 'Armor' || $_POST['data'] == 'Consumable' ||
		$_POST['data'] == 'Valuable'))
		{
			$check_table = lcfirst($_POST['data']);
			// check if the item already exists
			$sql = 'SELECT * FROM '. $check_table .'  WHERE name=:name';
			$statement = $database->prepare($sql);
			$statement->bindParam(':name', htmlspecialchars($_POST['id']));
			$statement->execute();
			$get_row = $statement->fetch(PDO::FETCH_ASSOC);
		}
		
		if (isset($_POST['id']) && ($_POST['data'] == 'Melee Weapon' || $_POST['data'] == 'Ranged Weapon'))
		{
			// check if the item already exists
			$sql = 'SELECT * FROM weapon WHERE name=:name';
			$statement = $database->prepare($sql);
			$statement->bindParam(':name', htmlspecialchars($_POST['id']));
			$statement->execute();
			$get_row = $statement->fetch(PDO::FETCH_ASSOC);
		}
		
		// get secondaryType if the itemType has a secondaryType
		if (isset($_POST['id']) && 
		($_POST['data'] == 'Armor' || $_POST['data'] == 'Consumable' ||
		$_POST['data'] == 'Melee Weapon' || $_POST['data'] == 'Ranged Weapon'))
		{
			$sql = 'SELECT * FROM item WHERE name=:name';
			$statement = $database->prepare($sql);
			$statement->bindParam(':name', htmlspecialchars($_POST['id']));
			$statement->execute();
			$get_secondaryType = $statement->fetch(PDO::FETCH_ASSOC);
		}
		
		if ($_POST['data'] === 'Ammunition')
		{
			$json_return['form_extra'] .= createNumberInput($get_row['quantityForValue'], $_POST['form'], "quantityForValue", "Quantity for value:", "100", "1", NULL, $L_NUMBER_HINT.'<br>'.$L_QUANTITY_VALUE_HINT);
			
			$sql = "SELECT * FROM ammunition GROUP BY ammunitionType";
			$statement = $database->prepare($sql);
			$statement->execute();
			$query_results = $statement->fetchAll(PDO::FETCH_ASSOC);
			
			$json_return['form_extra'] .= createDatalistAnyInput($get_row['ammunitionType'], $_POST['form'], "ammunitionType", "Type of Ammunition:", $required, $query_results, "ammunitionType", $L_DATALIST_ANY_HINT.'<br>'.$L_TYPE_AMMUNITION_HINT);
		}
		else if ($_POST['data'] === 'Arcane' || $_POST['data'] === 'Valuable')
		{
			$sql = "SELECT * FROM rarity";
			$statement = $database->prepare($sql);
			$statement->execute();
			$query_results = $statement->fetchAll(PDO::FETCH_ASSOC);
			
			$json_return['form_extra'] .= createDatalistInput($get_row['rarity'], $_POST['form'], "rarity", "Rarity:", $required, $query_results, "rarity", $L_DATALIST_HINT.'<br>'.$L_RARITY_HINT);
		}
		else if ($_POST['data'] === 'Armor')
		{
			$sql = "SELECT * FROM itemType WHERE primaryType='Armor'";
			$statement = $database->prepare($sql);
			$statement->execute();
			$query_results = $statement->fetchAll(PDO::FETCH_ASSOC);
			
			$json_return['form_extra'] .= createDatalistInput($get_secondaryType['secondaryType'], $_POST['form'], "secondaryType", "Secondary type:", $required, $query_results, "secondaryType", $L_DATALIST_HINT.'<br>'.$L_SECONDARY_ARMOR_TYPE_HINT);
			
			
			$json_return['form_extra'] .= createNumberInput($get_row['armorModifier'], $_POST['form'], "armorModifier", "Armor modifier:", "1000", "-1000", NULL, $L_NUMBER_HINT.'<br>'.$L_ARMOR_MOD_HINT);
			
			$json_return['form_extra'] .= createNumberInput($get_row['dodgeModifier'], $_POST['form'], "dodgeModifier", "Dodge modifier:", "1000", "-1000", NULL, $L_NUMBER_HINT.'<br>'.$L_DODGE_MOD_HINT);
			
			$json_return['form_extra'] .= createNumberInput($get_row['magicResistModifier'], $_POST['form'], "magicResistModifier", "Magic resist modifier:", "1000", "-1000", NULL, $L_NUMBER_HINT.'<br>'.$L_MAGIC_RESIST_MOD_HINT);
		}
		else if ($_POST['data'] === 'Consumable')
		{
			$sql = "SELECT * FROM itemType WHERE primaryType='Consumable'";
			$statement = $database->prepare($sql);
			$statement->execute();
			$query_results = $statement->fetchAll(PDO::FETCH_ASSOC);
			
			$json_return['form_extra'] .= createDatalistInput($get_secondaryType['secondaryType'], $_POST['form'], "secondaryType", "Secondary type:", $required, $query_results, "secondaryType", $L_DATALIST_HINT.'<br>'.$L_SECONDARY_CONSUMABLE_TYPE_HINT);
			
			$sql = "SELECT * FROM rarity";
			$statement = $database->prepare($sql);
			$statement->execute();
			$query_results = $statement->fetchAll(PDO::FETCH_ASSOC);
			
			$json_return['form_extra'] .= createDatalistInput($get_row['rarity'], $_POST['form'], "rarity", "Rarity:", $required, $query_results, "rarity", $L_DATALIST_HINT.'<br>'.$L_RARITY_HINT);
			
			$sql = "SELECT * FROM consumable GROUP BY locality";
			$statement = $database->prepare($sql);
			$statement->execute();
			$query_results = $statement->fetchAll(PDO::FETCH_ASSOC);
			
			$json_return['form_extra'] .= createDatalistAnyInput($get_row['locality'], $_POST['form'], "locality", "Locality of Ingredient:", NULL, $query_results, "locality", $L_DATALIST_ANY_HINT.'<br>'.$L_LOCALITY_HINT);
			
			$json_return['form_extra'] .= createTextareaInput($get_row['hiddenProperty'], $_POST['form'], "hiddenProperty", "Hidden property:", "7", NULL, $L_HIDDEN_PROPERTY_HINT);
		}
		else if ($_POST['data'] === 'Gear' || $_POST['data'] === 'Miscellaneous' || $_POST['data'] === 'Tool')
		{
			// nothing! same as item
		}
		else if ($_POST['data'] === 'Melee Weapon' || $_POST['data'] === 'Ranged Weapon')
		{
			if ($_POST['data'] === 'Melee Weapon')
				$json_return['form_extra'] .= createNumberInput($get_row['throw'], $_POST['form'], "throw", "Throw range:", "1000", "0", NULL, $L_NUMBER_HINT.'<br>'.$L_THROW_HINT);
			else
			{
				$json_return['form_extra'] .= createNumberInput($get_row['range'], $_POST['form'], "range", "Range:", "1000", "0", NULL, $L_NUMBER_HINT.'<br>'.$L_WEAPON_RANGE_HINT);
				
				$sql = "SELECT * FROM ammunition GROUP BY ammunitionType";
				$statement = $database->prepare($sql);
				$statement->execute();
				$query_results = $statement->fetchAll(PDO::FETCH_ASSOC);
				
				$json_return['form_extra'] .= createDatalistInput($get_row['ammunitionType'], $_POST['form'], "ammunitionType", "Ammunition type:", $required, $query_results, "ammunitionType", $L_DATALIST_HINT.'<br>'.$L_DAMAGE_TYPE_HINT);
			}
			
			$sql = "SELECT * FROM property WHERE appliesTo='weapon'";
			$statement = $database->prepare($sql);
			$statement->execute();
			$query_results = $statement->fetchAll(PDO::FETCH_ASSOC);
			
			$json_return['form_extra'] .= createDatalistInput($get_row['property'], $_POST['form'], "property", "Property:", NULL, $query_results, "property", $L_DATALIST_HINT.'<br>'.$L_DAMAGE_TYPE_HINT);
						
			$json_return['form_extra'] .= createDiceInput($get_row['damage'], $_POST['form'], "damage", "Damage:", $required, $L_DICE_HINT.'<br>'.$L_DAMAGE_HINT);
			
			$sql = "SELECT * FROM damageType";
			$statement = $database->prepare($sql);
			$statement->execute();
			$query_results = $statement->fetchAll(PDO::FETCH_ASSOC);
			
			$json_return['form_extra'] .= createDatalistInput($get_row['damageType'], $_POST['form'], "damageType", "Damage type:", $required, $query_results, "damageType", $L_DATALIST_HINT.'<br>'.$L_DAMAGE_TYPE_HINT);
			
			$json_return['form_extra'] .= createDiceInput($get_row['secondaryDamage'], $_POST['form'], "secondaryDamage", "Secondary Damage:", NULL, $L_DICE_HINT.'<br>'.$L_SECONDARY_DAMAGE_HINT);
			
			$json_return['form_extra'] .= createDatalistInput($get_row['secondaryDamageType'], $_POST['form'], "secondaryDamageType", "Secondary damage type:", NULL, $query_results, "damageType", $L_DATALIST_HINT.'<br>'.$L_SECONDARY_DAMAGE_TYPE_HINT);
		}
		else
		{
			$json_return['status'] = "FAILED";
			$json_return['message'] = 'Not a recognized type.';
		}
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