<?php

	$server = 'localhost';
	$user = 'mayur';
	$password = 'manisht3';
	$db = 'shop_demo';
	
	$conn = mysqli_connect($server,$user,$password,$db);
	
	if(!$conn)
	{
		die("Connection Failed :".mysqli_connect_error());
		
	}
	else
	{
		//echo "it Succes ";
	}

?>