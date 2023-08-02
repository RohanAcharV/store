<?php
$conn=mysqli_connect("localhost","root","","store");
if(isset($_POST['cat_ins']))
{
    $sql1="SELECT * FROM category ORDER BY catid DESC LIMIT 1";
    $reslt1=mysqli_query($conn,$sql1);
    $row1=mysqli_fetch_assoc($reslt1);
    $id=$row1['catid']+1;
    $cname=$_POST['cname'];
    $sql2="insert into category values ($id,'$cname')";
    mysqli_query($conn,$sql2);
}
if(isset($_POST['pdt_ins']))
{
    $sql="insert into product(pname,bprice,sprice,qty,cid) values('{$_POST['pname']}',{$_POST['bprice']},{$_POST['sprice']},{$_POST['qty']},{$_POST['catid']})";
    mysqli_query($conn,$sql);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>insert a new product</title>
    <link rel="stylesheet" href="css/nav.css">
    <link rel="stylesheet" href="css/insert.css">
</head>
<body>
<div class="nav">
        <div class="profile"></div>
        <div class="menu">
        <!-- <button class="menu_bttn" onclick="window.location.href='cat_report.php'">cat_report</button> -->
        <button class="menu_bttn" onclick="window.location.href='prdt_report.php'">Product report</button>
        <button class="menu_bttn" onclick="window.location.href='monthly_report.php'">Monthly report</button>
        <button class="menu_bttn selected" onclick="window.location.href='insert.php'">insert</button>
        </div>
        <div class="sale"><button class="sale_bttn" onclick="window.location.href='index.php'">+ New Sale</button></div>
    </div>
    <div class="content">
    <div class="cat bx">
    <h1>Insert a new category</h1>
    <form action="" method="post">
    <input type="text" name="cname" id="cname" placeholder="Enter category name" required>
    <input type="submit" name="cat_ins" value="Insert">
    </form>
    </div>

    <div class="pdt bx">
    <h1>Insert a new product</h1>
    <form action="" method="post">
    <input type="text" name="pname" id="pname" placeholder="Enter product name" required>
    <input type="text" name="bprice" id="bprice" placeholder="Enter buying price" required>
    <input type="text" name="sprice" id="sprice" placeholder="Enter selling price" required>
    <input type="text" name="qty" id="qty" placeholder="Enter qty(stock)" required>
    <select name="catid" id="catid">
        <?php
        $query="select * from category";
        $result=mysqli_query($conn,$query);
        while($row=mysqli_fetch_assoc($result)){
        ?>
        <option value="<?php echo $row['catid']; ?>"><?php echo $row['cname']; ?></option>
        <?php
        }
        ?>
    </select>
    <input type="submit" name="pdt_ins" value="Insert">
    </form>
  
    </div>
    </div>
    </div>


</body>
</html>