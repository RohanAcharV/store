<?php
session_start();
$conn = mysqli_connect("localhost","root","","store");
date_default_timezone_set("Asia/Kolkata");
$_SESSION['date']=date("Y-m-d");
$_SESSION['time']=date("h:i:sa");
if(isset($_POST['log_sub']))
{
    $mob=$_POST['log_mobile'];
    $sql="select * from user where mobile='$mob'";
    $result = mysqli_query($conn, $sql);
    $cnt = mysqli_num_rows($result);
    $_SESSION['mobile']=$mob;
    if($cnt==1)
    {
        $row=mysqli_fetch_assoc($result);
        $_SESSION['uname']=$row['name'];
        $_SESSION['uemail']=$row['email'];
        $_SESSION['uid']=$row['uid'];

        $query1="delete from payment where price=0";
        mysqli_query($conn,$query1);

        $query2="delete from purchase where pay_id not in (select pay_id from payment)";
        mysqli_query($conn,$query2);

        $sql1="insert into payment(uid,pdate,ptime) values ({$_SESSION['uid']},'{$_SESSION['date']}','{$_SESSION['time']}')";
        mysqli_query($conn, $sql1);
        $_SESSION['pay_id']= mysqli_insert_id($conn);

        header("Location:add.php");
        exit();            
    }
    else{
        header("Location:register.php");
        exit();            
    }
}
if(isset($_POST['reg_sub']))
{
    $mob=$_SESSION['mobile'];
    $_SESSION['uname']=$_POST['reg_name'];
    $_SESSION['uemail']=$_POST['reg_email'];
    $sql="insert into user(email,name,mobile) values ('{$_SESSION['uemail']}','{$_SESSION['uname']}','{$_SESSION['mobile']}')";
    $result = mysqli_query($conn, $sql);

    $_SESSION['uid']= mysqli_insert_id($conn);
    
    $query1="delete from payment where price=0";
    mysqli_query($conn,$query1);

    $query2="delete from purchase where pid not in (select pid from payment)";
    mysqli_query($conn,$query2);

    $sql1="insert into payment(uid,pdate,ptime) values ({$_SESSION['uid']},'{$_SESSION['date']}','{$_SESSION['time']}')";
mysqli_query($conn, $sql1);
$_SESSION['pay_id']= mysqli_insert_id($conn);



    header("Location:add.php");
    exit(); 

}
?>
      