<?php
include("config.php");
$email = $_GET['s'];
$p = $_GET['p'];

if ($p == 3) {
    $sql = mysqli_query($poulastha, "UPDATE faculty SET status='1' WHERE email='$email'");
} elseif ($p == 4) {
    $sql = mysqli_query($poulastha, "UPDATE faculty SET status='0' WHERE email='$email'");
}

if ($sql) {
    header("location: manageFaculty.php");
} else {
    header("location: admin.php");
}
?>
