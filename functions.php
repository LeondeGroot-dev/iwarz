<?php

function DrawTable( $whattodraw, $howtoembrace, $link, $current, $headText ) {
	$numbers = array(
		0 => "01",		1 => "02",		2 => "03",		3 => "04",
		4 => "05",		5 => "06",		6 => "07",		7 => "08",
		8 => "09",		9 => "10",		10 => "11",		11 => "12" );
	$letters = array(
		0 => "A",		1 => "B",		2 => "C",		3 => "D",
		4 => "E",		5 => "F",		6 => "G",		7 => "H",
		8 => "I",		9 => "J",		10 => "K",		11 => "L" );
	$todraw = array();
	$result_locations = mysql_query( "SELECT * FROM locations;" );
	$num_locations = mysql_numrows($result_locations);
	$resgiffiles = array(
		0 => "img/_square_res0.gif",
		1 => "img/_square_res1.gif",
		2 => "img/_square_res2.gif",
		3 => "img/_square_res3.gif",
		4 => "img/_square_res4.gif",
		5 => "img/_square_res5.gif" );
	// Always draw resources
	if( $current ) {
		$result = mysql_query( "SELECT part3Ends FROM locations ORDER BY part3Ends DESC LIMIT 0, 1;" );
		$mostbases = mysql_result( $result, 0, "part3Ends" );
		if( !$mostbases ) {
			$mostbases = 1;
		}
		$division = $mostbases * 0.2;
		for( $n = 0; $n < $num_locations; $n++ ) {
			$locationId = mysql_result( $result_locations, $n, "locationId" );
			$tmp_result = mysql_query( "SELECT baseId FROM bases WHERE locationId=\"$locationId\";" );
			$position = LocationId2XY( $locationId );
			if( !mysql_numrows($tmp_result) ) {
				$resources[$position[x]][$position[y]] = 0;
				continue;
			}
			$curshare = $mostbases - mysql_result( $result_locations, $n, "lastTakenShare" );
			$curshare /= $division;
			$resources[$position[x]][$position[y]] = round($curshare);
		}
	}
	else {
		$result = mysql_query( "SELECT resources FROM locations ORDER BY resources DESC LIMIT 0, 1;" );
		$highestres = mysql_result( $result, 0, "resources" );
		if( !$highestres ) {
			echo("!");
			$highestres = 1;
		}
		$division = $highestres * 0.2;
		for( $n = 0; $n < $num_locations; $n++ ) {
			$position = LocationId2XY( mysql_result( $result_locations, $n, "locationId" ) );
			$curresources = mysql_result( $result_locations, $n, "resources" );
			$curresources /= $division;
			$resources[$position[x]][$position[y]] = round($curresources);
		}
	}
	switch( $whattodraw ) {
		case "DOMINATION": {
			for( $n = 0; $n < $num_locations; $n++ ) {
				$position = LocationId2XY( mysql_result( $result_locations, $n, "locationId" ) );
				$domination[$position[x]][$position[y]] = mysql_result( $result_locations, $n, "dominatingTeam" );
			}
			for( $y = 0; $y < 12; $y++ ) {
				for( $x = 0; $x < 12; $x++ ) {
					$giffiles = array(
						0 => "img/_square_transparent.gif",
						1 => "img/_square_red.gif",
						2 => "img/_square_black.gif",
						3 => "img/_square_orange.gif",
						4 => "img/_square_green.gif",
						5 => "img/_square_warning.gif" );
					$code = $letters[$x] . $numbers[$y];
					$res = $resources[$x][$y];
$rrr = rand( 1, 4 );
					$todraw[$x][$y] = "<img src=\"{$resgiffiles[$res]}\" style=\"border: 0;\"> <img src=\"{$giffiles[$domination[$x][$y]]}\" style=\"border: 0;\"><br>$code";
				}
			}
			break;
		}
		case "MYBASES": {
			$result_mybases = mysql_query( "SELECT * FROM bases WHERE userId=$_SESSION[userid];" );
			$num_mybases = mysql_numrows($result_mybases);
			for( $n = 0; $n < $num_mybases; $n++ ) {
				$position = LocationId2XY( mysql_result( $result_mybases, $n, "locationId" ) );
				$base[$position[x]][$position[y]] = true;
			}
			$result_accounts = mysql_query( "SELECT * FROM accounts WHERE userId=$_SESSION[userid];" );
			$myteam = mysql_result( $result_accounts, 0, "team" );
			$giffiles = array(
				1 => "img/_square_red.gif",
				2 => "img/_square_black.gif",
				3 => "img/_square_orange.gif",
				4 => "img/_square_green.gif" );
			for( $y = 0; $y < 12; $y++ ) {
				for( $x = 0; $x < 12; $x++ ) {
					$code = $letters[$x] . $numbers[$y];
					$res = $resources[$x][$y];
					if( $base[$x][$y] ) {
						$todraw[$x][$y] = "<img src=\"{$resgiffiles[$res]}\" style=\"border: 0;\"> <img src=\"$giffiles[$myteam]\" style=\"border: 0;\"><br>$code";
					}
					else {
						$todraw[$x][$y] = "<img src=\"{$resgiffiles[$res]}\" style=\"border: 0;\"> <img src=\"img/_square_transparent.gif\" style=\"border: 0;\"><br>$code";
					}
				}
			}
			break;
		}
		case "MYARMY": {
			$result_mytanks = mysql_query( "SELECT * FROM tanks WHERE userId=$_SESSION[userid];" );
			$num_mytanks = mysql_numrows($result_mytanks);
			for( $n = 0; $n < $num_mytanks; $n++ ) {
				$position = LocationId2XY( mysql_result( $result_mytanks, $n, "locationId" ) );
				$army[$position[x]][$position[y]] = true;
			}
			$result_myairplanes = mysql_query( "SELECT * FROM airplanes WHERE userId=$_SESSION[userid];" );
			$num_myairplanes = mysql_numrows($result_myairplanes);
			for( $n = 0; $n < $num_myairplanes; $n++ ) {
				$position = LocationId2XY( mysql_result( $result_myairplanes, $n, "locationId" ) );
				$army[$position[x]][$position[y]] = true;
			}
			$result_accounts = mysql_query( "SELECT * FROM accounts WHERE userId=$_SESSION[userid];" );
			$myteam = mysql_result( $result_accounts, 0, "team" );
			$giffiles = array(
				1 => "img/_square_red.gif",
				2 => "img/_square_black.gif",
				3 => "img/_square_orange.gif",
				4 => "img/_square_green.gif" );
			for( $y = 0; $y < 12; $y++ ) {
				for( $x = 0; $x < 12; $x++ ) {
					$code = $letters[$x] . $numbers[$y];
					$res = $resources[$x][$y];
					if( $army[$x][$y] ) {
						$todraw[$x][$y] = "<img src=\"{$resgiffiles[$res]}\" style=\"border: 0;\"> <img src=\"$giffiles[$myteam]\" style=\"border: 0;\"><br>$code";
					}
					else {
						$todraw[$x][$y] = "<img src=\"{$resgiffiles[$res]}\" style=\"border: 0;\"> <img src=\"img/_square_transparent.gif\" style=\"border: 0;\"><br>$code";
					}
				}
			}
			break;
		}
	}
	switch( $howtoembrace ) {
		case "OWNTEAMANDNOBODIES": {
			$result_accounts = mysql_query( "SELECT * FROM accounts WHERE userId=$_SESSION[userid];" );
			$myteam = mysql_result( $result_accounts, 0, "team" );
			$dolink = array();
			for( $n = 0; $n < $num_locations; $n++ ) {
				$position = LocationId2XY( mysql_result( $result_locations, $n, "locationId" ) );
				if( !mysql_result( $result_locations, $n, "dominatingTeam" ) || mysql_result( $result_locations, $n, "dominatingTeam" ) == $myteam ) {
					$dolink[$position[x]][$position[y]] = true;
				}
			}
			echo( "<table id=\"mapTable\" cellspacing=\"0\" cellpadding=\"0\">\n" );
			echo( "	<tr>\n		<th colspan=\"12\">$headText</th>\n	</tr>\n" );
			for( $y = 0; $y < 12; $y++ ) {
				echo( "	<tr>\n" );
				for( $x = 0; $x < 12; $x++ ) {
					$code = $letters[$x] . $numbers[$y];
					$thislink = str_replace ( "%location%", $code, $link );
					if( $dolink[$x][$y] ) {
						echo( "		<td><a href=\"{$thislink}\">{$todraw[$x][$y]}</a></td>\n" );
					}
					else {
						echo( "		<td><div>{$todraw[$x][$y]}</div></td>\n" );
					}
				}
				echo( "	</tr>\n" );
			}
			echo( "</table>\n" );
			break;
		}
		case "MYBASES": {
			if( $whattodraw != "MYBASES" ) {
				$result_mybases = mysql_query( "SELECT * FROM bases WHERE userId=$_SESSION[userid];" );
				$num_mybases = mysql_numrows($result_mybases);
				for( $n = 0; $n < $num_mybases; $n++ ) {
					$position = LocationId2XY( mysql_result( $result_mybases, $n, "locationId" ) );
					$base[$position[x]][$position[y]] = true;
				}			
			}
			echo( "<table id=\"mapTable\" cellspacing=\"0\" cellpadding=\"0\">\n" );
			echo( "	<tr>\n		<th colspan=\"12\">$headText</th>\n	</tr>\n" );
			for( $y = 0; $y < 12; $y++ ) {
				echo( "	<tr>\n" );
				for( $x = 0; $x < 12; $x++ ) {
					$code = $letters[$x] . $numbers[$y];
					$thislink = str_replace ( "%location%", $code, $link );
					if( $base[$x][$y] ) {
						echo( "		<td><a href=\"{$thislink}\">{$todraw[$x][$y]}</a></td>\n" );
					}
					else {
						echo( "		<td><div>{$todraw[$x][$y]}</div></td>\n" );
					}
				}
				echo( "	</tr>\n" );
			}
			echo( "</table>\n" );
			break;
		}
		case "MYARMY": {
			if( $whattodraw != "MYARMY" ) {
				$result_mytanks = mysql_query( "SELECT * FROM tanks WHERE userId=$_SESSION[userid];" );
				$num_mytanks = mysql_numrows($result_mytanks);
				for( $n = 0; $n < $num_mytanks; $n++ ) {
					$position = LocationId2XY( mysql_result( $result_mytanks, $n, "locationId" ) );
					$army[$position[x]][$position[y]] = true;
				}			
				$result_myairplanes = mysql_query( "SELECT * FROM airplanes WHERE userId=$_SESSION[userid];" );
				$num_myairplanes = mysql_numrows($result_myairplanes);
				for( $n = 0; $n < $num_myairplanes; $n++ ) {
					$position = LocationId2XY( mysql_result( $result_myairplanes, $n, "locationId" ) );
					$army[$position[x]][$position[y]] = true;
				}
			}
			echo( "<table id=\"mapTable\" cellspacing=\"0\" cellpadding=\"0\">\n" );
			echo( "	<tr>\n		<th colspan=\"12\">$headText</th>\n	</tr>\n" );
			for( $y = 0; $y < 12; $y++ ) {
				echo( "	<tr>\n" );
				for( $x = 0; $x < 12; $x++ ) {
					$code = $letters[$x] . $numbers[$y];
					$thislink = str_replace ( "%location%", $code, $link );
					if( $army[$x][$y] ) {
						echo( "		<td><a href=\"{$thislink}\">{$todraw[$x][$y]}</a></td>\n" );
					}
					else {
						echo( "		<td><div>{$todraw[$x][$y]}</div></td>\n" );
					}
				}
				echo( "	</tr>\n" );
			}
			echo( "</table>\n" );
			break;
		}
		case "ALL": {
			echo( "<table id=\"mapTable\" cellspacing=\"0\" cellpadding=\"0\">\n" );
			echo( "	<tr>\n		<th colspan=\"12\">$headText</th>\n	</tr>\n" );
			for( $y = 0; $y < 12; $y++ ) {
				echo( "	<tr>\n" );
				for( $x = 0; $x < 12; $x++ ) {
					$code = $letters[$x] . $numbers[$y];
					$thislink = str_replace ( "%location%", $code, $link );
					echo( "		<td><a href=\"{$thislink}\">{$todraw[$x][$y]}</a></td>\n" );
				}
				echo( "	</tr>\n" );
			}
			echo( "</table>\n" );
			break;		
		}
		case "ANYBASE": {
			echo( "<table id=\"mapTable\" cellspacing=\"0\" cellpadding=\"0\">\n" );
			echo( "	<tr>\n		<th colspan=\"12\">$headText</th>\n	</tr>\n" );
			for( $y = 0; $y < 12; $y++ ) {
				echo( "	<tr>\n" );
				for( $x = 0; $x < 12; $x++ ) {
					$code = $letters[$x] . $numbers[$y];
					$result = mysql_query( "SELECT baseId FROM bases WHERE locationId=\"$code\";" );
					if( mysql_numrows($result) ) {
						$thislink = str_replace ( "%location%", $code, $link );
						echo( "		<td><a href=\"{$thislink}\">{$todraw[$x][$y]}</a></td>\n" );
					}
					else {
						echo( "		<td><div>{$todraw[$x][$y]}</div></td>\n" );
					}
				}
				echo( "	</tr>\n" );
			}
			echo( "</table>\n" );
			exit;
			break;
		}
		case "NONE": {
			echo( "<table id=\"mapTable\" cellspacing=\"0\" cellpadding=\"0\">\n" );
			echo( "	<tr>\n		<th colspan=\"12\">$headText</th>\n	</tr>\n" );
			for( $y = 0; $y < 12; $y++ ) {
				echo( "	<tr>\n" );
				for( $x = 0; $x < 12; $x++ ) {
					$code = $letters[$x] . $numbers[$y];
					echo( "		<td><div>{$todraw[$x][$y]}</div></td>\n" );
				}
				echo( "	</tr>\n" );
			}
			echo( "</table>\n" );
			break;
		}
	}
	return;
}

