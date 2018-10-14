<?php

function inputExists($post, $input_key)
{
	if(!isset($post[$input_key]))
		return FALSE;
	if(isset($post[$input_key]) && empty($post[$input_key])) 
		return FALSE;
	return TRUE;
}

function checkInputExists($post, $input_key, &$json_return) 
{
	if(inputExists($post, $input_key))
		return TRUE;
	$json_return['status'] = "FAILED";
	$json_return['error'][$input_key] = "Input is required";
	return FALSE;
}

function insertInto($table, $columnValuePair, $exceptions, $primary_key, &$database, &$json_return)
{
	insertDriver($table, $columnValuePair, $exceptions, $primary_key, $database, $json_return, 'create');
	
}

function insertIntoEdit($table, $columnValuePair, $exceptions, $primary_key, &$database, &$json_return)
{
	insertDriver($table, $columnValuePair, $exceptions, $primary_key, $database, $json_return, 'edit');
}


function insertDriver($table, $columnValuePair, $exceptions, $primary_key, &$database, &$json_return, $mode)
{
	// if the name has changed, after the insert delete the old entry 
		// if all required fields look good, attempt to add the entry
		$sql = 'INSERT INTO '.$table.'';
		$column_sql = ' (';
		$value_sql = ' VALUES (';
		$duplicate_sql = ' ON DUPLICATE KEY UPDATE ';
		foreach($columnValuePair as $column => $value)
		{
			// is it part of the exceptions list?
			if(!in_array($column,$exceptions,TRUE))
			{
				$column_bind = $column;
				// sql doesn't like 'range' without 'table.range'
				if($column === 'range')
					$column = $table .'.'. $column; 
				
				$column_sql .= $column . ', ';
				$value_sql .= ':' . $column_bind . ', ';
				if(in_array($column,$primary_key,TRUE))
					$duplicate_sql .= $column . '=' . $column .', ';
				else
					$duplicate_sql .= $column . '=:' . $column_bind .'2, ';
			}
		}
		// remove ', ' and add necessary endings
		$column_sql = substr($column_sql, 0, -2) . ')';
		$value_sql = substr($value_sql, 0, -2) . ')';
		$duplicate_sql = substr($duplicate_sql, 0, -2);
		
		$sql .= $column_sql . $value_sql;
		if($mode === 'edit')
			$sql .= $duplicate_sql;
				
		$statement = $database->prepare($sql);

		foreach($columnValuePair as $column => $value)
		{
			
			// is it part of the exceptions list?
			if(!in_array($column,$exceptions,TRUE))
			{
				$bindVal = ':' . $column;
				$bindVal2 = $bindVal . '2';
				// if null, make entry NULL in db
				if(!$value) {
					$statement->bindValue($bindVal, NULL, PDO::PARAM_INT);
					if(!in_array($column,$primary_key,TRUE) && $mode === 'edit')
						$statement->bindValue($bindVal2, NULL, PDO::PARAM_INT);
				}
				else {
					$statement->bindParam($bindVal, htmlspecialchars($value));
					if(!in_array($column,$primary_key,TRUE) && $mode === 'edit')
						$statement->bindParam($bindVal2, htmlspecialchars($value));
				}
			}
		}
		$result = $statement->execute();
		
		if(!$result)
		{
			$json_return['status'] = "FAILED";
			if($mode == 'edit')
				$json_return['message'] = "Could not edit database.";
			else
				$json_return['message'] = "Could not add to database.";
		}
		else
		{
			if($mode == 'edit')
				$json_return['message'] = "Successfully edited database!";
			else
				$json_return['message'] = "Successfully created database!";
		}
		
		//return $statement->execute();
}

////
// Assumes there is a 'original_' . $unique_id. 
// Only deletes entry if it doesn't match the original value for unique_id
function deleteOldEntry($table, $columnValuePair, $unique_id, &$database, &$json_return)
{
	$original = 'original_' . $unique_id;
	$bindParam = ':'.$unique_id;
	// if the unique_id has changed, after the insert delete the old entry 
	if($columnValuePair[$unique_id] !== $columnValuePair[$original])
	{
		// if all required fields look good, attempt to add the entry
		$sql = 'DELETE FROM '.$table.' where '.$unique_id.'='.$bindParam;
			
		$statement = $database->prepare($sql);
		$statement->bindParam($bindParam, htmlspecialchars($columnValuePair[$original]));
		$result = $statement->execute();
		
		if(!$result)
		{
			$json_return['status'] = "FAILED";
			$json_return['message'] = "Could not edit database.";
		}
		else
			$json_return['message'] = "Successfully edited database!";
	}
	else
		$json_return['message'] = "Successfully edited database!";
}

