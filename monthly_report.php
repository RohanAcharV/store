<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Monthly report</title>
    <link rel="stylesheet" href="css\monthly_report.css">
    <link rel="stylesheet" href="css\nav.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>
</head>
<body>
<div class="nav">
        <div class="profile"></div>
        <div class="menu">
        <!-- <button class="menu_bttn" onclick="window.location.href='cat_report.php'">cat_report</button> -->
        <button class="menu_bttn" onclick="window.location.href='prdt_report.php'">Product report</button>
       
        <!-- <button class="menu_bttn" onclick="window.location.href='daily_report.php'">daily_report</button> -->
        <button class="menu_bttn selected" onclick="window.location.href='monthly_report.php'">monthly_report</button>
        <button class="menu_bttn" onclick="window.location.href='insert.php'">insert</button>
        </div>
        <div class="sale"><button class="sale_bttn" onclick="window.location.href='index.php'">+ New Sale</button></div>
    </div>
    <div class="content">
    <div id="months">
          <form action="" method="post">
          <label for="months">Select a month</label><br>
        <select name="month" id="month">
    <option value="01_31_January">Jan</option>
    <option value="02_29_February">Feb</option>
    <option value="03_31_March">Mar</option>
    <option value="04_30_April">Apr</option>
    <option value="05_31_May">May</option>
    <option value="06_30_June">Jun</option>
    <option value="07_31_July">Jul</option>
    <option value="08_31_August">Aug</option>
    <option value="09_30_September">Sep</option>
    <option value="10_31_October">Oct</option>
    <option value="11_30_November">Nov</option>
    <option value="12_31_December">Dec</option>

    </select>
    <input type="submit" value="generate" name="submit" id="gen">
<script>var currentMonth = new Date().getMonth() + 1;

var select = document.getElementById("month");
for (var i = 12; i >= currentMonth; i--) {
    select.remove(i);
}
</script>
</form>
    </div>
<div id="graph">
<canvas id="myChart"></canvas>
</div>
<div class="amnt">
      <div class="box">
        Total collection: &#8377; <span id="tot_coll">0</span>
      </div>
      <div class="box">
        Total profit: &#8377; <span id="tot_prof">0</span>
      </div>
    </div>
    </div>
<script>

<?php
if(isset($_POST['submit'])){
$conn=mysqli_connect("localhost","root","","store");
$a=$_POST['month'];
$v=(explode("_",$a));
$month=$v[0];
$year=date("Y");
$sql="select sum(price) as coll,sum(profit) as prof ,pdate from payment where pdate like '%$year-$month-%' group by pdate";
$result=mysqli_query($conn,$sql);
?>
let days=<?php echo $v[1];?>;
console.log(days);
let tot=0,prof=0
var xValues = [];
var yValues1 = [];
var yValues2 = [];
for(let i=0;i<days;i++)
{
    xValues.push(i+1)
    yValues1.push(0)
    yValues2.push(0)
}
<?php
while($row=mysqli_fetch_assoc($result)){
?>
var dte='<?php echo $row['pdate'];?>';
var s=dte.split('-')
var n=Number(s[2])

yValues1[n-1]=<?php echo $row['coll'];?>;
yValues2[n-1]=<?php echo $row['prof'];?>;
tot+=yValues1[n-1]
prof+=yValues2[n-1]
<?php
}
}
?>
new Chart("myChart", {
  type: "bar",
  data: {
    labels: xValues,
    datasets: [{
        label:"Collection",
      backgroundColor: "blue",
      data: yValues1
    },
    {
        label:"Profit",
      backgroundColor: "red",
      data: yValues2
    }]
  },
  options: {
    // legend: {display: false},
    title: {
      display: true,
      text: "Monthly report of <?php echo $v[2];?>"
    }
  }
});
document.getElementById('tot_coll').innerHTML=tot
document.getElementById('tot_prof').innerHTML=prof
</script>

</body>
</html>