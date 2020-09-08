<?php

$paragraph = str_replace ( "%from%", $_GET[from], $lang[airstrike_p1] );
$paragraph = str_replace ( "%to%", $_GET[to], $paragraph );

?>
<div id="Main">

<h1>Select target player at <?php echo($_GET[to]);?></h1>

<p>These are the player that have been online most recently. Choose one.</p>

<table>
	<tr>
<?php
if( $team != 1 ) {
	echo( "		<th><img src=\"img/_square_red.gif\"> $lang[_red]</th>\n" );
}
if( $team != 2 ) {
	echo( "		<th><img src=\"img/_square_black.gif\"> $lang[_black]</th>\n" );
}
if( $team != 3 ) {
	echo( "		<th><img src=\"img/_square_orange.gif\"> $lang[_orange]</th>\n" );
}
if( $team != 4 ) {
	echo( "		<th><img src=\"img/_square_green.gif\"> $lang[_green]</th>\n" );
}
?>
	</tr>
	<tr>
<?php
for( $t = 1; $t <= 4; $t++ ) {
	if( $team != $t ) {
		$result = mysql_query( "SELECT * FROM accounts LEFT JOIN bases ON accounts.userId=bases.userId WHERE bases.team=$t and locationId=\"$_GET[to]\" ORDER BY accounts.lastShowup DESC LIMIT 0,10;" );
		$num = mysql_numrows($result);
		echo( "		<td>\n" );
		if( !$num ) {
			echo( "&nbsp;" );
		}
		for( $n = 0; $n < $num; $n++ ) {
			$username = mysql_result( $result, $n, "username" );
			$baseId = mysql_result( $result, $n, "baseId" );
			echo( "			<a href=\"?request=airstrike&baseid=$baseId&from=$_GET[from]\">$username</a><br>\n" );
		}
		echo( "		</td>\n" );	
	}
}
?>
	</tr>
</table>

</div>
