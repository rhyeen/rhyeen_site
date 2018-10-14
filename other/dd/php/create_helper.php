<?php

function createTableSection ($data, $exclusions)
{
	$description = "";
	$return = "";
	if (empty($data))
		return '<p>Cannot display this information</p>';
	
	$return .= '<table>';
	
	foreach ($data as $column => $content) 
	{
		if (!in_array($column,$exclusions,TRUE) && $content) 
		{
			$column = extractColumnName($column);
			if($column === 'Description')
				$description .= '<p class="table_desc">'.$content.'</p>';
			else if($column === 'Hidden property')
				$description .= '<p class="table_desc"><b>Hidden property:</b> '.$content.'</p>';
			else
				$return .= '<tr><td class="title">'.$column.'</td><td>'.$content.'</td></tr>';
		}
	}

	$return .= '</table>';
	$return .= $description;
	return $return;
}

function extractColumnName($column)
{
	// if nameType --> Type of name
	if(strpos($column, 'primary') !== FALSE || strpos($column, 'secondary') !== FALSE)
		splitString($column, 'Type');
	else
		reorderString($column, 'Type', 'Type of ', '');
	reorderString($column, 'Num', 'Number of ', 's');
	
	removeCamelCase($column);
	
	// capatilize
	$column = ucfirst($column);
	return $column;
}

function removeCamelCase(&$string)
{
	$ccWord = 'NewNASAModule';
	$re = '/(?#! splitCamelCase Rev:20140412)
		# Split camelCase "words". Two global alternatives. Either g1of2:
		  (?<=[a-z])      # Position is after a lowercase,
		  (?=[A-Z])       # and before an uppercase letter.
		| (?<=[A-Z])      # Or g2of2; Position is after uppercase,
		  (?=[A-Z][a-z])  # and before upper-then-lower case.
		/x';
	$words = preg_split($re, $string);
	if(empty($words))
		return $string;
	$string = "";
	
	/*$words = array();
	preg_match_all('/((?:^|[A-Z])[a-z]+)/',$string,$words);
	if(empty($words))
		return $string;
	$string = "";*/
	foreach($words as $value)
		$string .= lcfirst($value) . " ";
	$string = rtrim($string, " ");
}

function splitString(&$string, $cut_string)
{
	$cut = strlen($cut_string);
	
	if(strpos($string, $cut_string) !== FALSE)
	{
		$string = substr($string, 0, strlen($string) - $cut) .' '. lcfirst($cut_string);
	}
}

function reorderString(&$string, $cut_string, $prepend_string, $append_string)
{
	$cut = strlen($cut_string);
	
	if(strlen($string) > $cut && substr($string, -$cut) ===  $cut_string)
		$string = $prepend_string . substr($string, 0, strlen($string) - $cut) . $append_string;
}

function createAccordionSection ($header, $content)
{
	$header_SPC = removeSpaces($header);
	
	$delete_icon = getIcon('delete', 'icon_danger');
	$edit_icon = getIcon('edit', 'icon_inform');
	//$copy_icon = getIcon('copy', 'icon_inform');
	
	$return =  '<h3 id="'.$header_SPC.'_accordchild">'.$header.'<span id="'.$header_SPC.'_delete" class="mini_btn">'.$delete_icon.'</span><span id="'.$header_SPC.'_edit" class="mini_btn">'.$edit_icon.'</span></span></h3>';
	$return .= '<div>';
	$return .= $content;
	$return .= '</div>';
	return $return;
}

function getIcon($part_id, $extra_class)
{
	return '<div class="icon '.$extra_class.'"><svg viewBox="0 0 32 32"><use xlink:href="#'.$part_id.'_icon"></use></svg></div>';	
}

////
// replaces spaces with 'SPC' as spaces are not allowed in id or class
function removeSpaces($string)
{
	return str_replace(' ', 'SPC', $string);
	
}

function createAccordion ($id, $class, $sections)
{	
	$return =  '<section id="'.$id.'" class="'.$class.'">';
	
	if (empty($sections))
		return $return.'Cannot display this information</section>';
	
	foreach ($sections as $section) 
	{
		$return .= $section;	
	}
	
	$return .= '</section>';
	return $return;
}


////
// leave $js_file as NULL if none
// leave $title / $description as "" if none
//
function createHead ($title, $description, $css_file, $js_files)
{
	$return =  '<head>';
	$return .= '<meta charset="UTF-8">';
    $return .= '<title>'.$title.'</title>';
	// so devices see what we expect them to
    $return .= '<meta name="viewport" content="width=device-width">';
    $return .= '<meta name="description" content="'.$description.'">';
    $return .= '<meta name="author" content="Ryan Saunders">';
	if(is_array($css_file) && !empty($css_file))
	{
		foreach ($css_file as $css_file_single)
    		$return .= '<link rel="stylesheet" type="text/css" href="'.$css_file_single.'">';
	}
	else
		$return .= '<link rel="stylesheet" type="text/css" href="'.$css_file.'">';
    
	if ($js_files !== NULL  && !empty($js_files))
	{
		$return .= '<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>';
		
		foreach ($js_files as $js_file)
    		$return .= '<script type="text/javascript" src="'.$js_file.'"></script>';
    }
	$return .= '</head>';
	return $return;
}

