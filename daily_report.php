<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daily report</title>
</head>
<body>
    <h1>daily report</h1>
    <hr>
    <input type="date" name="report" id="date">
    <br>
    <button onclick="search();">search</button>
    <hr>
    <table>
        <tr>
            <th>Pay_id</th>
            <th>time</th>
            <th>price</th>
            <th>profit</th>
        </tr>
    <?php
    if(isset($_GET['date']))
    {
        $conn=mysqli_connect("localhost","root","","store");
        $dte=$_GET['date'];
        // echo $dte;
        $sql="select * from payment where pdate='$dte'";
        $result=mysqli_query($conn,$sql);
        while($row=mysqli_fetch_assoc($result))
        {
            ?>
            <tr>
                <td><?php echo $row['pay_id']; ?></td>
                <td><?php echo $row['ptime']; ?></td>
                <td class="tot"><?php echo $row['price']; ?></td>
                <td class="prof"><?php echo $row['profit']; ?></td>
            </tr>

            <?php
        }
    }
    ?>
    </table>
    <hr>
    <h2>Total collection: <span id="tot_coll"></span></h2>
    <h2>Total profit: <span id="tot_prof"></span></h2>
    <hr>
    <h1><button onclick="window.location.href='index.php'">Home</button></h1>
    <script>
        const search =() =>{
            let d=document.getElementById('date').value
            let url=window.location.href
            if(url.includes('date'))
            {
                let s=url.split('?date=')
                window.location.href=s[0]+"?date="+d;
            }
            else
            window.location.href=window.location.href+'?date='+d;
        }
        const tot=document.getElementsByClassName('tot')
    const prof=document.getElementsByClassName('prof')
    let tot_val=0,prof_val=0
    for(let i=0;i<tot.length;i++)
    {
        tot_val=tot_val+Number(tot[i].innerHTML)
        prof_val+=Number(prof[i].innerHTML)
    }
    document.getElementById('tot_coll').innerHTML=tot_val
    document.getElementById('tot_prof').innerHTML=prof_val
    </script>
</body>
</html>