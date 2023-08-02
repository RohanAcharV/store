<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Category report</title>
    <link rel="stylesheet" href="css\nav.css">
     <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
      <link rel="stylesheet" href="css\cat_report.css">
</head>
<body>
<div class="nav">
        <div class="profile"></div>
        <div class="menu">
        <!-- <button class="menu_bttn  selected" onclick="window.location.href='cat_report.php'">cat_report</button> -->
        <button class="menu_bttn" onclick="window.location.href='prdt_report.php'">Product report</button>
       
        <!-- <button class="menu_bttn" onclick="window.location.href='daily_report.php'">daily_report</button> -->
        <button class="menu_bttn" onclick="window.location.href='monthly_report.php'">Monthly report</button>
        <button class="menu_bttn" onclick="window.location.href='insert.php'">insert</button>
        </div>
        <div class="sale"><button class="sale_bttn" onclick="window.location.href='index.php'">+ New Sale</button></div>
    </div>
    <!-- <h1>category wise reports</h1><hr> -->
    
<div class="content">
<table>
        <caption>cat_coll</caption>
            <tr>
                <th>catid</th>
                <th>catname</th>
                <th>coll</th>
                <th>prof</th>
        </tr>
    <?php
    $conn=mysqli_connect("localhost","root","","store");
    $sql="select cat.catid,cat.cname,sum(pur.qty*pdt.sprice) as tot_coll,sum(pur.qty*(pdt.sprice-pdt.bprice)) as tot_prof from category cat,purchase pur,product pdt where cat.catid=pdt.cid and pur.pid=pdt.pid group by cat.catid";
    $result=mysqli_query($conn,$sql);
    while($row=mysqli_fetch_assoc($result))
    {
    ?>
    <tr>
        <td><?php echo "{$row['catid']}"; ?></td>
        <td class="cname"><?php echo "{$row['cname']}"; ?></td>
        <td class="tot"><?php echo "{$row['tot_coll']}"; ?></td>
        <td class="prof"><?php echo "{$row['tot_prof']}"; ?></td>
    </tr>
    <?php
    }
    ?>
    </table>
    <div class="amnt">
      <div class="box">
        Total collection: <br>&#8377; <span id="tot_coll"></span>
      </div>
      <div class="box">
        Total profit: <br>&#8377; <span id="tot_prof"></span>
      </div>
    </div>

    <div class="charts">
        <div class="chart">        
      <canvas id="myChart1"></canvas><br>collection
      </div>
      <div class="chart">        
      <canvas id="myChart2"></canvas><br>profit
      </div>
    </div>

<!-- <button onclick="window.location.href='index.php'" id="home">Home</button> -->

</div>
<script>
    const tot=document.getElementsByClassName('tot')
    const prof=document.getElementsByClassName('prof')
    const cname=document.getElementsByClassName('cname')
    let tot_coll=0,tot_prof=0
    let labls=[],vals1=[],vals2=[]
    for(let i=0;i<tot.length;i++)
    {
        vals1.push(Number(tot[i].innerHTML))
        vals2.push(Number(prof[i].innerHTML))
        labls.push(cname[i].innerHTML)
        tot_coll+=Number(tot[i].innerHTML)
        tot_prof+=Number(prof[i].innerHTML)
    }
    document.getElementById('tot_coll').innerHTML=tot_coll
    document.getElementById('tot_prof').innerHTML=tot_prof

     
    const data1 = {
      labels: labls,
      datasets: [{
        data: vals1,
        // backgroundColor: ['#ff6384', '#36a2eb', '#ffce56'],
        borderWidth: 1
      }]
    };
    const data2 = {
      labels: labls,
      datasets: [{
        data: vals2,
        // backgroundColor: ['#ff6384', '#36a2eb', '#ffce56'],
        borderWidth: 1
      }]
    };
    // Options for the pie chart
    const options = {
      responsive: true,
      color:'white',
      maintainAspectRatio: false
    };
    
    // Create the pie chart
    const ctx1 = document.getElementById('myChart1').getContext('2d');
    const myChart1 = new Chart(ctx1, {
      type: 'pie',
      data: data1,
      options: options
    });
    const ctx2 = document.getElementById('myChart2').getContext('2d');
    const myChart2 = new Chart(ctx2, {
      type: 'pie',
      data: data2,
      options: options
    });
</script>
</body>
</html>