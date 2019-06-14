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
        $(window).ready( function() {
            $("#status").fadeOut();
            $("#preloader").delay(350).fadeOut("slow");
        });

    </script>
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
<div id="preloader">
    <div id="status">
        <p class="center-text"><span>拼命加载中···</span></p>
    </div>
</div>
<div class="d-flex fixed-top">
    <a href="myInfo.php" class="back">
        <span class="glyphicon glyphicon-remove"></span>
    </a>
    <h3>我的发布</h3>
</div>
<div class="container-fluid myTab">
    <div class="d-flex mb-3 ">
        <a href="myorders.php" class="flex-fill ">
            <span class="active">待接单</span>
        </a>
        <a href="myorder1.php" class="flex-fill ">
            <span>待确认</span>
        </a>
        <a href="myorder2.php" class="flex-fill ">
            <span class="complete">已完成</span>
        </a>
    </div>

</div>

<?php
include 'utils.php';
$utils =  new Utils;
$dbconn = $utils->get_db_conn();
session_start();
$openid = $_SESSION['openid'];
if(!isset($openid)){
    echo "未获取到openid";
    exit;
}
$sql_query = "select * from `orders` where openid='".$openid."' and sopenid is null";
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
    $releasetime = $row['releasetime'];
    $releasetime = $utils->convert_time($releasetime);
    $sql = "select * from `apartment` where aid = $apartment";
    $temp_result = $dbconn->query($sql);
    $apartment = $temp_result->fetch(PDO::FETCH_ASSOC)['name'];
    $extra = $row['extra'];
    $fee = $row['fee'];
    if($dormitory==''){
        echo "<section class='container border'>
            <header>
                <span class='time text-left'>$releasetime</span>
                <span class='place text-right'>$apartment</span>
            </header>
            <section class='mid'>
                <img src='".$imgpath."' class='userImg'>
                <span>快递：$express </span>
                <span> 酬金:$fee</span>
                <p>要求:$extra</p>
            </section>
            <footer>
                <div class='row'>
                    <div class='col-1'></div>
                    <a href='delete_order.php?oid=".$oid."' class='btn btn-success myBtn col-4'>删除订单</a>
                    <div class='col-2'></div>
                    <a href='showmyorder.php?oid=".$oid."' class='btn btn-success myBtn col-4'>查看/修改信息</a>
                    <div class='col-1'></div>
                </div>

            </footer>
        </section>"; 
    }else{
        // $floor = substr($dormitory, 0,1);
        echo "<section class='container border'>
            <header>
                <span class='time text-left'>$releasetime</span>
                <span class='place text-right'>$apartment</span>
            </header>
            <section class='mid'>
                <img src='".$imgpath."' class='userImg'>
                <span>快递：$express </span>
                <span>寝室号: $dormitory</span>
                <span> 酬金:$fee</span>
                <p>要求:$extra</p>
            </section>
            <footer>
                <div class='row'>
                    <div class='col-1'></div>
                    <a href='delete_order.php?oid=".$oid."' class='btn btn-success myBtn col-4'>删除订单</a>
                    <div class='col-2'></div>
                    <a href='showmyorder.php?oid=".$oid."' class='btn btn-success myBtn col-4'>查看/修改信息</a>
                    <div class='col-1'></div>
                </div>

            </footer>
        </section>"; 
    }
    
}
?>
</body>
</html>