<?php
$conn=mysqli_connect("localhost","root","","store");
session_start();
if(isset($_POST["update"])){
    $id=$_POST["id"];
    $qty=$_POST["qty"];

    $q="update product set qty=qty+$qty where pid=$id";
    mysqli_query($conn,$q);

    echo '<script>window.location="prdt_report.php"</script>';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product report</title>
    <link rel="stylesheet" href="css\nav.css">
    <link rel="stylesheet" href="css\prdt_report.css">
</head>
<body>
<div class="nav">
        <div class="profile"></div>
        <div class="menu">
        <!-- <button class="menu_bttn" onclick="window.location.href='cat_report.php'">cat_report</button> -->
        <button class="menu_bttn selected" onclick="window.location.href='prdt_report.php'">Product report</button>
       
        <!-- <button class="menu_bttn" onclick="window.location.href='daily_report.php'">daily_report</button> -->
        <button class="menu_bttn" onclick="window.location.href='monthly_report.php'">Monthly report</button>
        <button class="menu_bttn" onclick="window.location.href='insert.php'">insert</button>
        </div>
        <div class="sale"><button class="sale_bttn" onclick="window.location.href='index.php'">+ New Sale</button></div>
    </div>
    <div class="content">
    <div id="cats">
    <form method="post">
    <label for="category" id="label">Choose a category:</label><br>
    <select name="category" id="category">
    <option value=" ">Select category</option>
    <?php
    
    $sql="select * from category";
    $result=mysqli_query($conn,$sql);
    
    while($row=mysqli_fetch_assoc($result))
    {
    ?>
        <option value="<?php echo "{$row['catid']}";?>" ><?php echo "{$row['cname']}";?></option>
    <?php
    }
    ?>
    </select>
    <button type="submit" id="srch" name="search">search</button>
    </form>
    </div>
    <div id="tble">
    <table>
        <?php
        
        if(isset($_POST['search']) && $_POST['category']!=" ")
        {
            $_SESSION["catg"]=$_POST['category'];
        }

        if(isset($_SESSION["catg"]))
        {
        $cat=$_SESSION['catg'];
        $sql1="select * from product where cid=$cat";
        $result1=mysqli_query($conn,$sql1);

        $catname="select * from category where catid=$cat";
        $res=mysqli_query($conn,$catname);
        $val=mysqli_fetch_assoc($res);
        $cname=$val['cname'];

        ?>
        <caption><?php echo "$cname";?></caption>
           <tr>
            <th>Product ID</th>
            <th>Product Name</th>
            <th>Buying price</th>
            <th>Selling Price</th>
            
            <th>Quantity sold</th>
            <th>Quantity left</th>
            <th>Total earned</th>
            <th>Profit made</th>
            <th>Update quantity</th>
        </tr>

        <?php
        while($row1=mysqli_fetch_assoc($result1))
        {
            $sql2="select sum(qty),count(*) from purchase where pid={$row1['pid']}";
            $result2=mysqli_query($conn,$sql2);
            $row2=mysqli_fetch_assoc($result2);
            $qty_sold=$row2['sum(qty)'];
            if($row2['sum(qty)']==0)
                $qty_sold=0;
                
            $diff_amt= $row1['sprice'] - $row1['bprice'];

           ?>
           <tr>
            <td><?php echo "{$row1['pid']}";?></td>
            <td><?php echo "{$row1['pname']}";?></td>
            <td><?php echo "{$row1['bprice']}";?></td>
            <td><?php echo "{$row1['sprice']}";?></td>
        
            <td><?php echo "$qty_sold";?></td>
            <td class="left"><?php echo "{$row1['qty']}";?></td>
            <td class="tot"><?php echo $row1['sprice'] * $qty_sold;?></td>
            <td class="prof"><?php echo $qty_sold * $diff_amt;?></td>
            <td>
                <form method="post" class="updt">
                    <input type="number" value=0 name="qty">
                    <input type="hidden" name="id" value="<?php echo "{$row1['pid']}";?>" >
                    <input type="submit" value="Update" name="update" onclick="updtprdt(event,this.form);">
                </form>
            </td>
           </tr>
            <?php
        }

    }
        ?>
    </table>
    </div>
    <div class="amnt">
      <div class="box">
        Total collection: &#8377; <span id="tot_coll"></span>
      </div>
      <div class="box">
        Total profit: &#8377; <span id="tot_prof"></span>
      </div>
    </div>

    </div>
<script>

    const left_vals=document.getElementsByClassName('left')
    const tot=document.getElementsByClassName('tot')
    const prof=document.getElementsByClassName('prof')
    let tot_val=0,prof_val=0
    for(let i=0;i<tot.length;i++)
    {
        tot_val=tot_val+Number(tot[i].innerHTML)
        prof_val+=Number(prof[i].innerHTML)
        if(left_vals[i].innerHTML<10){
            left_vals[i].style.background="red"
            left_vals[i].style.color="white"
        }
    }
    document.getElementById('tot_coll').innerHTML=tot_val
    document.getElementById('tot_prof').innerHTML=prof_val

   const updtprdt=(e,form)=>{
    const x=form.elements[0].value
    if(!confirm("Do you want to add "+x+" items ??"))
    e.preventDefault();
   }
    
</script>
</body>
</html>