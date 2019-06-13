<!DOCTYPE html>
<html>
<head>
    <title>我发布的订单</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, user-scalable=no">
    <link rel="stylesheet" href="css/bootstrap.min.css">

    <link href="bs/bootstrap.css" rel="stylesheet">
    <link href="css/list.css" rel="stylesheet">
    <script src="js/jquery.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>

    <script>
        (function(){
            var html=document.documentElement;
            var hWidth=html.getBoundingClientRect().width;
            html.style.fontSize=hWidth/15+"px ";//1rem=50px
        })();
    </script>
</head>
<style>

</style>
<body>
<div class="d-flex fixed-top">
    <a href="myInfo.php" class="back">
        <span class="glyphicon glyphicon-remove"></span>
    </a>
    <h3>我的发布</h3>
</div>
<div class="container-fluid myTab">
    <div class="d-flex mb-3 ">
        <a href="myorders.php" class="flex-fill ">
            <span>待接单</span>
        </a>
        <a href="myorder1.php" class="flex-fill ">

            <span>待确认</span>
        </a>
        <a href="myorder2.php" class="flex-fill">

            <span class="complete active">已完成</span>
        </a>
    </div>

</div>

<?php
include 'utils.php';
$utils =  new Utils;
$dbconn = $utils->get_db_conn();
session_start();
$openid = $_SESSION['openid'];

$sql_query = "select * from `order` where openid='".$openid."' and  receivetime is not null";
$result = $dbconn->query($sql_query);
foreach ($result as $row) {
    $oid = $row['oid'];
    $express = $row['express'];
    $dormitory = $row['dormitory'];
    //通过编号获取快递公司名称
	$sql = "select * from `express` where eid = $express";
    $temp_result = $dbconn->query($sql);
    foreach ($temp_result as $row1) {
         $express = $row1['name'];
         $imgpath = $row1['imgpath'];
    }
    $apartment = $row['apartment'];
    $sql = "select * from `apartment` where aid = $apartment";
    $temp_result = $dbconn->query($sql);
    $releasetime = $row['releasetime'];
    $releasetime = $utils->convert_time($releasetime);
    $apartment = $temp_result->fetch(PDO::FETCH_ASSOC)['name'];
    $extra = $row['extra'];
    $fee = $row['fee'];
    if($dormitory==''){
        echo "<section class='container border'>
                <header>
                    <span class='time text-left'>$releasetime </span>
                    <span class='place text-right'> $apartment</span>
                </header>
                <section class='mid'>
                    <img src='".$imgpath."' class='userImg'>
                    <span>快递：$express </span>
                    <span> 酬金：$fee</span>
                    <p>要求：$extra</p>
                </section>

            </section>"; 
    }else{
        // $floor = substr($dormitory, 0,1);
        echo "<section class='container border'>
                <header>
                    <span class='time text-left'>$releasetime </span>
                    <span class='place text-right'> $apartment</span>
                </header>
                <section class='mid'>
                    <img src='".$imgpath."' class='userImg'>
                    <span>快递：$express </span>
                    <span>寝室号：$dormitory </span>
                    <span> 酬金：$fee</span>
                    <p>要求：$extra</p>
                </section>

            </section>"; 
    }
    
}
?> 


</body>
</html>