<?php
  require("config.php");
  $name=$_POST['name'];
  $designation=$_POST['designation'];
  $fid=$_POST['fid'];
  $email=$_POST['email'];
  $contact=$_POST['contact'];
  $p1=$_POST['p1'];
  $p2=$_POST['p2'];
  $date=date('d-M-Y');
  $c=mysqli_query($poulastha,"SELECT * FROM faculty WHERE email='$email'");
  if($name==NULL || $designation==NULL || $email==NULL || $contact==NULL || $p1==NULL || $p2==NULL)
  {
  		//Do Nothing
  }
  elseif(mysqli_num_rows($c)==1)
  		{
  			$info="User Already Registered ";
  		}
  		elseif($p1==$p2)
  		{	
  			$p3=($p1);
  			$sql=mysqli_query($poulastha,"INSERT INTO faculty(name,designation,fid,email,contact,password,date,status) VALUES('$name','$designation','$fid','$email','$contact','$p3','$date','0')");
  			$info="Request Sent For User $name";
  		}
  		else
  		{
  			$info="Password Didn't Match";
  		}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Faculty Registration Panel</title>
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
<div align="center"><br />
<span class="head">Faculty Registration Panel</span> <br /><br /><br />
<form action="<?php $_SERVER['PHP_SELF'];?>" method="post" onsubmit="MM_validateForm('name','','R','','RisNum','email','','RisEmail','contact','','RisNum','p1','','R','p2','','R');return document.MM_returnValue">
<table cellpadding="3" cellspacing="3" class="formTable">
<tr><td></td></tr>
<tr><td colspan="2" align="center" class="Subhead">Please Fill All The Details</td></tr>
<tr><td colspan="2" align="center" class="info"><?php echo $info;?></td></tr>
<tr><td></td></tr>
<tr>
  <td class="labels">Full Name : </td>
  <td><input name="name" type="text" class="fields" id="name" placeholder="Enter Full Name" size="40"/></td>
</tr>
<tr><td></td></tr>
<tr>
  <td class="labels">Designation : </td>
  <td><input name="designation" type="text" class="fields" id="designation" placeholder="Enter Designation" size="40"/></td>
</tr>
<tr><td></td></tr>
<tr><td class="labels">Faculty ID (optional) : </td><td><input name="fid" type="text" class="fields" id="fid" placeholder="Enter Faculty ID (optional)" size="25"/></td></tr>
<tr><td></td></tr>
<tr><td class="labels">E-Mail : </td><td><input name="email" type="text" class="fields" id="email" placeholder="Enter Institutional E-Mail ID" size="40"/></td></tr>
<tr><td></td></tr>
<tr><td class="labels">Contact No. : </td><td><input name="contact" type="text" class="fields" id="contact" placeholder="Enter Mobile No." size="20" maxlength="10"/></td></tr>
<tr><td></td></tr>
<tr><td class="labels">Password : </td><td><input name="p1" type="password" class="fields" id="p1" placeholder="Enter Password" size="30"/></td></tr>
<tr><td></td></tr>
<tr><td class="labels">Re-Type Password : </td><td><input name="p2" type="password" class="fields" id="p2" placeholder="Re-Type Password" size="30"/></td></tr>
<tr><td></td></tr>
<tr><td align="center" colspan="2"><input type="submit" value="Sumbit Request" class="button" onclick="return confirm('Please Confirm All Fields Before Submitting');" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="reset" value="Clear"  class="button" onclick="return confirm('Are You Sure...?');"/></td></tr>
<tr><td></td></tr>
</table>
</form><br />
<a href="index.php">Go Back</a>
</div>
</body>
</html>