<?php

if( !$from ) {
	exit;
}

$result_b = mysql_query( "SELECT * FROM bases WHERE baseid=$baseid;" );
$targetuserid = mysql_result( $result_b, 0, "userid" );
$condition = mysql_result( $result_b, 0, "condition" );
$result_u = mysql_query( "SELECT username FROM accounts WHERE userid=$targetuserid;" );
$username = mysql_result( $result_u, 0, "username" );
?>
<div id="Main">
<h1>Airstrike succesful!</h1>
<p>Your airplanes from <?php echo($from); ?> damaged the base of <?php echo($username); ?>. The condition of the base is now <?php echo($condition); ?></p>

</div>
