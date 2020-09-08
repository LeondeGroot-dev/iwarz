<?php

$newmessages = 0;
$messages = 0;

$result_account = mysql_query( "SELECT * FROM accounts WHERE userId=$_SESSION[userid];" );
$username = mysql_result($result_account, 0, "username" );
$team = mysql_result($result_account, 0, "team" );
$resources = mysql_result( $result_account, 0, "resources" );
$result_bases = mysql_query( "SELECT * FROM bases WHERE userid=$_SESSION[userid];" );
$numbases = mysql_numrows($result_bases);
$giffiles = array(
	1 => "img/_square_red.gif",
	2 => "img/_square_black.gif",
	3 => "img/_square_orange.gif",
	4 => "img/_square_green.gif" );
?><div class="leftColumn">
	<ul>
		<li><img src="<?php echo($giffiles[$team]);?>"> <span class="Big" style="margin-bottom: 10px;"><?php echo($username);?></span>
	</ul>
	<ul>
		<li>Resources: <?php echo($resources); ?></li>
		<li>Bases: <?php echo($numbases); ?></li>
		<li>Achievements: 0</li>
	</ul>
	<hr>
	<ul>
		<li><a href="?page=overview">Overview</a></li>
		<li><a href="?page=bases">Bases</a></li>
		<li><a href="?page=army">Army</a></li>
	</ul>
	<hr>
	<ul>
		<li><a href="?page=messages">Messages (<?php echo("$newmessages/$messages");?>)</a></li>
		<li><a href="?page=notifications">Notifications (0)</a></li>
	</ul>
	<hr>
	<ul>
		<li><a href=".">FAQ</a></li>
		<li><a href="http://forum.leondegroot.nl/viewtopic.php?f=6&t=2">Forum</a></li>
	</ul>
	<hr>
	<ul>
		<li><a href="?request=logout">Log out</a></li>
	</ul>
</div>