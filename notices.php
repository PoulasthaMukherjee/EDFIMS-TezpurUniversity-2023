<?php
  session_start();
  include("config.php");
  if(!isset($_SESSION['admin']))
  {
  	header("location:index.php");
  }
  $notice=$_POST['notice'];
  $title=$_POST['title'];
  $date=date('d-M-Y');
  $access = implode(",", $_POST['access']);
  if($notice==NULL || $title==NULL || $access==NULL)
  {
  	//Do Nothing
  }
  else
  {
  	$extension = end(explode(".", $_FILES["file"]["name"]));
  	$filename="$title".".$extension";
  	move_uploaded_file($_FILES["file"]["tmp_name"],"asl_uploads/$filename"); 
  	mysqli_query($poulastha,"INSERT INTO notices(title,notice,file,date,access) VALUES('$title','$notice','$filename','$date','$access')");
  	$info="Successfully Submitted Notice";

  }
  $del=$_GET['del'];
  if($del==NULL)
  {
  	//Do Nothing
  }
  else
  {
  	mysqli_query($poulastha,"DELETE FROM notices WHERE id='$del'");
  }
?>

<?php

$hostname = "localhost";
$username = "root";
$password = "";
$databaseName = "onb";

$connect = mysqli_connect($hostname, $username, $password, $databaseName);
$query = "SELECT * FROM `faculty`";

$result = mysqli_query($connect, $query);

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>File Upload Page</title>
<link href="scripts\styleASL.css" rel="stylesheet" type="text/css" />
<script type="text/javascript">
function MM_validateForm() { //v4.0
  if (document.getElementById){
    var i,p,q,nm,test,num,min,max,errors='',args=MM_validateForm.arguments;
    for (i=0; i<(args.length-2); i+=3) { test=args[i+2]; val=document.getElementById(args[i]);
      if (val) { nm=val.name; if ((val=val.value)!="") {
        if (test.indexOf('isEmail')!=-1) { p=val.indexOf('@');
          if (p<1 || p==(val.length-1)) errors+='- '+nm+' must contain an e-mail address.\n';
        } else if (test!='R') { num = parseFloat(val);
          if (isNaN(val)) errors+='- '+nm+' must contain a number.\n';
          if (test.indexOf('inRange') != -1) { p=test.indexOf(':');
            min=test.substring(8,p); max=test.substring(p+1);
            if (num<min || max<num) errors+='- '+nm+' must contain a number between '+min+' and '+max+'.\n';
      } } } else if (test.charAt(0) == 'R') errors += '- '+nm+' is required.\n'; }
    } if (errors) alert('The following error(s) occurred:\n'+errors);
    document.MM_returnValue = (errors == '');
} }
</script>
</head>

<body>
<span class="head">File Uploads</span>
<span style="float:right;"><a href="logout.php">Logout</a></span><br />
<hr style="clear:both;box-shadow:0px 0px 2px #000;" color="#FF6600" size="2" width="100%"/><br />
<div align="center">
<form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post" enctype="multipart/form-data" onsubmit="MM_validateForm('title','','R','notice','','R');return document.MM_returnValue">
<table cellpadding="3" cellspacing="3" class="formTable">
<tr><td colspan="2">
<span class="Subhead">Add File</span>
<hr />
</td></tr>
<tr><td colspan="2" class="info"><?php echo $info;?></td></tr>
<tr>
  <td class="labels">Share With</td>
  <td>
    <select name="access[]" class="fields" multiple>
      <option disabled="disabled" selected="selected">- Select Faculty - </option>
      <?php while($row = mysqli_fetch_array($result)):;?>
        <option value="<?php echo $row[0];?>"><?php echo $row[1];?></option>
      <?php endwhile;?>
    </select>
  </td>
</tr>


<tr><td></td></tr>
<tr><td class="labels">Title</td><td><input name="title" type="text" class="fields" id="title" placeholder="Enter Title" size="45" /></td></tr>
<tr><td></td></tr>
<tr><td class="labels">Description</td><td><textarea name="notice" cols="35" class="fields" id="notice" style="height:70px;font-family:'trebuchet MS';" placeholder="Enter Description"></textarea></td></tr>
<tr><td></td></tr>
<tr><td class="labels">Upload File</td><td><input type="file" name="file" size="45" class="button" placeholder="Select Document or Image File"/></td></tr>
<tr><td></td></tr>
<tr><td colspan="2" align="center"><input type="submit" name="submit" value="Submit" class="button" onclick="return confirm('Are You Sure...?');"/></td></tr>
<tr><td></td></tr>
</table> 
</form>
<br>
<table cellpadding="3" cellspacing="3" class="formTable">
<tr>
  <th>ID</th>
  <th>Title</th>
  <th>File</th>
  <th>Shared With</th>
  <th>Date</th>
  <th>Download</th>
  <th>Action</th>
</tr>
<?php 
  $a=mysqli_query($poulastha,"SELECT * FROM notices ORDER BY id DESC");
  while($b=mysqli_fetch_array($a))
  {
?>
<tr class="info">
  <td><?php echo $b['id'];?></td>
  <td><?php echo $b['title'];?></td>
  <td><?php echo $b['notice'];?></td>
  <td><?php echo $b['access'];?></td>
  <td><?php echo $b['date'];?></td>
  <td align="center"><a href="asl_uploads/<?php echo $b['file'];?>"><img src="images/dwd.png" height="30" width="30" /></a></td>
  <td>
    <a href="edit.php?edit=<?php echo $b['id'];?>" style="text-shadow:0px 0px 1px #000000;">Edit</a>
    <a href="notices.php?del=<?php echo $b['id'];?>" onclick="return confirm('Are You Sure..?');" style="text-shadow:0px 0px 1px #000000;">Delete</a>
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