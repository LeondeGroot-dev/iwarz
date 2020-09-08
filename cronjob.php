<?php

$ip = @$REMOTE_ADDR; 
if( $ip != NULL ) {
	exit;
}

include("config.php");
include("functions.php");

include("init.php");

UpdateTables();
UpdateResources();

include("close.php");
?>