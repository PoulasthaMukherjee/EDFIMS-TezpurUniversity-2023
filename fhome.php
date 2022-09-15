<?php
	session_start();
	include("config.php");
	if(!isset($_SESSION['email']))
	{
		header("location:index.php");
	}
	$email=$_SESSION['email'];

	$a=mysqli_query($poulastha,"SELECT name FROM faculty WHERE email='$email'");
	$b=mysqli_fetch_array($a);
	$name=$b['name'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Faculty Home</title>
<link rel="stylesheet" type="text/css" href="scripts\styleASL.css" />
</head>

<body>
<span class="head" style="float:left;">Welcome <span style="color:#F30;font-size:28px;"><?php echo $name;?></span></span>

<span style="float:right;"><a href="logout.php">Logout</a></span><br />

<hr style="clear:both;box-shadow:0px 0px 2px #000;" color="#FF6600" size="2" width="100%"/><br />
<div align="center">
<table cellpadding="3" cellspacing="3" class="formTable">
<tr><td>
<span class="Subhead">Faculty Commands</span><hr size="1" style="color:#00F;" /><br />
<a href="ViewNoticesFaculty.php">View Uploads</a><br />
<a></a><br />
<a href="ChangePasswordFaculty.php">Change Password</a><br />
</td></tr></table>
</div>
</body>
</html>