function createHiddenInput ($value, $form_id, $name)
{	
    return '<input id="'.$name.'_'.$form_id.'" name="'.$name.'" type="hidden" value="'.$value.'">';
}

function inputHint ($text)
{
	if(!$text || empty($text))
		return "";
	
	$return = "";
	
	$return .= '<div class="form-hints">';
	$return .= '<p>'.$text.'</p>';
	$return .= '</div>';
	
	return $return;
}

function addHintIcon()
{
	$question_icon = getIcon('question', 'icon_inform');
	return '<span class="mini_btn">'.$question_icon.'</span>';
}

////
// Create an input that expects a standard dice number or positive number.
// If required --> $other = 'required'
//
function createDiceInput ($value, $form_id, $name, $label, $other, $input_hints)
{
	$_value = "";
	if ($value !== NULL)
		$_value = 'value="'.$value.'"';
	
	$return = '<label for="'.$name.'_'.$form_id.'">'.$label.isRequired($other).addHintIcon().'</label>';
	$return .= inputHint($input_hints);
    $return .= '<input class="input_dice" id="'.$name.'_'.$form_id.'" name="'.$name.'" type="text" '.$_value.' '.$_maxlength.'>';
	$return .= '<div class="input_tooltip" id="'.$name.'_'.$form_id.'_tooltip"></div>';
	return $return;
}

////
// leave $maxlength as NULL if none 
// If required --> $other = 'required'
//
function createTextInput ($value, $form_id, $name, $label, $maxlength, $other, $input_hints)
{
	$_maxlength = "";
	if ($maxlength !== NULL)
		$_maxlength = 'maxlength="'.$maxlength.'"';
		
	$_value = "";
	if ($value !== NULL)
		$_value = 'value="'.$value.'"';
	
	$return = '<label for="'.$name.'_'.$form_id.'">'.$label.isRequired($other).addHintIcon().'</label>';
	$return .= inputHint($input_hints);
    $return .= '<input id="'.$name.'_'.$form_id.'" name="'.$name.'" type="text" '.$_value.' '.$_maxlength.'>';
	$return .= '<div class="input_tooltip" id="'.$name.'_'.$form_id.'_tooltip"></div>';
	return $return;
}

////
// leave $min / $min as NULL if none
// If required --> $other = 'required'
//
function createNumberInput ($value, $form_id, $name, $label, $max, $min, $other, $input_hints)
{
	$_maxmin = "";
	if ($max !== NULL)
		$_maxmin = 'max="'.$max.'"';
	if ($min !== NULL)
		$_maxmin .= 'min="'.$min.'"';
		
	$_value = "";
	if ($value !== NULL)
		$_value = 'value="'.$value.'"';
	
	$return = '<label for="'.$name.'_'.$form_id.'">'.$label.isRequired($other).addHintIcon().'</label>';
	$return .= inputHint($input_hints);
    $return .= '<input id="'.$name.'_'.$form_id.'" name="'.$name.'" type="number" '.$_value.' '.$_maxmin.' '.$other.'>';
	return $return;
}


////
// leave $rows as NULL if none
// If required/maxlength/etc --> $other = 'required'/'maxlength'/etc
//
function createTextareaInput ($value, $form_id, $name, $label, $rows, $other, $input_hints)
{
	$default_cols = "40";

	$_rows = "";
	if ($rows !== NULL)
		$_rows = 'rows="'.$rows.'"';
	
	$return = '<label for="'.$name.'_'.$form_id.'">'.$label.isRequired($other).addHintIcon().'</label>';
	$return .= inputHint($input_hints);
    $return .= '<textarea id="'.$name.'_'.$form_id.'" name="'.$name.'" '.$_rows.'>'.$value.'</textarea>';
	$return .= '<div class="input_tooltip" id="'.$name.'_'.$form_id.'_tooltip"></div>';
	return $return;
}


////
// Call this if you want any input to be allowed not just data from the datalist
// leave $data_key as NULL if we use the value instead of the key
// If required --> $other = 'required'
//
function createDatalistAnyInput ($value, $form_id, $name, $label, $other, $data, $data_key, $input_hints)
{	
	if (empty($data))
		return '<label class="label_error">Cannot display this information</label>';
	
	$_value = "";
	if ($value !== NULL)
		$_value = 'value="'.$value.'"';
	
	$return = '<label for="'.$name.'_'.$form_id.'">'.$label.isRequired($other).addHintIcon().'</label>';
	$return .= inputHint($input_hints);
	$return .= '<input class="input_datalist_any" id="'.$name.'_'.$form_id.'" list="'.$name.'_'.$form_id.'_datalist" name="'.$name.'" '.$_value.'>';
	$return .= '<datalist id="'.$name.'_'.$form_id.'_datalist">';
	if ($data_key === NULL)
	{
		foreach ($data as $option)
			$return .= '<option value="'.$option.'">';
	}
	else
	{
		foreach ($data as $option)
			$return .= '<option value="'.$option[$data_key].'">';
	}
	$return .= '</datalist>';
	$return .= '<div class="input_tooltip" id="'.$name.'_'.$form_id.'_tooltip"></div>';
	
	return $return;
} 

