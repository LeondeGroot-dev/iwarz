<div id="Main">
<h1>Welcome to iWarz</h1>
<?php

if( $_SESSION[errors] ) {
	echo( $_SESSION[errorlist] );
	$_SESSION[errors] = false;
}

?>
<p>Try everyting out! It's fun</p>
</div>
