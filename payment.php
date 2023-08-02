<?php
session_start();
$conn=mysqli_connect("localhost","root","","store");
$query1="select * from purchase where uid={$_SESSION['uid']} and pay_id={$_SESSION['pay_id']}";
$result1=mysqli_query($conn,$query1);
while($row1=mysqli_fetch_assoc($result1))
{
    $sql1="update product set qty=qty-{$row1['qty']} where pid={$row1['pid']}";
    mysqli_query($conn,$sql1);
}


if(isset($_POST["payment"]))
{
$payid=$_SESSION['pay_id'];
$query2="select sum(pur.qty*pdt.sprice) as coll,sum(pur.qty*(pdt.sprice-pdt.bprice)) as prof from product pdt,purchase pur where pur.pid=pdt.pid and pur.pay_id=$payid";
$result2=mysqli_query($conn,$query2);

$row2=mysqli_fetch_assoc($result2);

$query3="update payment set price={$row2['coll']},profit={$row2['prof']} where pay_id=$payid";
mysqli_query($conn,$query3);

echo '<script>window.location="index.php"</script>';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment</title>
    <link rel="stylesheet" href="css/payment.css">
</head>
<body>

    <div class="calculator">
    <label for="given">Cash recieved :</label>
    <input type="text" name="given" id="given"><br>
    <label for="ttl">Cash to be paid :</label>
    <input type="text" name="ttl" id="ttl" value="" readonly><br>
    <label for="rtrn">Cash to be returned :</label>
    <input type="text" name="rtrn" id="rtrn" value="" readonly><br> 
    </div><br>

    <div class="QR"><h3>SCAN QR</h3><br><div class="qr"></div> 7829926870</div>
    <div class="bill">
        <center><h3>Invoice</h3></center>
        <div class="info">
       <div class="det">
             <ul>
        <li> Name: <span class="values"><?php echo "{$_SESSION['uname']}";?></span></li>
        <li> email:<span class="values"><?php echo "{$_SESSION['uemail']}";?></span></li>
        <li> mobile:<span class="values"><?php echo "{$_SESSION['mobile']}";?></span></li>
        <li> date: <span class="values"><?php echo  $_SESSION['date'] ;?></span></li>
        <li> time: <span class="values"><?php echo  $_SESSION['time'] ;?></span></li>
        <li> Payment_id: <span class="values"><?php echo  $_SESSION['pay_id'] ;?></span></li>
        </ul>
       </div>
        <div class="image">
            <img src="css/supermarket.webp" alt="error" width=250 height=150>
        </div>
    </div>
        <table id="tble">
            <tr>
                <th>name</th>
                <th>price</th>
                <th>qty</th>
                <th>total</th>
            </tr>
            <?php
            $sql1="select * from purchase where pay_id={$_SESSION['pay_id']}";
            $res1=mysqli_query($conn,$sql1);
            while($row1=mysqli_fetch_assoc($res1))
            {
            ?>
            <tr>
                <td><?php echo "{$row1['pname']}";?></td>
                <td><?php echo "{$row1['price']}";?></td>
                <td><?php echo "{$row1['qty']}";?></td>
                <td class="ttl"><?php echo $row1['price']*$row1['qty'] ;?></td>
            </tr>
            <?php
            }
            ?>
            <tr id="ttl_val">
                <td colspan="4" ><pre>   Total:     &#8377 <span id="total">0</span></pre></td>
            </tr>
        </table>


    </div>
    <form method="post">
    <input type="hidden" name="payment">
    <button class="bttn">Payment done</button>
    </form>
<button onclick="Print();" class="bttn">Print bill</button>
<script>
    
    const urlParams = new URLSearchParams(window.location.search);
    const ttl_val = urlParams.get('ttl');
    let given=document.getElementById('given'),ttl=document.getElementById('ttl'),rtrn=document.getElementById('rtrn')
    ttl.value=ttl_val
    
    
    function calc(){
        rtrn.value=given.value-ttl_val
        console.log(given.value,ttl.value)
    }

    given.addEventListener('input', calc);

    function Print(){
        event.preventDefault();
        const content=document.body.innerHTML
        document.body.innerHTML=document.getElementsByClassName("bill")[0].innerHTML
        window.print();
        document.body.innerHTML=content
       
        window.location.reload()
    }
    
    document.getElementById('total').innerHTML=ttl_val

   
    
</script>
</body>
</html>