function EmailIsValid($email) {
	if($email == "mail@localhost") {
		return true;
	}
	// First, we check that there's one @ symbol, and that the lengths are right
	if (!ereg("^[^@]{1,64}@[^@]{1,255}$", $email)) {
		// Email invalid because wrong number of characters in one section, or wrong number of @ symbols.
		return false;
	}
	// Split it into sections to make life easier
	$email_array = explode("@", $email);
	$local_array = explode(".", $email_array[0]);
	for ($i = 0; $i < sizeof($local_array); $i++) {
		if (!ereg("^(([A-Za-z0-9!#$%&'*+/=?^_`{|}~-][A-Za-z0-9!#$%&'*+/=?^_`{|}~\.-]{0,63})|(\"[^(\\|\")]{0,62}\"))$", $local_array[$i])) {
			return false;
		}
	}
	if (!ereg("^\[?[0-9\.]+\]?$", $email_array[1])) { // Check if domain is IP. If not, it should be valid domain name
		$domain_array = explode(".", $email_array[1]);
		if (sizeof($domain_array) < 2) {
			return false; // Not enough parts to domain
		}
		for ($i = 0; $i < sizeof($domain_array); $i++) {
			if (!ereg("^(([A-Za-z0-9][A-Za-z0-9-]{0,61}[A-Za-z0-9])|([A-Za-z0-9]+))$", $domain_array[$i])) {
				return false;
			}
		}
	}
	return true;
}