////
// Deletes entry in table[columnValuePair[column_to_delete]] from table
function deleteEntry($table, $columnValuePair, $column_to_delete, &$database, &$json_return)
{
	$bindParam = ':'.$column_to_delete;
	
	// if all required fields look good, attempt to add the entry
	$sql = 'DELETE FROM '.$table.' where '.$column_to_delete.'='.$bindParam;
		
	$statement = $database->prepare($sql);
	$statement->bindParam($bindParam, htmlspecialchars($columnValuePair[$column_to_delete]));
	$result = $statement->execute();
}

////
// calls both insertIntoEdit() and deleteOldEntry()
function insertAndDeleteEdit($table, $columnValuePair, $exceptions, $primary_key, &$database, &$json_return, $unique_id)
{
	insertIntoEdit($table, $columnValuePair, $exceptions, $primary_key, $database, $json_return);
		
	if($json_return['status'] === "OK")
	{
		deleteOldEntry($table, $columnValuePair, $unique_id, $database, $json_return);
	}
}


////
// Checks if the data is unqiue to the given table
// This is assuming that $post[$column] == $column_name 
// (which is why $column_name is not a parameter).
function checkDataUnique(&$database, $post, $table, $column, &$json_return) 
{
	if (!checkInputExists($post, $column, $json_return))
			return;
	// TODO: we really shouldn't trust putting $_POST directly into the sql
	// but we can't bind it because it isn't values...
	$sql = 'SELECT * FROM '.$table.' WHERE '.$column.'=:data';
	
	$statement = $database->prepare($sql);
	//	$post['column'] = 'data' --> $post['data'] = actual_data
	$statement->bindParam(':data', htmlspecialchars($post[$column]));	
	$statement->execute();	
	$query_result = $statement->fetch(PDO::FETCH_ASSOC);
	
	// item must be unique
	if (empty($query_result))
	{
		if($json_return['status'] === "NA")
			$json_return['status'] = "OK";
	}
	else
	{
		$json_return['status'] = "FAILED";
		$json_return['error'][$column] = "Must be unique";
	}
}

function checkValidUnique($data, $column, &$json_return)
{	
	//// get more specific as we move down
	
	// must start with letter, only have spaces, hyphens, numbers, letters
	if(preg_match('/^[A-Za-z][A-Za-z0-9 -]*$/', $data) === 0)
	{
		$json_return['status'] = "FAILED";
		$json_return['error'][$column] = "Cannot contain special characters";
	}
	
	// must start with a letter	
	if(preg_match('/^[A-Za-z]/', $data) === 0)
	{
		$json_return['status'] = "FAILED";
		$json_return['error'][$column] = "Must start with a letter";
	}

	
	if(strpos($data, '_') !== FALSE)
	{
		$json_return['status'] = "FAILED";
		$json_return['error'][$column] = "Cannot contain underscore";
	}
	
	if(strpos($data, 'SPC') !== FALSE)
	{
		$json_return['status'] = "FAILED";
		$json_return['error'][$column] = "Cannot contain SPC";
	}
	
	
}

////
// This is assuming that $post[$column] != $column_name
function checkDataUnique2(&$database, $post, $table, $column, $column_name, &$json_return) 
{
	// TODO: we really shouldn't trust putting $_POST directly into the sql
	// but we can't bind it because it isn't values...
	$sql = 'SELECT * FROM '.$table.' WHERE '.$column.'=:data';
	
	$statement = $database->prepare($sql);
	//	$post['column'] = 'data' --> $post['data'] = actual_data
	$statement->bindParam(':data', htmlspecialchars($post[$column_name]));	
	$statement->execute();	
	$query_result = $statement->fetch(PDO::FETCH_ASSOC);
	
	// item must be unique
	if (empty($query_result))
	{
		if($json_return['status'] === "NA")
			$json_return['status'] = "OK";
	}
	else
	{
		$json_return['status'] = "FAILED";
		$json_return['error'][$column] = "Must be unique";
	}
}

