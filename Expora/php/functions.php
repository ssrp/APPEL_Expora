<?php

	/******************GENERIC FUNCTIONS FOR DIFFERENT DBMS***********************/
	global $prefix;
	function runQuery($connection, $query)
	{
		global $system;
		if($system == "MySQL")
		{
			return mysqli_query($connection, $query);
		}
		else if($system == "PostgreSQL")
		{
			return pg_query($query);
		}
	}
	function returnError($connection)
	{
		global $system;
		if($system == "MySQL")
		{
			return mysqli_error($connection);
		}
		else if($system == "PostgreSQL")
		{
			return pg_last_error();
		}
	}
	function getRows($result)
	{
		global $system;
		if($system == "MySQL")
		{
			return mysqli_num_rows($result);
		}
		else if($system == "PostgreSQL")
		{
			return pg_num_rows($result);
		}
	}
	function getColumns($result)
	{
		global $system;
		if($system == "MySQL")
		{
			return mysqli_num_fields($result);
		}
		else if($system == "PostgreSQL")
		{
			return pg_num_fields($result);
		}
	}
	function fetchFieldName($result, $i)
	{
		global $system;
		if($system == "MySQL")
		{
			$field = mysqli_fetch_field($result);
			return $field->name;
		}
		else if($system == "PostgreSQL")
		{
			return pg_field_name($result, $i);
		}
	}
	function fetchArray($result)
	{
		global $system;
		if($system == "MySQL")
		{
			return mysqli_fetch_array($result);
		}
		else if($system == "PostgreSQL")
		{
			return pg_fetch_array($result);
		}
	}
	function fetchAssoc($result)
	{
		global $system;
		if($system == "MySQL")
		{
			return mysqli_fetch_assoc($result);
		}
		else if($system == "PostgreSQL")
		{
			return pg_fetch_assoc($result);
		}
	}
	function closeConnection($connection)
	{
		global $system;
		if($system == "MySQL")
		{
			return mysqli_close($connection);
		}
		else if($system == "PostgreSQL")
		{
			return pg_close($connection);
		}
	}
	/*********************END OF GENERIC FUNCTIONS*********************/

?>