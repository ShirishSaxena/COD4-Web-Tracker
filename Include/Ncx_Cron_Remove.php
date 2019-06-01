<?php
ini_set('max_execution_time', 300); 
ini_set('display_errors','On');
date_default_timezone_set("Asia/Kolkata");

error_reporting(E_ALL);
// Check connection

function Remove()
{
	require 'Setup.php';
	$con = mysqli_connect($Database_Address, $Database_User, $Database_Password, $Database_Name);
	if (mysqli_connect_errno()) {
		echo "Failed to connect to MySQL: " . mysqli_connect_error();
	}
	echo "<br>Daily NcxTracker List Removal Wizard";
	$query="Truncate table $Table_Name";
	mysqli_query($con, $query);
	$query2="ALTER TABLE $Table_Name AUTO_INCREMENT = 1";
	mysqli_query($con, $query2);
	echo "<br>Table Trauncation Completed";
	echo "<br>Alter table Completed";
	mysqli_close($con);	
}
Remove();
?>
