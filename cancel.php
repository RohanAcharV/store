<?php
session_start();
$conn=mysqli_connect("localhost","root","","store");
$pid=$_SESSION['pay_id'];
$sql1="delete from purchase where pay_id=$pid";
mysqli_query($conn,$sql1);
$sql2="delete from payment where pay_id=$pid";
mysqli_query($conn,$sql2);
header("Location:index.php");
?>