function LocationId2XY( $location ) {
	$rletters = array(
		"A" => 0,		"B" => 1,		"C" => 2,		"D" => 3,
		"E" => 4,		"F" => 5,		"G" => 6,		"H" => 7,
		"I" => 8,		"J" => 9,		"K" => 10,		"L" => 11 );
	$rnumbers = array(
		"01" => 0,		"02" => 1,		"03" => 2,		"04" => 3,
		"05" => 4,		"06" => 5,		"07" => 6,		"08" => 7,
		"09" => 8,		"10" => 9,		"11" => 10,		"12" => 11 );
	$letter = substr( $location, 0, 1 );
	$number = substr( $location, 1, 2 );
	return array( 
		'x' => $rletters[$letter], 'y' => $rnumbers[$number] );
}

function UpdateResources() {
	$result = mysql_query( "SELECT resources FROM locations ORDER BY resources DESC LIMIT 0, 1;" );
	$highestres = mysql_result( $result, 0, "resources" );
	if( !$highestres ) {
//		echo( "HOI" ); exit;
//		return;
	}
	$result_locations = mysql_query( "SELECT * FROM locations" );
	$num_locations = mysql_numrows($result_locations);
	for( $n = 0; $n < $num_locations; $n++ ) {
		$resources = mysql_result( $result_locations, $n, "resources" );
		$locationId = mysql_result( $result_locations, $n, "locationId" );
		$result_bases = mysql_query( "SELECT * FROM bases WHERE locationId=\"$locationId\";" );
		$num_bases = mysql_numrows( $result_bases );
		$share1 = 0; $share2 = 0; $share3 = 0;
		if( !$num_bases ) {
			$part1Ends = 0; $part2Ends = 0; $part3Ends = 0;
			$share1 = $resources; $share2 = $resources; $share3 = $resources;
		}
		elseif( $num_bases == 1 ) {
			$part1Ends = 1; $part2Ends = 1; $part3Ends = 1;
			$share1 = $resources; $share2 = $resources; $share3 = $resources;
		}
		elseif( $num_bases == 2 ) {
			$part1Ends = 1; $part2Ends = 2; $part3Ends = 2;
			$share1 = $resources * 0.6; $share2 = $resources * 0.3; $share3 = $resources * 0.3;
		}
		elseif( $num_bases == 3 ) {
			$part1Ends = 1; $part2Ends = 2; $part3Ends = 3;
			$share1 = $resources * 0.6; $share2 = $resources * 0.3; $share3 = $resources * 0.1;
		}
		else {
			$share1 = round( $resources * 0.6 );
			$share2 = round( $resources * 0.3 );
			$share3 = round( $resources * 0.05 );
			$part1Ends = round( $num_bases * 0.15 ) + 1;
			$part2Ends = round( $num_bases * 0.40 ) + 1;
			$part3Ends = round( $num_bases * 0.7 ) + 1;
		}
 		mysql_query( "UPDATE locations SET share1=$share1 WHERE locationId=\"$locationId\";" );
		mysql_query( "UPDATE locations SET share2=$share2 WHERE locationId=\"$locationId\";" );
		mysql_query( "UPDATE locations SET share3=$share3 WHERE locationId=\"$locationId\";" );
		mysql_query( "UPDATE locations SET part1Ends=$part1Ends WHERE locationId=\"$locationId\";" );
		mysql_query( "UPDATE locations SET part2Ends=$part2Ends WHERE locationId=\"$locationId\";" );
		mysql_query( "UPDATE locations SET part3Ends=$part3Ends WHERE locationId=\"$locationId\";" );
		mysql_query( "UPDATE locations SET lastTakenShare=0 WHERE locationId=\"$locationId\";" );
	}
	return;
}