function checkValidEnum($value, $check_against, &$json_return)
{
	// if value is null
	if ($value && in_array($value,$check_against,TRUE))
	{
		if($json_return['status'] === "NA")
			$json_return['status'] = "OK";
	}
	else
	{
		$json_return['status'] = "FAILED";
		$json_return['error'][$column] = "Must be an item from the dropdown";
	}
}

////
// 
// Checks if data is in actual table in db
// This is assuming that $post[$column] == $column_name 
// (which is why $column_name is not a parameter).
// will add the combined name to the exceptions list so it won't be checked
// also, the separate names will be added to the $post array
function checkCombinedDataValid(&$database, &$post, $table, $column1, $column2, &$json_return, &$exceptions) 
{
	$combined = $column1 . "SPC" . $column2;
	$exceptions[] = $combined;
	
	if (!checkInputExists($post, $combined, $json_return))
		return;
		
	// separate the combined based on where the : is
	$combined_val = $post[$combined];
	$colon_index = strpos($combined_val, ':');
	$post[$column1] = substr($combined_val,0,$colon_index-1);
	$post[$column2] = substr($combined_val,$colon_index + 1);
	
	$sql = 'SELECT * FROM '.$table.' WHERE '.$column1.'=:data1 AND '.$column2.'=:data2';
		
	$statement = $database->prepare($sql);
	$statement->bindParam(':data', htmlspecialchars($post[$column1]));	
	$statement->bindParam(':data', htmlspecialchars($post[$column2]));
	$statement->execute();	
	$query_result = $statement->fetch(PDO::FETCH_ASSOC);
	
	// item must be unique
	if (!empty($query_result))
	{
		if($json_return['status'] === "NA")
			$json_return['status'] = "OK";
	}
	else
	{
		$json_return['status'] = "FAILED";
		$json_return['error'][$combined] = "Must be an item from the dropdown";
	}
}

////
// Checks if dice input is valid dice number
function checkDiceValid(&$post, $column, &$json_return) 
{
	if (!checkInputExists($post, $column, $json_return))
		return;
	
	// remove whitespaces
	$post[$column] = preg_replace('/\s+/', '', $post[$column]);
	
	$regexDice = "/^((\d+)?(d)(4|6|8|10|12|20|2)(([-+*\/])(\d+))?)$|^(\d+)$/";
	if (preg_match($regexDice, $post[$column]))
	{
		if($json_return['status'] === "NA")
			$json_return['status'] = "OK";
	}
	else
	{
		$json_return['status'] = "FAILED";
		$json_return['error'][$column] = "Must match dice structure (e.g. 2d6+1).";
	}
}


////
// Checks if data is in actual table in db
// This is assuming that $post[$column] == $column_name 
// (which is why $column_name is not a parameter).
function checkDataValid(&$database, $post, $table, $column, &$json_return) 
{
	if (!checkInputExists($post, $column, $json_return))
		return;
	
	$sql = 'SELECT * FROM '.$table.' WHERE '.$column.'=:data';
		
	$statement = $database->prepare($sql);
	$statement->bindParam(':data', htmlspecialchars($post[$column]));	
	$statement->execute();	
	$query_result = $statement->fetch(PDO::FETCH_ASSOC);
	
	// item must be unique
	if (!empty($query_result))
	{
		if($json_return['status'] === "NA")
			$json_return['status'] = "OK";
	}
	else
	{
		$json_return['status'] = "FAILED";
		$json_return['error'][$column] = "Must be an item from the dropdown";
	}
}

////
// This is assuming that $post[$column] != $column_name
function checkDataValid2(&$database, $post, $table, $column, $column_name, &$json_return) 
{	
	$sql = 'SELECT * FROM '.$table.' WHERE '.$column.'=:data';
		
	$statement = $database->prepare($sql);
	$statement->bindParam(':data', htmlspecialchars($post[$column_name]));	
	$statement->execute();	
	$query_result = $statement->fetch(PDO::FETCH_ASSOC);
	
	// item must be unique
	if (!empty($query_result))
	{
		if($json_return['status'] === "NA")
			$json_return['status'] = "OK";
	}
	else
	{
		$json_return['status'] = "FAILED";
		$json_return['error'][$column] = "Must be an item from the dropdown";
	}
}
?>