////
// Legacy.  Do not use.
// combines data_key1 and data_key2
// leave $data_key as NULL if we use the value instead of the key
// If required --> $other = 'required'
//
function createCombinedDatalistInput ($value1, $value2, $form_id, $label, $other, $data, $data_key1, $data_key2)
{	
	if ($data_key1 === NULL || $data_key2 === NULL)
		return '<label class="label_error">Cannot display this information</label>';

	$name = $data_key1 . 'SPC' . $data_key2;

	if (empty($data))
		return '<label class="label_error">Cannot display this information</label>';
	
	$_value = "";
	if ($value1 !== NULL && $value2 !== NULL)
		$_value .= 'value="'.$value1.' '.$value2.'"';
	else if ($value1 !== NULL)
		$_value .= 'value="'.$value1.'"';
	else if ($value2 !== NULL)
		$_value .= 'value="'.$value2.'"';
	
	$return = '<label for="'.$name.'_'.$form_id.'">'.$label . isRequired($other).addHintIcon().'</label>';
	$return .= '<input class="input_datalist" id="'.$name.'_'.$form_id.'" list="'.$name.'_'.$form_id.'_datalist" name="'.$name.'" '.$_value.'>';
	$return .= '<datalist id="'.$name.'_'.$form_id.'_datalist">';

	foreach ($data as $option)
	{
		$data_val1 = $option[$data_key1];
		$data_val2 = $option[$data_key2];
		if($data_val1 && $data_val2)
			$return .= '<option value="'.$data_val1.': '.$data_val2.'">';
		else if($data_val1)
			$return .= '<option value="'.$data_val1.'">';
		else if($data_val2)
			$return .= '<option value="'.$data_val2.'">';
	}
	$return .= '</datalist>';
	$return .= '<div class="input_tooltip" id="'.$name.'_'.$form_id.'_tooltip"></div>';
	
	return $return;
}

////
// Call this if selecting data from the datalist will result in additional form inputs
// leave $data_key as NULL if we use the value instead of the key
// If required --> $other = 'required'
//
function createDatalistInputExpand ($value, $form_id, $name, $label, $other, $data, $data_key, $input_hints)
{	
	if (empty($data))
		return '<label class="label_error">Cannot display this information</label>';
	
	$_value = "";
	if ($value !== NULL)
		$_value = 'value="'.$value.'"';
	
	$return = '<label for="'.$name.'_'.$form_id.'">'.$label.isRequired($other).addHintIcon().'</label>';
	$return .= inputHint($input_hints);
	$return .= '<input class="input_datalist_expand" id="'.$name.'_'.$form_id.'" list="'.$name.'_'.$form_id.'_datalist" name="'.$name.'" '.$_value.'>';
	$return .= '<datalist id="'.$name.'_'.$form_id.'_datalist">';
	if ($data_key === NULL)
	{
		foreach ($data as $option)
			$return .= '<option value="'.$option.'">';
	}
	else
	{
		foreach ($data as $option)
			$return .= '<option value="'.$option[$data_key].'">';
	}
	$return .= '</datalist>';
	$return .= '<div class="input_tooltip" id="'.$name.'_'.$form_id.'_tooltip"></div>';
	
	return $return;
}


////
// leave $data_key as NULL if we use the value instead of the key
// If required --> $other = 'required'
//
function createDatalistInput ($value, $form_id, $name, $label, $other, $data, $data_key, $input_hints)
{	
	if (empty($data))
		return '<label class="label_error">Cannot display this information</label>';
	
	$_value = "";
	if ($value !== NULL)
		$_value = 'value="'.$value.'"';
	
	$return = '<label for="'.$name.'_'.$form_id.'">'.$label.isRequired($other).addHintIcon().'</label>';
	$return .= inputHint($input_hints);
	$return .= '<input class="input_datalist" id="'.$name.'_'.$form_id.'" list="'.$name.'_'.$form_id.'_datalist" name="'.$name.'" '.$_value.'>';
	$return .= '<datalist id="'.$name.'_'.$form_id.'_datalist">';
	if ($data_key === NULL)
	{
		foreach ($data as $option)
			$return .= '<option value="'.$option.'">';
	}
	else
	{
		foreach ($data as $option)
			$return .= '<option value="'.$option[$data_key].'">';
	}
	$return .= '</datalist>';
	$return .= '<div class="input_tooltip" id="'.$name.'_'.$form_id.'_tooltip"></div>';
	
	return $return;
}

function isRequired($string)
{
	if (strpos($string, 'required') !== FALSE)
		return '<span class="required"> *</span>';
	return "";
}

function createErrorPage($css_file)
{
	return '<html><head><title>Error</title><link rel="stylesheet" type="text/css" href="'.$css_file.'"></head><body><div class="page-container page-small"><h1>Cannot display content</h1><p>You have attempted to access a page with incorrect information, or there is no content to show.</p></div></body></html>';
	
}

?>

