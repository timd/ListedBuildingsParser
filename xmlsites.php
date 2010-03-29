<?php

 //--------------------------------------------------------------------------
 // XMLSites
 // xmlsites.php
 //
 // (cc) 2010 Tim Duckett
 //
 // Created on 2010-03-28
 //
 // 1.0 - 28 Mar 2005
 //		- Initial version
 //--------------------------------------------------------------------------

function getSites($latitude, $longitude, $search_radius) {
	
	// Function that returns an XML list of listed buildings
	// within a given (square) radius of a provided lat and long position
	
	// Load required modules
	require_once("phpcoord.php");
	require_once("database.php");

	// Create new LatLng object
	$latlng = new LatLng($latitude, $longitude);

	// Convert lat/long to eastings/northing for use with the database
	$en = $latlng->toOSRef();
	$easting = $en->easting;
	$northing = $en->northing;
	
	// Assuming there's a valid database connection
	
	if ($db_found) {

		// Calculate the max and min eastings based on the search radius
		// Round these up to whole figures
		$max_easting = round($easting + $search_radius, 0);
		$min_easting = round($easting - $search_radius, 0);

		// Calculate the max and min eastings based on the search radius
		// Round these up to whole figures
		$max_northing = round($northing + $search_radius, 0);
		$min_northing = round($northing - $search_radius, 0);

		// Construct SQL string
		$SQL = "select LB_UID, NAME, STREET_NUM, STREET_NAM, GRADE, DATE_OF_EN, Easting, Northing from building where Easting > " . $min_easting . " AND Easting < " . $max_easting . " AND Northing > " . $min_northing . " and Northing < " . $max_northing . " order by LB_UID;";
	
		// Run SQL query and grab result
		$result = mysql_query($SQL);

		$count = 1;

		// Write out the start of the XML
		echo "<buildings>\n";

		// Iterate across the returned array and write out XML
		while ($db_field = mysql_fetch_assoc($result)) {
			
			$count++;

			// Open the building record
			print "  <building>\n";
			
			// Write out the data tags
			print "    <lb_uid>" . $db_field['LB_UID'] . "</lb_uid>\n";
			print "    <name>" . $db_field['NAME'] . "</name>\n";
			print "    <street_num>" . $db_field['STREET_NUM'] . "</street_num>\n";
			print "    <streen_nam>" . $db_field['STREET_NAM'] . "</street_nam>\n";
			print "    <grade>" . $db_field['GRADE'] . "</grade>\n";
			print "    <date_of_en>" . $db_field['DATE_OF_EN'] . "</date_of_en>\n";			
			print "    <easting>" . $db_field['Easting'] . "</easting>\n";
			print "    <northing>" . $db_field['Northing'] . "<northing>\n";
	
			// Convert the returned eastings & northings to lat/lng
			$os1 = new OSRef($db_field['Easting'], $db_field['Northing']);
			$ll1 = $os1->toLatLng();

			// Write out the lat/lng tags
			print "    <lat>" . $ll1->lat . "</lat>\n";
			print "    <lng>" . $ll1->lng . "</lng>\n";
			
			// Close the building record
			print "  </building>\n";

		}

		// Close the buildings tag
		print "</buildings>\n";

	}
	else 
	{
		
		// There was some kind of problem with the database, so write out an error message
		print "<buildings>\n";
		print " <building>DATABASE ERROR</building>\n";
		print "</buildings>\n";

	}

	// Close the database connection
	mysql_close($db_handle);
}

?>