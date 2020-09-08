<?php

$result_mybases = mysql_query ( "SELECT * FROM bases WHERE userId=$_SESSION[userid] and locationId=\"$_GET[location]\";" );
if( !mysql_numrows($result_mybases) ) {
	header("HTTP/1.0 404 Not Found");
	exit; 
}

$result_locations = mysql_query( "SELECT * FROM locations WHERE locationId=\"$_GET[location]\";" );
$result_account = mysql_query( "SELECT * FROM accounts WHERE userId=$_SESSION[userid];" );
$myResources = mysql_result( $result_account, 0, "resources" );

$resources = mysql_result( $result_locations, 0, "resources" );
$lastTakenShare = mysql_result( $result_locations, 0, "lastTakenShare" );
$part1Ends = mysql_result( $result_locations, 0, "part1Ends" );
$part2Ends = mysql_result( $result_locations, 0, "part2Ends" );
$part3Ends = mysql_result( $result_locations, 0, "part3Ends" );
$currentLoad = 0;

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
if( $lastTakenShare >= $part3Ends ) {
	$currentLoad = 0;
}
if( !$currentLoad ) {
	$currentLoad = 0;
}

$baseId = mysql_result( $result_mybases, 0, "baseId" );
$baseCondition = 0 + mysql_result( $result_mybases, 0, "condition" );

if( $lastTakenShare >= $part3Ends ) {
	$takeLink = "No resources here";
}
elseif( !$currentLoad ) {
	$takeLink = "No resources here";
}
elseif( time() - mysql_result( $result_mybases, 0, "lastTimeTakingResources" ) <= 60 ) {
	$takeLink = "Loading resources...";
}
else {
	$takeLink = "<a href=\"?request=takeresources&baseid=$baseId\">Take resources</a>";
}

?>
<div id="Main">
<h1>Base: <?php echo($_GET[location]);?></h1>

<h2>Base</h2>

<p>Condition: <?php echo($baseCondition);?>%</p>

<h2>Resources</h2>

<img src="img/_square_res5.gif"> <?php echo($takeLink);?> (<?php echo($currentLoad); ?>)

<h2>Buildings </h2>

<h3>Construct new building</h3>

<?php
if( time() - mysql_result( $result_mybases, 0, "lastTimeBuilding" ) >= 60 ) {
	$anythingtobuild = false;
	echo( "<form action=\"?request=build&base=$baseId\" method=\"POST\">\n" );
	echo( "	<select name=\"building\">\n" );
	if( $vars[cost_factory] <= $myResources ) {
		$anythingtobuild = true;
		echo( "		<option value=\"1\">Factory, costs: $vars[cost_factory])</option>\n" );
	}
	if( $vars[cost_airfield] <= $myResources ) {
		$anythingtobuild = true;
		echo( "		<option value=\"2\">Airfield, costs: $vars[cost_airfield])</option>\n" );
	}
	if( !$anythingtobuild ) {
		echo( "		<option> </option>\n" );
	}
	echo( "	</select>\n" );
	if( $anythingtobuild ) {
		echo( "	<input type=\"SUBMIT\" value=\"Build\">\n" );
	}
	else {
		echo( "<input class=\"gray\" type=\"BUTTON\" value=\"Unable to build\">\n" );
	}
	echo( "</form>\n" );
}
else {
	echo( "<input type=\"BUTTON\" class=\"gray\" value=\"Preparing to construct...\" disabled>\n" );
}
?>

<?php 
$result_mybuildings = mysql_query( "SELECT * FROM buildings WHERE baseId=$baseId ORDER BY buildingType ASC;" ); 
$num_mybuildings = mysql_numrows($result_mybuildings);
if( $num_mybuildings ) {
	echo( "<h3>Buildings</h3>\n\n" );
	echo( "<table>\n" );
	echo( "	<tr>\n" );
	echo( "		<th>ID</th>\n" );
	echo( "		<th>Type</th>\n" );
	echo( "		<th>Option 1</th>\n" );
	echo( "		<th>Option 2</th>\n" );
	echo( "	</tr>\n" );
	for( $n = 0; $n < $num_mybuildings; $n++ ) {
		echo( "	<tr>\n" );
		$buildingId = mysql_result( $result_mybuildings, $n, "buildingId" );
		echo( "		<td>$buildingId</td>\n" );
		switch( mysql_result( $result_mybuildings, $n, "buildingType" ) ) {
			case "1": {
				echo( "		<td>Factory</td>\n" );
				$lastTimeUsed = mysql_result( $result_mybuildings, $n, "lastTimeUsed" );
				if( $myResources >= $vars[cost_tank] ) {
					if( time() - $lastTimeUsed >= $vars[time_buildtank] ) {
						echo( "		<td><a href=\"?request=b_option1&building=$buildingId\">Buy: tank ($vars[cost_tank])</a></td>\n" );
					}
					else {
						echo( "		<td><span class=\"gray\">Preparing...</span></td>\n" );
					}
					echo( "		<td> - </td>\n" );
				}
				else {
					echo( "		<td><span class=\"gray\">Not enough resources</span></td>\n" );
					echo( "		<td> - </td>\n" );
				}
				break;
			}
			case "2": {
				echo( "		<td>Airfield</td>\n" );
				$lastTimeUsed = mysql_result( $result_mybuildings, $n, "lastTimeUsed" );
				if( $myResources >= $vars[cost_airplane] ) {
					if( time() - $lastTimeUsed >= $vars[time_buildairplane] ) {
						echo( "		<td><a href=\"?request=b_option1&building=$buildingId\">Buy: airplane ($vars[cost_airplane])</a></td>\n" );
					}
					else {
						echo( "		<td><span class=\"gray\">Preparing...</span></td>\n" );
					}
				echo( "		<td> - </td>\n" );
				}
				else {
					echo( "		<td><span class=\"gray\">Not enough resources</span></td>\n" );				
					echo( "		<td> - </td>\n" );
				}
				break;
			}
		}
		echo( "	</tr>\n" );
	}
	echo( "</table>\n" );
}

$result_mytanks = mysql_query( "SELECT tanks FROM tanks WHERE userId=$_SESSION[userid] and locationId=\"$_GET[location]\";" );
$result_myairplanes = mysql_query( "SELECT airplanes FROM airplanes WHERE userId=$_SESSION[userid] and locationId=\"$_GET[location]\";" );

if( mysql_numrows($result_mytanks) || mysql_numrows($result_myairplanes) ) {
?>

<h2>Army</h2>

<a href="index.php?page=army&location=<?php echo($_GET[location]);?>">Go to your army in this location</a>

<?php } ?>
</div>
