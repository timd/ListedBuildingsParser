<?php

//--------------------------------------------------------------------------
// Database handler
// database.php
//
// (cc) 2010 Tim Duckett
//
// Created on 2010-03-28
//
// 1.0 - 28 Mar 2005
//		- Initial version
//--------------------------------------------------------------------------

	$user_name = "listing";
	$password = "****";
	$database = "ListedBuildings";
	$server = "127.0.0.1:8889";
	$db_handle = mysql_connect($server, $user_name, $password);
	$db_found = mysql_select_db($database, $db_handle);

?>