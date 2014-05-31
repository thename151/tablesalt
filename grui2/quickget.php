<?php

function quickGet( $var, $var2 )
{
	if (isset($_GET[$var]))
	{
		include_once '../funcss/dbfuncs.php';
		$var3 = $_GET[$var];
		$var3 = escapeStr( $var3 );
	}
	else{$var3 = $var2;}

//	echo "$var $var3<br>";
	return $var3;
}

function quickPost( $var, $var2 )
{
	if (isset($_POST[$var]))
	{
		include_once '../funcss/dbfuncs.php';
		$var3 = $_POST[$var];
		$var3 = escapeStr( $var3 );
	}
	else{$var3 = $var2;}

//	echo "$var $var3<br>";
	return $var3;
}
