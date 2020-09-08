<div id="Main">
<h1>Army</h1>

<?php

$result = mysql_query( "SELECT * FROM tanks WHERE userId=$_SESSION[userid];" );
if( !mysql_numrows($result) ) {
	echo( "<p>You have no forces yet. Go to your base, build a factory or an airfield and buy tanks or airplanes.</p>\n\n" );
}
else {
?>
<p>Here you see the locations where you have tanks or airplanes</p>
<div class="center">
<?php DrawTable( "MYARMY", "MYARMY", "?page=army&location=%location%", false, "<img src=\"img/_tank.gif\">" ); ?>
</div>

<?php } ?>
</div>
