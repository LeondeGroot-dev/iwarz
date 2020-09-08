<!DOCTYPE HTML>
<html>
<head>
	<title>Official iWarz</title>
	<meta name="keywords" content="iwarz, game, games, script">
	<meta name="discription" content="iWarz by Leon de Groot">
	<meta name="author" content="Leon de Groot">
	<meta charset="utf-8" />
<?php
if( sizeof($css_files) > 0 ) {
	for( $n = 0; $n < sizeof($css_files); $n++ )
		echo( "	<link rel=\"stylesheet\" href=\"$css_files[$n]\" type=\"text/css\">\n" );
}
if( sizeof($javascript_files.length) ) {
	for( $n = 0; $n < sizeof($javascript_files); $n++ )
		echo( "	<script src=\"$javascript_files[$n]\" type=\"text/javascript\"></script>\n" );
} ?>
</head>
<body>
