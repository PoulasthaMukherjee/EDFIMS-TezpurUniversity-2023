<?php
	session_start();
	include("config.php");
	if(!isset($_SESSION['admin']))
	{
		header("location:index.php");
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Admin Home</title>
<link href="scripts\styleASL.css" rel="stylesheet" type="text/css" />
</head>

<body>
<span class="head" style="float:left">Welcome To Admin Panel</span>
<span style="float:right;"><a href="logout.php">Logout</a></span><br />

<hr style="clear:both;box-shadow:0px 0px 2px #000;" color="#FF6600" size="2" width="100%"/><br />
<div align="center">
<table cellpadding="3" cellspacing="3" class="formTable">
<tr>
	<td>
		<span class="Subhead">Admin Commands</span><hr size="1" style="color:#00F;" /><br />
		<a href="notices.php">File Uploads</a><br />
		<a></a><br />
		<a href="manageFaculty.php">Manage Faculty Account</a><br />
		<a></a><br />
		<a href="ChangePassword.php">Change Password</a><br />
		<a></a><br />
	</td>
</tr>
</table>
</div>

</body>
</html>