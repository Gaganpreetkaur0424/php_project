<?php 
$dbc = @mysqli_connect("localhost","root","","project")OR die('Could not connect to MySQL: ' . mysqli_connect_error() );
// Set the encoding...
mysqli_set_charset($dbc, 'utf8');
?>