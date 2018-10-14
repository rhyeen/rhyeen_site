<?php

class SomeClass {
	//// class member variables
	private $class_mem = '';
	
	private $_public_mem = '';
	
	/**
	 * Default constructor.
	 *
	 */
	public function __construct($param)
	{
		$this->class_mem = $param;
	}

	public function someFunction()
	{
		return $this->class_mem;
	}
	
	/** 
	 * Getter
	 */
	public function __get($property)
	{
		switch ($property)
		{
			case 'public_mem':
				return $this->_public_mem;
		}
	}
	
	/** 
	 * Setter
	 */
	public function __set($property, $value)
	{
		switch ($property)
		{
			case 'public_mem':
				$this->_public_mem = $value;
				break;
		}
	}
	
	/**
	 * toString
	 */
	public function __toString()
	{
		return "$this->_public_mem";
	}
}



?>