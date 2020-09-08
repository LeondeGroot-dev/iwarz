<?php

include( "config.php" );
include( "functions.php" );

include( "init.php" );

switch( $_GET[request] ) {

	case "login": 
		$errors = false;
		$errorlist = "<ul class=\"errorList\">\n";
		$result = mysql_query( "SELECT * FROM accounts WHERE username=\"$_POST[username]\";" );
		if( mysql_numrows($result) ) {
			if( mysql_result( $result, 0, "password" ) == md5($_POST[password]) ) {
				$_SESSION[userid] = mysql_result( $result, 0, "userid" );
				if( $_POST[remember] ) {
					setcookie( "userid", mysql_result( $result, 0, "userId" ), time() + 3600 * 24 * 28, "/" );
				}
			}
			else {
				$errors = true;
				$errorlist = "$errorlist	<li>Login incorrect</li>\n";
			}
		}
		else {
			$errors = true;
			$errorlist = "$errorlist	<li>Login incorrect</li>\n";
		}
		$errorlist = "$errorlist</ul>\n";
		if( $errors ) {
			$_SESSION[errors] = $errors;
			$_SESSION[errorlist] = $errorlist;
		} 
		header( "location: ." );
		break;

	case "logout":
		session_destroy();
		setcookie( "userid", "", -1, "/" );
		header( "location: ." );
		break;
		
	case "register":
		$errors = false;
		$errorlist = "<ul class=\"errorList\">\n";
		if( $_POST[username] == NULL ) {
			$errors = true;
			$errorlist = "$errorlist	<li>No username entered</li>\n";
		}
		else {
			$temp = mysql_query( "SELECT * FROM accounts WHERE username=\"$_POST[username]\"" );
			if( mysql_numrows($temp) ) {
				$errors = true;
				$errorlist = "$errorlist	<li>Username already in use</li>\n";
			}
		}
		if( $_POST[password1] == NULL ) { 
			$errors = true;	
			$errorlist = "$errorlist	<li>No password entered or passwords don't match</li>\n";
		}
		elseif( $_POST[password1] != $_POST[password2] ) {
			$errors = true;	
			$errorlist = "$errorlist	<li>Passwords don't match</li>\n";
		}
		if( !EmailIsValid($_POST[email]) ) {
			$errors = true;
			$errorlist = "$errorlist	<li>Invalid e-mail address</li>\n";
		}
		$result = mysql_query( "SELECT * FROM accounts WHERE email=\"$_POST[email]\"" );
		if( mysql_numrows($result) > 0 ) {
			$errors = true;
			$errorlist = "$errorlist	<li>E-mail address already in use</li>\n";
		}
		if( $_POST[team] == NULL ) {
			$errors = true;
			$errorlist = "$errorlist	<li>No color selected</li>\n";
		}
		$errorlist = "$errorlist</ul>\n";
		if( $errors ) {
			$_SESSION[errors] = $errors;
			$_SESSION[errorlist] = $errorlist;
			header( "location: ." );
			break;
		}
		else {
			$errorlist = "";
			$md5password = MD5($_POST[password1]);
			$activationkey = rand( 1000000000, 9999999999 );
			mysql_query( "INSERT INTO accounts( username, password, email, activationkey, team, resources ) VALUES( \"$_POST[username]\", \"$md5password\", \"$_POST[email]\", $activationkey, $_POST[team], $vars[playerstart_resources] );" );
			$result = mysql_query( "SELECT userId FROM accounts WHERE username=\"$_POST[username]\";" );
			$userid = mysql_result( $result, 0, "userId" );
			$headers =
				"From: i-warz@hetnet.nl\r\n" .
				"X-Mailer: php";
			$message = 
				"You are one click away from activating your account at iWarz.\n\n" .
				"http://projects.leondegroot.nl/iwarz/?request=activate&userid=$userid&activationkey=$activationkey\n\n" .
				"Good luck!";
			$message = wordwrap($message, 70);
			mail( "$_POST[email]", "Activate your  iWarz account", "$message", "$headers");
			$_SESSION[userid] = $userid;
			setcookie( "userid", "", -1, "/" );
			header( "location: ." );
		}
		break;
	
	case "activate": 
		$result = mysql_query( "SELECT activationkey FROM accounts WHERE userid=$_GET[userid]" );
		if( mysql_numrows($result) == 0 ) {
			$errorlist = "<ul class=\"errorList\">\n	<li>User doesn't exist</li>\n</ul>\n";
			$_SESSION[errorlist] = $errorlist;
			$_SESSION[errors] = true;
			$_SESSION[userid] = 0;
			header( "Location: ." );
			break;
		}
		$keyfromdb = mysql_result( $result, 0, "activationkey" );
		if( $keyfromdb == 0 ) {
			$errorlist = "<ul class=\"errorList\">\n	<li>Account is already active</li>\n</ul>\n";
			$_SESSION[errorlist] = $errorlist;
			$_SESSION[errors] = true;
			$_SESSION[userid] = 0;
			header( "Location: ." );
			break;
		}
		if( $keyfromdb != $_GET[activationkey] ) {
			$errorlist = "<ul class=\"errorList\">\n	<li>Activation key is invalid</li>\n</ul>\n";
			$_SESSION[errorlist] = $errorlist;
			$_SESSION[errors] = true;
			$_SESSION[userid] = 0;
			header( "Location: ." );
			break;
		}
		mysql_query( "UPDATE accounts SET activationkey=0 WHERE userid=$_GET[userid]" );
		$_SESSION[userid] = $_GET[userid];
		header( "Location: ." );
		break;


	case "airstrike": {
		$result_target = mysql_query( "SELECT * FROM bases WHERE baseId=$_GET[baseid];" );
		$condition = mysql_result( $result_target, 0, "condition" );
		$result_airplanes = mysql_query( "SELECT * FROM airplanes WHERE locationid=\"$_GET[from]\" AND userid=$_SESSION[userid];" );
		$condition -= mysql_result($result_airplanes,0,"airplanes");
		if( $condition < 0 ) {
			$condition = 0;
		}
		mysql_query( "UPDATE bases SET bases.condition=$condition WHERE baseid=$_GET[baseid];" );
		$_SESSION[from] = $_GET[from];
		$_SESSION[baseid] = $_GET[baseid];
		$time = Time();
		mysql_query( "UPDATE airplanes SET lastAirstrike=$time WHERE userid=$_SESSION[userid] AND locationId=\"$_GET[from]\";" );
		header( "location: .?page=airstrike_succesful" );
		break;
	}

	case "b_option1": {
		$result_building = mysql_query( "SELECT * FROM buildings WHERE buildingId=$_GET[building];" );
		$buildingType = mysql_result( $result_building, 0, "buildingType" );
		if( !mysql_numrows($result_building) ) {
			mysql_close($mysql_link);
			header("HTTP/1.0 404 Not Found");
			exit;
		}
		$lastTimeUsed = mysql_result( $result_building, 0, "lastTimeUsed" );
		$time = time();
		$times = array(
			1 => $vars[time_buildtank],
			2 => $vars[time_buildairplane] );
		if( $time - $lastTimeUsed < $times[$buildingType] ) {
			mysql_close($mysql_link);
			header("HTTP/1.0 404 Not Found");
			exit;
		}
		$baseId = mysql_result( $result_building, 0, "baseId" );
		$result_base = mysql_query( "SELECT * FROM bases WHERE baseId=$baseId;" );
		$locationId = mysql_result( $result_base, 0, "locationId" );
		if( mysql_result( $result_base, 0, "userId" ) != $_SESSION[userid] ) {
			mysql_close($mysql_link);
			header("HTTP/1.0 404 Not Found");
			exit;
		}
		$result_account = mysql_query( "SELECT * FROM accounts WHERE userId=$_SESSION[userid];" );
		$team = mysql_result( $result_account, 0, "team" );
		$cost = array(
			1 => $vars[cost_tank],
			2 => $vars[cost_airplane] );
		$myResources = 0 + mysql_result( $result_account, 0, "resources" );
		if( $cost[$buildingType] > $myResources ) {
			mysql_close($mysql_link);
			header("HTTP/1.0 404 Not Found");
			exit;
		}
		$myResources -= $cost[$buildingType];
		mysql_query( "UPDATE accounts SET resources=$myResources WHERE userId=$_SESSION[userid];" );
		switch($buildingType) {
			case 1: {
				$result_tanks = mysql_query( "SELECT * FROM tanks WHERE userId=$_SESSION[userid] and locationId=\"$locationId\";" );
				if( !mysql_numrows($result_tanks) ) {
					mysql_query( "INSERT INTO tanks( userId, locationId, team, tanks ) VALUES( $_SESSION[userid], \"$locationId\", $team, 1 );" );
				}
				else {
					$tanks = 0 + mysql_result( $result_tanks, 0, "tanks" );
					$tanks++;
					mysql_query( "UPDATE tanks SET tanks=$tanks WHERE userId=$_SESSION[userid] and locationId=\"$locationId\";" );
				}
				break;
			}
			case 2: {
				$result_airplanes = mysql_query( "SELECT * FROM airplanes WHERE userId=$_SESSION[userid] and locationId=\"$locationId\";" );
				if( !mysql_numrows($result_airplanes) ) {
					mysql_query( "INSERT INTO airplanes( userId, locationId, team, airplanes ) VALUES( $_SESSION[userid], \"$locationId\", $team, 1 );" );
				}
				else {
					$airplanes = 0 + mysql_result( $result_airplanes, 0, "airplanes" );
					$airplanes++;
					mysql_query( "UPDATE airplanes SET airplanes=$airplanes WHERE userId=$_SESSION[userid] and locationId=\"$locationId\";" );
				}
				break;
			}
		}
		mysql_query( "UPDATE buildings SET lastTimeUsed=$time WHERE buildingId=$_GET[building];" );
		mysql_close($mysql_link);
		header( "Location: ./?page=bases&location=$locationId" );
		exit;
	}

	case "build": {
		$errors = false;
//		$errorlist = "<ul>\n";
		$time = time();
		$result_base = mysql_query( "SELECT * FROM bases WHERE baseId=$_GET[base];" );
		if( $time - mysql_result( $result_base, 0, "lastTimeBuilding" ) < 60 ) {
			mysql_close($mysql_link);
			header("HTTP/1.0 404 Not Found");
			exit;
		}
		if( !mysql_numrows($result_base) ) {
			mysql_close($mysql_link);
			header("HTTP/1.0 404 Not Found");
			exit;
		}
		if( mysql_result( $result_base, 0, "userId" ) != $_SESSION[userid] ) {
			mysql_close($mysql_link);
			header("HTTP/1.0 404 Not Found");
			exit;
		}
		$result_account = mysql_query( "SELECT * FROM accounts WHERE userId=$_SESSION[userid];" );
		$cost = 0;
		switch( $_POST[building] ) {
			case "1": {
				$cost = $vars[cost_factory];
				break;
			}
			case "2": {
				$cost = $vars[cost_airfield];
				break;
			}			
			default: {
				header("HTTP/1.0 404 Not Found");
				exit;
			}
		}
		$myResources = mysql_result( $result_account, 0, "resources" );
		if( $cost > $myResources ) {
			$errors = true;
		}
//		$errorlist .= "</ul>\n";
		if( $errors ) {
//			$_SESSION[errors] = $errors;
//			$_SESSION[errorlist] = $errorlist;
			mysql_close($mysql_link);
			header("HTTP/1.0 404 Not Found");
			exit;
		}
		$myResources -= $cost;
		$locationId = mysql_result( $result_base, 0, "locationId" );
		mysql_query( "UPDATE accounts SET resources=$myResources WHERE userId=$_SESSION[userid];" );
		mysql_query( "INSERT INTO buildings( buildingType, baseId ) VALUES( $_POST[building], $_GET[base] );" );
		mysql_query( "UPDATE bases SET lastTimeBuilding=$time WHERE baseId=$_GET[base];" );
		mysql_close($mysql_link);
		header( "Location: .?page=bases&location=$locationId" );
		exit;
	}

	case "moveairplanes": {
		$result_tobase = mysql_query( "SELECT * FROM bases WHERE userId=$_SESSION[userid] and locationId=\"$_POST[to]\";" );
		if( !mysql_numrows($result_tobase) ) {
			mysql_close($mysql_link);
			header("HTTP/1.0 404 Not Found");
			exit;
		}
		$result_frombase = mysql_query( "SELECT * FROM bases WHERE userId=$_SESSION[userid] and locationId=\"$_GET[from]\";" );
		if( !mysql_numrows($result_frombase) ) {
			mysql_close($mysql_link);
			header("HTTP/1.0 404 Not Found");
			exit;
		}
		$result_airplanesfrom = mysql_query( "SELECT * FROM airplanes WHERE userId=$_SESSION[userid] and locationId=\"$_GET[from]\"; ");
		if( !mysql_numrows($result_airplanesfrom) ) {
			mysql_close($mysql_link);
			header("HTTP/1.0 404 Not Found");
			exit;
		}
		if( time() - mysql_result( $result_airplanesfrom, 0, "lastTimeGathered" ) <= $vars[time_gatherairplanes] ) {
			echo( "niet goet" ); exit;
			mysql_close($mysql_link);
			header("HTTP/1.0 404 Not Found");
			exit;
		}
		$airplanesFrom = 0 + mysql_result( $result_airplanesfrom, 0, "airplanes" );
		$airplanesFrom -= $_POST[airplanes];
		if( $airplanesFrom < 0 ) {
			mysql_close($mysql_link);
			header("HTTP/1.0 404 Not Found");
			exit;
		}
		else if( $airplanesFrom == 0 ) {
			mysql_query( "DELETE FROM airplanes WHERE locationId=\"$_GET[from]\" and userId=$_SESSION[userid];" );
		}
		else {
			mysql_query( "UPDATE airplanes SET airplanes=$airplanesFrom WHERE userId=$_SESSION[userid] and locationId=\"$_GET[from]\";" );
		}
		$result_airplanesto = mysql_query( "SELECT * FROM airplanes WHERE userId=$_SESSION[userid] and locationId=\"$_POST[to]\";" );
		if( mysql_numrows($result_airplanesto) ) {
			$airplanesTo = 0 + mysql_result( $result_airplanesto, 0, "airplanes" );
			$airplanesTo += $_POST[airplanes];
			mysql_query( "UPDATE airplanes SET airplanes=$airplanesTo WHERE userId=$_SESSION[userid] and locationId=\"$_POST[to]\";" );
		}
		else {
			$result = mysql_query( "SELECT team FROM accounts WHERE userId=$_SESSION[userid];" );
			$team = mysql_result( $result, 0, "team" );
			mysql_query( "INSERT INTO airplanes( userId, locationId, team, airplanes ) VALUES( $_SESSION[userid], \"$_POST[to]\", $team, $_POST[airplanes] );" );
		}
		$time = time();
		mysql_query( "UPDATE airplanes SET lastTimeGathered=$time WHERE userId=$_SESSION[userid] and locationId=\"$_POST[to]\";" );
		mysql_close($mysql_link);
		header( "Location: .?page=army&location=" . $_POST[to] );
		exit;
	}

	case "movetanks": {
		$position = LocationId2XY($_GET[location]);
		$xDirection = array(
			"northwest" =>	-1,	"north" => 0,
			"northeast" => 1,	"west" => -1,
			"east" => 1,		"southwest" =>	-1,
			"south" => 0,		"southeast" => 1 );
		$yDirection = array(
			"northwest" =>	-1,	"north" => -1,
			"northeast" => -1,	"west" => 0,
			"east" => 0,		"southwest" =>	1,
			"south" => 1,		"southeast" => 1 );
		$position[x] += $xDirection[$_POST[direction]];
		$position[y] += $yDirection[$_POST[direction]];
		if(	$position[x] < 0 ||	$position[x] > 11 ||
			$position[y] < 0 ||	$position[y] > 11 ) {
			header("HTTP/1.0 404 Not Found");
			exit;
		}
		$letter = array(
			0 => "A",	1 => "B",	2 => "C",	3 => "D",
			4 => "E",	5 => "F",	6 => "G",	7 => "H",
			8 => "I",	9 => "J",	10 => "K",	11 => "L" );
		$number = array(
			0 => "01",	1 => "02",	2 => "03",	3 => "04",
			4 => "05",	5 => "06",	6 => "07",	7 => "08",
			8 => "09",	9 => "10",	10 => "11",	11 => "12" );
		$newLocation = $letter[$position[x]] . $number[$position[y]];
		$result_tanksfrom = mysql_query( "SELECT * FROM tanks WHERE userId=$_SESSION[userid] and locationId=\"$_GET[location]\";" );
		if( !mysql_numrows($result_tanksfrom) ) {
			mysql_close($mysql_link);
			header("HTTP/1.0 404 Not Found");
			exit;
		}
		if( time() - mysql_result( $result_tanksfrom, 0, "lastTimeGathered" ) <= $vars[time_gathertanks] ) {
			mysql_close($mysql_link);
			header("HTTP/1.0 404 Not Found");
			exit;
		}
		$tanksFrom = 0 + mysql_result( $result_tanksfrom, 0, "tanks" );
		$tanksFrom -= $_POST[tanks];
		if( $tanksFrom < 0 ) {
			mysql_close($mysql_link);
			header("HTTP/1.0 404 Not Found");
			exit;
		}
		else if( $tanksFrom == 0 ) {
			mysql_query( "DELETE FROM tanks WHERE locationId=\"$_GET[location]\" and userId=$_SESSION[userid];" );
		}
		else {
			mysql_query( "UPDATE tanks SET tanks=$tanksFrom WHERE userId=$_SESSION[userid] and locationId=\"$_GET[location]\";" );
		}
		$result_tanksto = mysql_query( "SELECT * FROM tanks WHERE userId=$_SESSION[userid] and locationId=\"$newLocation\";" );
		if( mysql_numrows($result_tanksto) ) {
			$tanksTo = 0 + mysql_result( $result_tanksto, 0, "tanks" );
			$tanksTo += $_POST[tanks];
			mysql_query( "UPDATE tanks SET tanks=$tanksTo WHERE userId=$_SESSION[userid] and locationId=\"$newLocation\";" );
		}
		else {
			$result = mysql_query( "SELECT team FROM accounts WHERE userId=$_SESSION[userid];" );
			$team = mysql_result( $result, 0, "team" );
			mysql_query( "INSERT INTO tanks( userId, locationId, team, tanks ) VALUES( $_SESSION[userid], \"$newLocation\", $team, $_POST[tanks] );" );
		}
		$time = time();
		mysql_query( "UPDATE tanks SET lastTimeGathered=$time WHERE userId=$_SESSION[userid] and locationId=\"$newLocation\";" );
		mysql_close($mysql_link);
		header( "Location: .?page=army" );
		exit;
	}

	case "setfirstbase": {
		$result = mysql_query( "SELECT * FROM bases WHERE userId=$_SESSION[userid];" );
		if( mysql_numrows($result) > 0 ) {
			mysql_close($mysql_link);
			header("HTTP/1.0 404 Not Found");
			exit;
		}
		$result = mysql_query( "SELECT team FROM accounts WHERE userId=$_SESSION[userid];" );
		$team = mysql_result( $result, 0, "team" );
		$result_locations = mysql_query( "SELECT * FROM locations WHERE locationId=\"$_GET[location]\";" );
		$part3Ends = mysql_result( $result_locations, 0, "part3Ends" );
		$part3Ends++;
		mysql_query( "INSERT INTO bases( userId, team, locationId ) VALUES( $_SESSION[userid], $team, \"$_GET[location]\" );" );
		mysql_query( "UPDATE accounts SET readytoplay=1 WHERE userId=$_SESSION[userid];" );
		mysql_query( "UPDATE locations SET part3Ends=$part3Ends WHERE locationId=\"$_GET[location]\";" );
		mysql_close($mysql_link);
		header( "Location: ." );
		exit;
	}

	case "takeresources": {
		$result_mybase = mysql_query( "SELECT * FROM bases WHERE baseId=$_GET[baseid];" );
		$locationId = mysql_result( $result_mybase, 0, "locationId" );
		$result_account = mysql_query( "SELECT * FROM accounts WHERE userid=$_SESSION[userid];" );
		$result_locations = mysql_query( "SELECT * FROM locations WHERE locationId=\"$locationId\";" );
		if( mysql_result( $result_account, 0, "team" ) != mysql_result( $result_mybase, 0, "team" ) ) {
			mysql_close($mysql_link);
			header("HTTP/1.0 404 Not Found");
			exit;
		}
		if( time() - mysql_result( $result_mybase, 0, "lastTimeTakingResources" ) < 60 ) {
			echo( "too short" ); exit;
			mysql_close($mysql_link);
			header("HTTP/1.0 404 Not Found");
			exit;
		}
		$lastTakenShare = mysql_result( $result_locations, 0, "lastTakenShare" );
		$nextShare = $lastTakenShare + 1;
		$part1Ends = mysql_result( $result_locations, 0, "part1Ends" );
		$part2Ends = mysql_result( $result_locations, 0, "part2Ends" );
		$part3Ends = mysql_result( $result_locations, 0, "part3Ends" );
		if( $lastTakenShare >= $part3Ends ) {
			mysql_close($mysql_link);
			header("Location: .?page=21&location=$locationId");
			exit;
		}
		if( mysql_result( $result_locations, 0, "dominatingTeam" ) == mysql_result( $result_account, 0, "team" ) ) {
			$currentLoad = mysql_result( $result_locations, 0, "resources" );
		}
		else {
			if( $lastTakenShare < $part3Ends ) {
				$currentLoad = mysql_result( $result_locations, 0, "share3" );
			}
			if( $lastTakenShare < $part2Ends ) {
				$currentLoad = mysql_result( $result_locations, 0, "share2" );
			}
			if( $lastTakenShare < $part1Ends ) {
				$currentLoad = mysql_result( $result_locations, 0, "share1" );
			}
		}
		$clientresources = mysql_result( $result_account, 0, "resources" );
		$clientresources += $currentLoad;
		mysql_query( "UPDATE accounts SET resources=$clientresources WHERE userId=$_SESSION[userid];" );
		$time = time();
		mysql_query( "UPDATE bases SET lastTimeTakingResources=$time WHERE baseId=$_GET[baseid];" );
		mysql_query( "UPDATE locations SET lastTakenShare=$nextShare WHERE locationId=\"$locationId\";" );
		mysql_close($mysql_link);
		header( "Location: .?page=bases&location=$locationId" );
		exit;
	}
		
	default:
		if( $_COOKIE[userid] && !$_SESSION[userid] ) {
			$_SESSION[userid] = $_COOKIE[userid];
			header( "location: ." );
			break;
		}

		if( $_SESSION[userid] ) {
			mysql_query( "UPDATE accounts SET lastShowUp=" . time() . " WHERE userid=" . $_SESSION[userid] . ";" );
			$resultacc = mysql_query( "SELECT * FROM accounts WHERE userid=$_SESSION[userid];" );
			if( mysql_result($resultacc,0,"activationkey") ) {
				$css_files = array(
					"css/global.css"
					); 
				include( "htmlinc/header.php" );
				include( "htmlinc/activate.php" );
				include( "htmlinc/footer.php" );
				break;
			}
			$result = mysql_query( "SELECT * FROM bases WHERE userId=$_SESSION[userid];" );
			if( mysql_numrows($result) == 0 ) {
				$css_files = array(
					"css/global.css",
					"css/maptable.css"
					); 
				include( "htmlinc/header.php" );
				include( "htmlinc/setfirstbase.php" );
				include( "htmlinc/footer.php" );
				break;
			}
			else {
			
				if( $_GET[location] && !$_GET[page] ) {
					$javascript_files = array(
						"javascript/jquery-1.7.min.js"
						);
					$css_files = array(
						"css/global.css",
						"css/ingame.css"
						); 
					include( "htmlinc/header.php" );
					include( "htmlinc/menu.php" );
					include( "htmlinc/location.php" );
					include( "htmlinc/footer.php" );
					break;
				}
				else {

					switch( $_GET[page] ) {
							
						case "bases":
							if( $_GET[location] ) {
								$javascript_files = array(
									"javascript/jquery-1.7.min.js"
									);
								$css_files = array(
									"css/global.css",
									"css/ingame.css",
									"css/maptable.css"
									); 
								include( "htmlinc/header.php" );
								include( "htmlinc/menu.php" );
								include( "htmlinc/bases_location.php" );
								include( "htmlinc/footer.php" );
							}
							else {
								$javascript_files = array(
									"javascript/jquery-1.7.min.js"
									);
								$css_files = array(
									"css/global.css",
									"css/ingame.css",
									"css/maptable.css"
									); 
								include( "htmlinc/header.php" );
								include( "htmlinc/menu.php" );
								include( "htmlinc/bases.php" );
								include( "htmlinc/footer.php" );
							}
							break;
							
						case "army":
							if( $_GET[location] ) {
								$javascript_files = array( 
									"javascript/jquery-1.7.min.js",
									"javascript/movetanks.js"
									);
								$css_files = array(
									"css/global.css",
									"css/ingame.css",
									"css/movementtable.css"
									); 
								include( "htmlinc/header.php" );
								include( "htmlinc/menu.php" );
								include( "htmlinc/army_location.php" );
								include( "htmlinc/footer.php" );
							}
							else {
								$javascript_files = array(
									"javascript/jquery-1.7.min.js"
									);
								$css_files = array(
									"css/global.css",
									"css/ingame.css",
									"css/maptable.css"
									); 
								include( "htmlinc/header.php" );
								include( "htmlinc/menu.php" );
								include( "htmlinc/army.php" );
								include( "htmlinc/footer.php" );
							}
							break;
							
						case "airstrike":
							if( $_GET[location] ) {
								$javascript_files = array(
									"javascript/jquery-1.7.min.js"
									);
								$css_files = array(
									"css/global.css",
									"css/ingame.css",
									"css/maptable.css"
									); 
								include( "htmlinc/header.php" );
								include( "htmlinc/menu.php" );
								include( "htmlinc/airstrike.php" );
								include( "htmlinc/footer.php" );
							}
							else {
								$javascript_files = array(
									"javascript/jquery-1.7.min.js"
									);
								$css_files = array(
									"css/global.css",
									"css/ingame.css",
									"css/maptable.css"
									); 
								include( "htmlinc/header.php" );
								include( "htmlinc/menu.php" );
								include( "htmlinc/airstrike_step2.php" );
								include( "htmlinc/footer.php" );
							}
							break;
							
						case "airstrike_succesful":
							$css_files = array(
								"css/global.css",
								"css/ingame.css"
								); 
							include( "htmlinc/header.php" );
							include( "htmlinc/menu.php" );
							include( "htmlinc/airstrike_succesful.php" );
							include( "htmlinc/footer.php" );
							break;
	
						case "move_airplanes":
							$css_files = array(
								"css/global.css",
								"css/ingame.css",
								"css/maptable.css",
								); 
							include( "htmlinc/header.php" );
							include( "htmlinc/menu.php" );
							include( "htmlinc/move_airplanes.php" );
							include( "htmlinc/footer.php" );
							break;						
				
						case "overview":
							$javascript_files = array(
								"javascript/jquery-1.7.min.js"
								);
							$css_files = array(
								"css/global.css",
								"css/ingame.css",
								"css/maptable.css"
								); 
							include( "htmlinc/header.php" );
							include( "htmlinc/menu.php" );
							include( "htmlinc/overview.php" );
							include( "htmlinc/footer.php" );
							break;
				
						default:
							$javascript_files = array(
								"javascript/jquery-1.7.min.js"
								);
							$css_files = array(
								"css/global.css",
								"css/ingame.css",
								"css/maptable.css"
								); 
							include( "htmlinc/header.php" );
							include( "htmlinc/menu.php" );
							include( "htmlinc/default.php" );
							include( "htmlinc/footer.php" );
							break;

					}
				}
			}
		}
		else {
			$javascript_files = array(
				"javascript/jquery-1.7.min.js", 
				"javascript/welcome.js"
				);
			$css_files = array(
				"css/global.css",
				"css/maptable.css"
				); 
			include( "htmlinc/header.php" );
			include( "htmlinc/welcome.php" );
			include( "htmlinc/footer.php" );
		}
		break;

}

include( "close.php" );

?>