<?php

$result_locations = mysql_query( "SELECT * FROM locations WHERE locationId=\"$_GET[location]\";" );
$result_account = mysql_query( "SELECT * FROM accounts WHERE userId=$_SESSION[userid];" );

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

$bases = array();
for( $n = 1; $n <= 4; $n++ ) {
	$result = mysql_query( "SELECT * FROM bases WHERE team=$n and locationId=\"$_GET[location]\";" );
	$bases[$n] = mysql_numrows($result);
	$result = mysql_query( "SELECT * FROM tanks WHERE team=$n and locationId=\"$_GET[location]\";" );
	$num = mysql_numrows($result);
	$curtanks = 0;
	for( $n2 = 0; $n2 < $num; $n2++ ) {
		$curtanks += mysql_result( $result, 0, "tanks" );
	}
	$tanks[$n] = $curtanks;
	$result = mysql_query( "SELECT * FROM airplanes WHERE team=$n and locationId=\"$_GET[location]\";" );
	$num = mysql_numrows($result);
	$curairplanes = 0;
	for( $n2 = 0; $n2 < $num; $n2++ ) {
		$curairplanes += mysql_result( $result, 0, "airplanes" );
	}
	$airplanes[$n] = $curairplanes;
}
 
$result__vars = mysql_query( "SELECT * FROM vars;" );
$lastResourcesUpdate = mysql_result( $result__vars, 0, "lastResourcesUpdate" );

$lastminingtime = substr( $lastResourcesUpdate, 11, 4 ) . "0";

?>
<div id="Main">
<h1><?php echo( "Location: $_GET[location]" ); ?></h1>

<?php
$result_mybase = mysql_query( "SELECT * FROM bases WHERE userId=$_SESSION[userid] and locationId=\"$_GET[location]\";" );
if( mysql_numrows($result_mybase) ) {
	echo( "<p><a href=\".?page=bases&location=$_GET[location]\">Base at $_GET[location]</a></p>\n\n" );
}
$result_mytanks = mysql_query( "SELECT * FROM tanks WHERE userId=$_SESSION[userid] and locationId=\"$_GET[location]\";" );
$result_myairplanes = mysql_query( "SELECT * FROM airplanes WHERE userId=$_SESSION[userid] and locationId=\"$_GET[location]\";" );
if( mysql_numrows($result_mytanks) || mysql_numrows($result_myairplanes) ) {
	echo( "<p><a href=\".?page=army&location=$_GET[location]\">Army at $_GET[location]</a></p>\n\n" );
}


?>
<h2>Teams</h2>

<table>
	<tr>
		<th>Color</th>
		<th>Bases</th>
		<th>Tanks</th>
		<th>Airplanes</th>
	<tr>
	<tr>
		<td class="center"><img src="img/_square_red.gif"></td>
		<td><?php echo($bases[1]);?></td>
		<td><?php echo($tanks[1]);?></td>
		<td><?php echo($airplanes[1]);?></td>
	</tr>
	<tr>
		<td class="center"><img src="img/_square_black.gif"></td>
		<td><?php echo($bases[2]);?></td>
		<td><?php echo($tanks[2]);?></td>
		<td><?php echo($airplanes[2]);?></td>
	</tr>
	<tr>
		<td class="center"><img src="img/_square_orange.gif"></td>
		<td><?php echo($bases[3]);?></td>
		<td><?php echo($tanks[3]);?></td>
		<td><?php echo($airplanes[3]);?></td>
	</tr>
	<tr>
		<td class="center"><img src="img/_square_green.gif"></td>
		<td><?php echo($bases[4]);?></td>
		<td><?php echo($tanks[4]);?></td>
		<td><?php echo($airplanes[4]);?></td>
	</tr>
</table>

<h2>Resources</h2>

<table>
	<tr>
		<td>Resources</td>
		<td colspan="2"><?php echo($resources);?></td>
	</tr>
	<tr>
		<td>Current load</td>
		<td><?php echo($currentLoad);?></td>
	</tr>
	<tr>
		<td>Mining frequence</td>
		<td>10 minutes</td>
	</tr>
</table>
</div>