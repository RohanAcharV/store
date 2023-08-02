<?php
session_start();
$conn = mysqli_connect("localhost","root","","store");
if(isset($_POST['calculate']))
{
    $query="select * from purchase where uid={$_SESSION['uid']} and pay_id={$_SESSION['pay_id']}";
        $reslt=mysqli_query($conn,$query);
        while($row=mysqli_fetch_assoc($reslt)){  
            $updt=$_POST[$row['pid']];
            $actual=$_POST['actual'];
            if($updt>0 && $updt<=$actual)
            {
                $sql="update purchase set qty='$updt' where pid={$row['pid']} and uid={$_SESSION['uid']} and pay_id={$_SESSION['pay_id']}";
                mysqli_query($conn,$sql);
                
            }
        }   
        header("Location: add.php");  

}

?>
