<?php

$result_myairplanes = mysql_query( "SELECT * FROM airplanes WHERE userId=$_SESSION[userid] and locationId=\"$_GET[location]\";" );
if( !mysql_numrows($result_myairplanes) ) {
	$airplanes = 0;
}
else {
	$airplanes = 0 + mysql_result( $result_myairplanes, 0, "airplanes" );
	$step = round( $airplanes / 6 );
	if( !$step ) {
		$step = 1;
	}
}

?>
<script type="text/javascript">

var maxAirplanes = <?php echo($airplanes);?>;
var step = <?php echo($step);?>;

function IncreaseAirplanes() {
	var n = 1 * MovementForm.airplanes.value;
	MovementForm.airplanes.value = n + step;
	CheckInput();
}

function DecreaseAirplanes() {
	MovementForm.airplanes.value -= step;
	CheckInput();
}

function CheckInput() {
	if( MovementForm.airplanes.value > maxAirplanes ) {
		MovementForm.airplanes.value = maxAirplanes;
	}
	if( MovementForm.airplanes.value < 1 ) {
		MovementForm.airplanes.value = 1;
	}
	if( MovementForm.airplanes.value == "NaN" ) {
		MovementForm.airplanes.value = 1;
	}
}

function SubmitForm(location) {
	if( location == "<?php echo($_GET[location]);?>" ) {
		alert( "Select a base where you want to move your airplanes to" );
		return;
	}
	MovementForm.to.value = location;
	MovementForm.submit();
}

</script>

<div id="Main">
<h1>Move airplanes</h1>

<form id="MovementForm" action="?request=moveairplanes&from=<?php echo($_GET[location]);?>" method="POST">
<input type="HIDDEN" name="to">
<div class="center">
<?php DrawTable( "MYBASES", "MYBASES", "javascript: SubmitForm('%location%');", false, "<span style=\"display: inline;\">Move <input type=\"TEXT\" name=\"airplanes\" value=\"$airplanes\" style=\"width: 60px;\"> <a href=\"javascript:IncreaseAirplanes();\"><img src=\"img/_arrow_increase.gif\" style=\"border: 0;\"></a> <a href=\"javascript:DecreaseAirplanes();\"><img src=\"img/_arrow_decrease.gif\" style=\"border: 0;\"></a> airplanes from $_GET[location] to:</span>" );?>
</div>
</form>
</div>
