<?php

$result_myteam = mysql_query( "SELECT team FROM accounts WHERE userId=$_SESSION[userid];" );
$myteam = mysql_result( $result_myteam, 0, "team" );
$giffiles = array(
	1 => "_square_red.gif",
	2 => "_square_black.gif",
	3 => "_square_orange.gif",
	4 => "_square_green.gif" );
$teams = array(
	1 => $ln[red],
	2 => $ln[black],
	3 => $ln[orange],
	4 => $ln[green] );

?>
<div id="Main">

<h1>Set your first base</h1>

<p>You are a new player or your bases are destroyed. Select the location for your first (or new) base. You can only build this base on locations where no other bases have been built or where your color has the most bases.</p>

<?php DrawTable( "DOMINATION", "OWNTEAMANDNOBODIES", "?request=setfirstbase&location=%location%", false, "Select your first base" ); ?>

</div>
