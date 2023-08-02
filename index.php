<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>login</title>
    <link rel="stylesheet" href="css/login.css">
    <link rel="stylesheet" href="css/nav.css">
</head>
<body>
<div class="nav">
        <div class="profile"></div>
        <div class="menu">
        <!-- <button class="menu_bttn" onclick="window.location.href='cat_report.php'">cat_report</button> -->
        <button class="menu_bttn" onclick="window.location.href='prdt_report.php'">Product report</button>
        
        <!-- <button class="menu_bttn" onclick="window.location.href='daily_report.php'">daily_report</button> -->
        <button class="menu_bttn" onclick="window.location.href='monthly_report.php'">Monthly report</button>
        <button class="menu_bttn" onclick="window.location.href='insert.php'">insert</button>
        </div>
        <div class="sale"><button class="sale_bttn selected" onclick="window.location.href='index.php'">+ New Sale</button></div>
    </div>
    <div class="content">
    <div class="container">
        <form action="login_direct.php" method="post" onsubmit="return check()">
            <div class="info">
                <input type="text" name="log_mobile" id="log_mobile" placeholder="Enter mobile">
            </div>
            <div class="bttn">
                <input type="submit" value="Start billing" name="log_sub" id="sub_bttn">
            </div>
        </form>
    </div>
    
    </div>
    <script>
        const check=()=>{
            let no=document.getElementById('log_mobile').value
            console.log(no,no.length)
        if(no.length!=10){
            alert("Enter a valid number")
            return false
        }
        return true
        }
    </script>
</body>
</html>