<?php

$mysql_link = mysql_connect( $mysql_host, $mysql_username, $mysql_password ) or die ("Error! Can't connect to MySQL" );
mysql_select_db( $mysql_database ) or die ( "Error! Can't select database" );

session_start();

?>