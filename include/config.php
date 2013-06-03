<?php
	define('DB_SERVER', 'localhost');
	define('DB_USERNAME', 'root');
	define('DB_PASSWORD', 'usbw');
	define('DB_DATABASE', 'winkelwagen');
	class DB_Class{
		function open(){
			$connection = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE) or die('Oops conncetion error -> ' . mysqli_error());
			return $connection;
		}
	}
?>