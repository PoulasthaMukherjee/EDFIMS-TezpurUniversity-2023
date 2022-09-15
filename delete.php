<?php
	include("config.php");

	$email=$_GET['del'];
	$p=$_GET['p'];

	if($p==2)
	{
		$sql=mysqli_query($poulastha,"DELETE FROM faculty WHERE email='$email'");
		header("location:manageFaculty.php");
	}
?>