function UpdateTables() {
	$result = mysql_query( "SELECT * FROM bases" );
	$num = mysql_numrows($result);

	$teamDomination = array();
	for( $n = 0; $n < $num; $n++ ) {
		$team = mysql_result( $result, $n, "team" );
		$code = mysql_result( $result, $n, "locationId" );
		$location = LocationId2XY($code);
		$teamDomination[$team][$location['x']][$location['y']]++;
	}
	$numbers = array(
		0 => "01",		1 => "02",		2 => "03",		3 => "04",
		4 => "05",		5 => "06",		6 => "07",		7 => "08",
		8 => "09",		9 => "10",		10 => "11",		11 => "12" );
	$letters = array(
		0 => "A",		1 => "B",		2 => "C",		3 => "D",
		4 => "E",		5 => "F",		6 => "G",		7 => "H",
		8 => "I",		9 => "J",		10 => "K",		11 => "L" );
	$calculatedDomination = array();
	for( $x = 0; $x < 12; $x++ ) {
		for( $y = 0; $y < 12; $y++ ) {
			$code = "{$letters[$x]}{$numbers[$y]}";
			$equalTeams = false;
			$localWinner = 0;
			$localDominatingTeam = 0;
			for( $t = 1; $t <= 4; $t++ ) {
				if( $teamDomination[$t][$x][$y] > $localWinner ) {
					$localWinner = $teamDomination[$t][$x][$y];
					$localDominatingTeam = $t;
					$equalTeams = false;
				}
				elseif( $teamDomination[$t][$x][$y] == $localWinner ) {
					$equalTeams = true;
				}
				if( !$localWinner ) {
					mysql_query( "UPDATE locations SET dominatingTeam=0 WHERE locationId=\"$code\";" );
					$calculatedDomination[$x][$y] = 0;
				}
				elseif( $equalTeams ) {
					mysql_query( "UPDATE locations SET dominatingTeam=5 WHERE locationId=\"$code\";" );
					$calculatedDomination[$x][$y] = 5;
				}
				else {
					mysql_query( "UPDATE locations SET dominatingTeam=$localDominatingTeam WHERE locationId=\"$code\";" );
					$calculatedDomination[$x][$y] = $localDominatingTeam;
				}
			}
		}
	}
	return;
}

?>