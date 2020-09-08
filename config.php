<?php

$mysql_host = "";
$mysql_username = "";
$mysql_password = "";
$mysql_database = "";

// Player start
$vars[playerstart_resources] = 10000;

// Costs
$vars[cost_factory] = 2000;
$vars[cost_airfield] = 3000;
$vars[cost_tank] = 400;
$vars[cost_airplane] = 800;

// Delays: non-fixed times (seconds)
$vars[time_buildtank] = 60;
$vars[time_buildairplane] = 300;
$vars[time_gathertanks] = 60;
$vars[time_gatherairplanes] = 30;
$vars[time_airstrike] = 1800;
$vars[time_tableupdate] = 10;
$vars[time_showupcheck] = 10;

// Delays: fixed times
// When one of the first "_equal" numbers is changed AND digits has passed
$vars[time_resourcesupdate_equals] = 15;
$vars[time_resourcesupdate_digits] = "0:00";

?>