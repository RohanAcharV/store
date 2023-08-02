<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>register</title>
    <link rel="stylesheet" href="css/login.css">
    <link rel="stylesheet" href="css/nav.css">
</head>
<body>
<div class="nav">
        <div class="profile"></div>
        <div class="menu">
        <button class="menu_bttn" onclick="window.location.href='cat_report.php'">cat_report</button>
        <button class="menu_bttn" onclick="window.location.href='prdt_report.php'">Product report</button>
        
        <!-- <button class="menu_bttn" onclick="window.location.href='daily_report.php'">daily_report</button> -->
        <button class="menu_bttn" onclick="window.location.href='monthly_report.php'">monthly_report</button>
        <button class="menu_bttn" onclick="window.location.href='insert.php'">insert</button>
        </div>
        <div class="sale"><button class="sale_bttn selected" onclick="window.location.href='index.php'">+ New Sale</button></div>
    </div>
    <div class="content">
    <div class="container">
        <span id="new_user">New user</span>
        <br>
        <form action="login_direct.php" method="post">
            <div class="info">
                <input type="text" name="reg_mobile" class="reg_mobile" value=<?php echo "{$_SESSION['mobile']}";?>>
                
                <input type="text" name="reg_email" class="reg_mobile" placeholder="Enter email">
                
                <input type="text" name="reg_name" class="reg_mobile" placeholder="Enter name">

            </div>
            <div class="bttn">
                <input type="submit" value="Start billing" name="reg_sub" id="sub_bttn">
            </div>
        </form>
    </div>
    </div>
</body>
</html>