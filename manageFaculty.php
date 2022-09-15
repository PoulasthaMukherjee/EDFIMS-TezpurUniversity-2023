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
<title>Manage Faculty Accounts</title>
<link href="scripts\styleASL.css" rel="stylesheet" type="text/css" />
</head>

<body>
<span class="head">Manage Faculty Accounts</span>
<span style="float:right;"><a href="logout.php">Logout</a></span><br />
<hr style="clear:both;box-shadow:0px 0px 2px #000;" color="#FF6600" size="2" width="100%"/><br />

<div align="center">
<span class="Subhead">All Faculties</span><br />
<p></p>
<table cellpadding="3" cellspacing="3" class="formTable">
<tr>
	<th>Faculty ID </th>
	<th>Name</th>
	<th>Designation</th>
	<th>Email</th>
	<th>Contact No.</th>
	<th>Password</th>
	<th>Status</th>
	<th>Delete</th>
</tr>

<?php
	include("config.php");
	$a=mysqli_query($poulastha,"SELECT * FROM faculty ORDER BY id DESC");
	while($b=mysqli_fetch_array($a))
	{
?>
    
<tr class="labels" style="font-size:18px;">
	<td><?php echo $b['fid'];?></td>
	<td><?php echo $b['name'];?></td>
	<td><?php echo $b['designation'];?></td>
	<td><?php echo $b['email'];?></td>
	<td><?php echo $b['contact'];?></td>
	<td><?php echo $b['password'];?></td>
	<td>
		<?php
			if($b['status']==0)
			{
		?>
				<a href="activation.php?s=<?php echo $b['email'];?>&p=3">Activate</a>
		<?php 
			} 
			else
			{
		?>
    			<a href="activation.php?s=<?php echo $b['email'];?>&p=4">Deactivate</a>
		<?php
			}
		?>
	</td>
	<td>
		<a href="delete.php?del=<?php echo $b['email'];?>&p=2" onclick="return confirm('Are You Sure...?');" onmouseover="style.color='red'" onmouseout="style.color='brown'">Delete</a>
	</td>
</tr>

<?php
	}
?>




</table>
<p></p>
<a href="admin.php">Go Back</a>
</div>
</body>
</html>