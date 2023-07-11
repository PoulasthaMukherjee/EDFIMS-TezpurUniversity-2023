<?php
	session_start();
	include("config.php");
	if(!isset($_SESSION['email']))
	{
		header("location:index.php");
	}
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>View Uploads</title>
<link href="scripts/styleASL.css" rel="stylesheet" type="text/css" />
</head>

<body>
<span class="head" style="float:left">View Uploads</span>
<span style="float:right;"><a href="logout.php">Logout</a></span><br />
<hr style="clear:both;box-shadow:0px 0px 2px #000;" color="#FF6600" size="2" width="100%"/><br />
<div align="center">
<table cellpadding="3" cellspacing="3" class="formTable">
<tr>
	<th>Title</th>
	<th>Description</th>
	<th>Download</th>
	<th>Date</th>
</tr>
<?php
	$email = $_SESSION['email'];
	$facultyIdQuery = mysqli_query($poulastha, "SELECT id FROM faculty WHERE email = '$email'");
	$facultyId = mysqli_fetch_assoc($facultyIdQuery)['id'];
	
	$sql = mysqli_query($poulastha, "SELECT * FROM notices WHERE FIND_IN_SET('$facultyId', access) ORDER BY id DESC");
	
	while($a = mysqli_fetch_array($sql))
	{
?>
<tr class="info">
	<td><?php echo $a['title'];?></td>
	<td><?php echo $a['notice'];?></td>
	<td><div align="center"><a href="asl_uploads/<?php echo $a['file'];?>"><img src="images/dwd.png" height="30" width="30" /></a></td>
	<td><?php echo $a['date'];?></td>
</tr>
<?php
	}
?>
</table>
<p></p>
<a href="fhome.php">Go Back</a>
</div>
</body>
</html>
