<?php

$result_mytanks = mysql_query( "SELECT * FROM tanks WHERE userId=$_SESSION[userid] and locationId=\"$_GET[location]\";" );
if( !mysql_numrows($result_mytanks) ) {
	$tanks = 0;
}
else {
	$tanks = 0 + mysql_result( $result_mytanks, 0, "tanks" );
	$lastTimeGatheredTanks = mysql_result( $result_mytanks, 0, "lastTimeGathered" );
	$position = LocationId2XY($_GET[location]);
	$step = round( $tanks / 6 );
	if( !$step ) {
		$step = 1;
	}
}

$result_myairplanes = mysql_query( "SELECT * FROM airplanes WHERE locationId=\"$_GET[location]\";" );
if( !mysql_numrows($result_myairplanes) ) {
	$airplanes = 0;
}
else {
	$lastTimeGatheredAirplanes = mysql_result( $result_myairplanes, 0, "lastTimeGathered" );
	$airplanes = 0 + mysql_result( $result_myairplanes, 0, "airplanes" );
}

$result_base = mysql_query( "SELECT * FROM bases WHERE userId=$_SESSION[userid] and locationId=\"$_GET[location]\";" );
$result_base2 = mysql_query( "SELECT * FROM bases WHERE userId=$_SESSION[userid];" );
if( mysql_numrows($result_base) ) {
	$baseId = mysql_result( $result_base, 0, "baseId" );
}

if( $tanks ) {
?>
<script type="text/javascript">

var maxTanks = <?php echo($tanks);?>;
var step = <?php echo($step);?>;

function SubmitForm(direction) {
	MovementForm.direction.value = direction;
	MovementForm.submit();
}

function IncreaseTanks() {
	var n = 1 * MovementForm.tanks.value;
	MovementForm.tanks.value = n + step;
	CheckInput();
}

function DecreaseTanks() {
	MovementForm.tanks.value -= step;
	CheckInput();
}

function CheckInput() {
	if( MovementForm.tanks.value > maxTanks ) {
		MovementForm.tanks.value = maxTanks;
	}
	if( MovementForm.tanks.value < 1 ) {
		MovementForm.tanks.value = 1;
	}
	if( MovementForm.tanks.value == "NaN" ) {
		MovementForm.tanks.value = 1;
	}
}

</script>

<?php } ?>
<div id="Main">
<h1>Army: <?php echo($_GET[location]);?></h1>

<h2>Tanks</h2>

<p>Number of tanks: <?php echo($tanks);?></p>

<?php
if( $tanks ) {
	if( time() - $lastTimeGatheredTanks <= $vars[time_gathertanks] ) {
		echo( "<p>Moving tanks...</p>\n\n" );
	}
	else {
?><h3>Movement</h3>

<p></p>

<form id="MovementForm" action="?request=movetanks&location=<?php echo($_GET[location]);?>" method="POST">
<input type="HIDDEN" name="direction">
<table class="noBorderBackground" id="MovementTable">
	<caption>Number of tanks</caption>
	<tbody>
	<tr>
		<td><?php if( $position[x] > 0 && $position[y] > 0 ) { ?><a href="javascript:SubmitForm('northwest');"><img src="img/_arrow_upleft.gif"></a><?php } else { echo( "&nbsp" ); } ?></td>
		<td><?php if( $position[y] > 0 ) { ?><a href="javascript:SubmitForm('north');"><img src="img/_arrow_up.gif"></a><?php } else { echo( "&nbsp" ); } ?></td>
		<td><?php if( $position[x] < 11 && $position[y] > 0 ) { ?><a href="javascript:SubmitForm('northeast');"><img src="img/_arrow_upright.gif"></a><?php } else { echo( "&nbsp" ); } ?></td>
	</tr>
	<tr>
		<td><?php if( $position[x] > 0 ) { ?><a href="javascript:SubmitForm('west');"><img src="img/_arrow_left.gif"></a><?php } else { echo( "&nbsp" ); } ?></td>
		<td id="MovementTableCenter"><a href="javascript:IncreaseTanks();"><img src="img/_arrow_increase.gif"></a><br><input type="TEXT" name="tanks" value="<?php echo($tanks);?>" onkeyup="CheckInput();"><br><a href="javascript:DecreaseTanks();"><img src="img/_arrow_decrease.gif"></a></td>
		<td><?php if( $position[x] < 11 ) { ?><a href="javascript:SubmitForm('east');"><img src="img/_arrow_right.gif"></a><?php } else { echo( "&nbsp" ); } ?></td>
	</tr>
	<tr>
		<td><?php if( $position[x] > 0 && $position[y] < 11 ) { ?><a href="javascript:SubmitForm('southwest');"><img src="img/_arrow_downleft.gif"></a><?php } else { echo( "&nbsp" ); } ?></td>
		<td><?php if( $position[y] < 11 ) { ?><a href="javascript:SubmitForm('south');"><img src="img/_arrow_down.gif"></a><?php } else { echo( "&nbsp" ); } ?></td>
		<td><?php if( $position[x] < 11 && $position[y] < 11 ) { ?><a href="javascript:SubmitForm('southeast');"><img src="img/_arrow_downright.gif"></a><?php } else { echo( "&nbsp" ); } ?></td>
	</tr>
	</tbody>
</table>
</form>

<?php
	}
}

echo( "<h2>Airplanes</h2>\n\n" );
echo( "<p>Number of airplanes: $airplanes</p>\n\n" );

if( $airplanes ) {
	if( time() - $lastTimeGatheredAirplanes > $vars[time_gatherairplanes] ) { ?>
<ul>
	<?php
		if( mysql_numrows($result_base2) > 1 ) {
	?>
	<li style="margin-bottom: 5px;"><a href=".?page=move_airplanes&location=<?php echo($_GET[location]);?>">Move airplanes</a></li>
    <?php
	}
	if( mysql_result($result_myairplanes, 0, "lastAirstrike") < Time() - $vars[time_airstrike] ) { ?>
	<li style="margin-bottom: 5px;"><a href=".?page=airstrike&location=<?php echo($_GET[location]);?>">Airstrike</a></li>
	<?php } else { ?>
	<li style="margin-bottom: 5px;">Preparing for airstrike</li>
	<?php } ?>
</ul>

<?php
	}
	else {
		echo( "<p>Moving airplanes...</p>\n\n" );
	}
}
if( $baseId ) {
?>
<h2>Base</h2>

<a href=".?page=bases&location=<?php echo($_GET[location]);?>">Go to your base in this location</a>
<?php } ?>
</div>
