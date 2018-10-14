<?php
$folder_ext = '../';
$css_file = $folder_ext . 'css/style.css';
$js_helper = $folder_ext . 'js/helper.css';

require_once $folder_ext . 'php/helper.php';

// this will start a connection for us.
// all connection stuff is then done with $database
require_once $folder_ext . 'php/db/connection.php';

// php global variables
$html_input = "";

try
{
	$sql = "";
	$statement = $database->prepare($sql);
	$statement->bindParam(':col', htmlspecialchars($html_input));
	$statement->execute();
	$query_results = $statement->fetchAll(PDO::FETCH_ASSOC);
	
	if (!empty($query_results))
	{
		foreach ($query_results as $row)
		{
			
		}
	}
	
	if( isset($_POST['data']))
	{	
		$someClass = new SomeClass("hello world");
		$yearSlice->public_mem = "test";
		
		$sql = "SELECT column_name FROM table_name WHERE column_name=:district";
		$statement = $database->prepare($sql);
		$statement->execute();
		$query_result = $statement->fetch(PDO::FETCH_ASSOC);
		
		if (!empty($query_result))
		{
			
		}
	}
}
catch (PDOException $e)
{
	$html_input = '<p style="color:red">ERROR:$e</p>';
}

echo <<<HTML_TEXT
<!doctype html> 
<html>
<head>
    <style type="text/css"></style>
	<meta charset="UTF-8">
    <title></title>
    <!-- So devices see it the way I expect them to -->
    <meta name="viewport" content="width=device-width">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="stylesheet" type="text/css" href="$css_file">
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
    <script type="text/javascript" src="$js_helper"></script>
</head>
<body>
	<div class="page-container">
		<h1></h1>
    	<form id="creature-form" method = "post">
        	<fieldset>
                <label for="rpg_c">RPG name:</label>
                <input id="rpg_c" name="rpg" type="text" value = "" maxlength="45" required>
                <label for="name_c">Creature name:</label>
                <input id="name_c" name="name" type="text" value = "" maxlength="45" required>
                <label for="health_c">Health:</label>
                <input id="health_c" name="health" type="number" value = "" max="1000" min="0" required>
                <fieldset>
                    <label for="ac_c">Armor:</label>
                    <input list="ac_c" name="armor" required>
                    <datalist id="ac_c">
                        <option value="No armor">
                        <option value="Leather">
                        <option value="Chainmail">
                        <option value="Platemail">
                        <option value="Cloth">
                    </datalist>
                    <label for="aac_c">Additional Armor:</label>
                    <input list="aac_c" name="addArmor">
                    <datalist id="aac_c">
                        <option value="Shield">
                        <option value="Parry">
                        <option value="Helm">
                        <option value="Boots">
                    </datalist>
                </fieldset>
                <!--<input id="ac_c" name="ac" type="number" value = "" max="100" min="0" required>-->
                
            </fieldset>
            <fieldset class="attributes">
                <label for="str_c">STR:</label>
                <input id="str_c" name="str" type="number" max="30" min="0" required>
                <label for="dex_c">DEX:</label>
                <input id="dex_c" name="dex" type="number" max="30" min="0" required>
                <label for="inf_c">INF:</label>
                <input id="inf_c" name="inf" type="number" max="30" min="0" required>
                <label for="wis_c">WIS:</label>
                <input id="wis_c" name="wis" type="number" max="30" min="0" required>
            </fieldset>
            <fieldset>
            	<label for="skills_c">Skills:</label>
                <input list="skills_c" name="skills">
                <datalist id="skills_c">
                	<option value="Alchemy">
                    <option value="Arcana">
                    <option value="Athletics">
                    <option value="Balance">
                    <option value="Deception">
                    <option value="Insight">
                    <option value="Inspection">
                    <option value="Intimidation">
                    <option value="Lore">
                    <option value="Nature">
                    <option value="Perception">
                    <option value="Persuasion">
                    <option value="Sleight of hand">
                    <option value="Stealth">
                    <option value="Survival">
                    <option value="Willpower">
                </datalist>
                <label for="skill_c">Skill modifier:</label>
                <input id="skill_c" name="skill" type="number" max="30" min="0" required>
                <input class="btn default-btn" name="add-skill" type="button" value="Add Another Skill">
                <label>*Attribute modifier will be added to the skill.</label>
            </fieldset>
            <fieldset>
            	<label for="sense_c">Sense:</label>
                <input list="sense_c" name="sense">
                <datalist id="sense_c">
                	<option value="Nightvision">
                    <option value="Tuned smell">
                    <option value="Tuned vision">
                    <option value="Tuned hearing">
                    <option value="Sense creature">
                    <option value="Deaf">
                    <option value="Blind">
                </datalist>
                <input class="btn default-btn" name="add-sense" type="button" value="Add Another Sense">
                <label for="lang_c">Languages:</label>
                <input list="lang_c" name="languages">
                <datalist id="lang_c">
                	<option value="Common">
                    <option value="Dwarvish">
                    <option value="Elvish">
                    <option value="Demonic">
                    <option value="Dragonic">
                    <option value="Ancient">
                </datalist>
                <input class="btn default-btn" name="add-lang" type="button" value="Add Another Language">
            </fieldset>
            <fieldset>
            	<label for="ability_c">Abilities:</label>
            	<input list="ability_c" name="skills">
                <datalist id="ability_c">
                	<option value="Parry">
                    <option value="Climb">
                    <option value="Swim">
                </datalist>
                <input class="btn default-btn" name="add-ability" type="button" value="Add Another Ability">
            </fieldset>
            <fieldset>
            	<label for="action_c">Actions:</label>
            	<input list="action_c" name="action">
                <datalist id="action_c">
                	<option value="Longsword">
                    <option value="Grapple">
                    <option value="Short bow">
                </datalist>
                <input class="btn default-btn" name="add-action" type="button" value="Add Another Action">
            </fieldset>
            <fieldset>
            	<label id="estimated_lvl_c">Estimated level: X</label>
            	<label for="lvl_c">Ignore estimated level and make it:</label>
                <input id="lvl_c" name="level" type="number" max="30" min="0" required>
            </fieldset>
            <fieldset>
            	<label for="desc_c">Description:</label>
                <textarea id="desc_c"></textarea>
            </fieldset>
            <input class="btn confirm-btn" name="submit-button" type="submit" value="Submit">
        </form>
    </div>
</body>
</html>
HTML_TEXT;

?>