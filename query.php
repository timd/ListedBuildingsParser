<?php

//--------------------------------------------------------------------------
// XMLSites
// Code to receive XML query string, escape to make safe for MySQL and retrieve the
// buildings data
//
// xmlsites.php
//
// (cc) 2010 Tim Duckett
//
// Created on 2010-03-28
//
// 1.0 - 28 Mar 2005
//		- Initial version
//--------------------------------------------------------------------------

	// Pull in the xmlsites code
	require_once("xmlsites.php");

	// Escape the supplied query strings
	$latitude = mysql_real_escape_string($_GET['lat']);
	$longitude = mysql_real_escape_string($_GET['lng']);
	$radius = mysql_real_escape_string($_GET['radius']);
	$full_status = mysql_real_escape_string($_GET['full']);

	// Run the query
	
	if ($_GET['html'] == 'true') {
		
		getHTMLSites($latitude, $longitude, $radius, $full_status);
		
	} else {
	
		getSites($latitude, $longitude, $radius, $full_status);
		
	}

?>