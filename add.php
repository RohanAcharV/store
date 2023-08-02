<?php
ob_start();   
// output buffer started to modify header info at 197
session_start();
$conn = mysqli_connect("localhost","root","","store");

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add products</title>
    <!-- <link rel="stylesheet" href="css/add.css"> -->
    <link rel="stylesheet" href="css/add2.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
<script>
$(document).ready(function(){
    $("#calculator").hide();
  $("#calculate").click(function(){
    $("#calculator").toggle();
  });
});
</script>
</head>
<body>
<div class="nav">
<div class="info">
    <div class="info1">
    <li> Name: <span class="values"><?php echo "{$_SESSION['uname']}";?></span></li>
    <li> email:<span class="values"><?php echo "{$_SESSION['uemail']}";?></span></li>
    <li> mobile:
    <span class="values"><?php echo "{$_SESSION['mobile']}";?></span></li>
    </div>
    <div class="info2">
        <li> date: <span class="values"><?php echo  $_SESSION['date'] ;?></span></li>
        <li> time: <span class="values"><?php echo  $_SESSION['time'] ;?></span></li>
    </div>
</div>


<!-- <button id="calculate">Calculator</button> -->
<!-- <div id="calculator">
    <ul id="calc_list">
        <li>Value in g/mL: <input type="text" id="g/ml"></li>
        <li>Price:<input type="text" id="g/ml_price" value=0></li>
        <li><button onclick="calc();">Convert</button></li>
        <li>Value in Kg/L: <span id="kg/l"></span></li>
        <li>Price: <span id="kg/l_price"></span></li>
    </ul>
</div> -->

</div>
<div class="container">

    
    <div class="search">
        <form method="post" action="" id="srch">
        <input type="search" name="search" class="sbar" placeholder="find products" style="width: 20vw;height:5vh;">
        <button type="submit" name="submit" class="sbtn">search</button>
        </form>
    </div>

    <div class="found">
        <?php
        if(isset($_POST['submit'])) {
            $pn = $_POST['search'];
            $query = "SELECT * FROM product WHERE pname LIKE '%$pn%' and qty>0";
            $result = mysqli_query($conn, $query);
            while ($row = mysqli_fetch_assoc($result)) {
            ?>
          <form action="add.php" method="post" id="recom">
          <input type="submit" class="recom" name="pdt" value="<?php echo "{$row['pname']}";?>"><br>
          </form>
          <?php
            }
        }
        ?>
    </div>
         
    <div class="table">
        <?php
        if(isset($_POST['pdt'])) {
            $pdt=$_POST['pdt'];
            
            $query = "SELECT COUNT(*) FROM purchase WHERE pname = '$pdt' and uid={$_SESSION['uid']} and pay_id={$_SESSION['pay_id']}";
            $result = mysqli_query($conn, $query);
            $row = mysqli_fetch_row($result);
            $count = $row[0];

            if ($count > 0) {
                echo '<div class="alert">' . $pdt . ' exists in table!!</div>';
            } else {
            

            $q1="select * from product where pname='$pdt'";
            $res=mysqli_query($conn,$q1);
            $row=mysqli_fetch_assoc($res);
            $q2="insert into purchase values({$row['pid']},'{$row['pname']}',{$row['sprice']},1,{$_SESSION['uid']},{$_SESSION['pay_id']})";
            mysqli_query($conn,$q2);
            header("Location: add.php");
            exit();
            }
        }   
        $q3="select * from purchase where uid={$_SESSION['uid']} and pay_id={$_SESSION['pay_id']}";
        $reslt=mysqli_query($conn,$q3);
        ?>
        <table id="items">
            <tr>
            <!-- <th>id</th> -->
            <th id="pname">name</th>
            <th>qty_left</th>
            <th>price</th>
            <th>qty</th>
            <th>ttl</th>
            <th class="pdel"></th>
            </tr>
        <?php
        while($row=mysqli_fetch_assoc($reslt)){  
            $q4="select * from product where pid={$row['pid']}";
            $res4=mysqli_query($conn,$q4);
            $row4=mysqli_fetch_assoc($res4);
        ?>
            <tr class="rows">
            <!-- <td><?php echo "{$row['pid']}";?></td> -->
            <td><?php echo "{$row['pname']}";?></td>
            <td><?php echo "{$row4['qty']}";?></td>
            <td class="pprice"><?php echo "{$row['price']}";?></td>
            <td class="pqt">
                <form action="test.php" method="post" id="next">
                <input type="text" name="<?php echo "{$row['pid']}";?>" size=10 class="pqty" value=<?php echo "{$row['qty']}";?>>
                <input type="hidden" class="actual" name="actual" value=<?php echo "{$row4['qty']}";?>>
                <input type="submit" value="add" name="calculate" id="nxt">
                </form>
            </td>
            <td class="ptl">0</td>            
            <td class="pdel"><button class="delbtn" value="<?php echo "{$row['pid']}";?>">Delete</button></td>
            </tr>
        
            <?php } ?>
        </table>
    </div>

    <div class="total">
<pre>   Total:     &#8377 <span id="ttl">0</span></pre>
</div>
<!-- <br> -->
<button class="cbttn" id="payment" onclick="payment();">confirm payment</button>
<!-- <br> -->
<button class="cbttn" id="cancel" onclick="window.location.href='cancel.php'">cancel</button>

</div>




<script>

const calc = () =>{
let val=document.getElementById('g/ml').value
let n=document.getElementById('g/ml_price').value
console.log(val,n)
val=val/1000
let price=val*n
document.getElementById('kg/l').innerHTML=val
document.getElementById('kg/l_price').innerHTML=price
}

const buttons = document.querySelectorAll('.delbtn');
buttons.forEach(button => {
  button.addEventListener('click', event => {
    event.preventDefault();
    const clickedButton = event.target;
     if(confirm("Do you want to delete id="+clickedButton.value))
     {
    let delval=clickedButton.value 
    window.location.href = window.location.href+'?delval='+delval;
     }
 });
});
 
const vals=document.querySelectorAll('.rows')
let sum=0
vals.forEach(val=>{
    let x=val.childNodes
    let price=x[7].textContent
    let qty=x[9].childNodes[1].childNodes[1].value
    x[11].innerHTML=(price*qty)
    sum=sum+(price*qty)
})

document.getElementById('ttl').innerHTML=sum;

const payment=()=>{
    window.location.href='payment.php'+'?ttl='+sum;
}

let q=document.getElementsByClassName('pqty'),a=document.getElementsByClassName('actual')
for(let i=0;i<q.length;i++)
{
    // console.log(q[i].value,a[i].value)
    let x=parseInt(q[i].value),y=parseInt(a[i].value)
    if(x>y){
    alert(i+"less stock ;stock left is ="+y)
    // q[i].value=1
    }
}

</script>

</body>
</html>

<?php
if(isset($_GET['delval']))
            {
                $delval=$_GET['delval'];
                if($delval!=0){
                $dv=$delval;
                $q="delete from purchase where pid=$dv and pay_id={$_SESSION['pay_id']}";
                mysqli_query($conn,$q);
                }
                header("Location: add.php");
                exit();
                
            }
ob_end_flush();
// end output buffer and send the output to browser (at 131) header modified at 197
?>