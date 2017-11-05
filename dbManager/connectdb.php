<?php


	$user = 'root';
	$pass = '';
	$host = 'localhost';
	$db = 'testingplataform';

	$mysqli = new mysqli($host,$user,$pass,$db) 
		or die ('Error ' . $mysqli->error);

?>