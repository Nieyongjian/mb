<!DOCTYPE html>
<html>
<head>
    <title>已抢单待送达订单</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, user-scalable=no">
    <link rel="stylesheet" href="css/bootstrap.min.css">

    <link href="css/list.css" rel="stylesheet">
    <link href="bs/bootstrap.css" rel="stylesheet">

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
    .myTab-l,.myTab-r{
        padding: 5px 0 0;
        font-size: 15px;
        vertical-align: middle;
        text-align: center;
        background-color: #fff;
        border:2px solid #f1f1f1;
        margin-top:10px;
        height: 40px;
        line-height: 25px;
        color:#46cdd0 !important;
        margin-bottom: 10px;
    }
    .myTab-r{
        border-top-right-radius: 8px;
        border-bottom-right-radius: 8px;
        border-left: none;
    }
    .active{

        background-color:#46cdd0;
        color:#fff !important;

    }
    .myTab-l{
        border-top-left-radius: 8px;
        border-bottom-left-radius: 8px;
        border-right: none;
    }
</style>
<body>
<div class="d-flex fixed-top">
    <a href="myInfo.php" class="back">
        <span class="glyphicon glyphicon-remove"></span>
    </a>
    <h3>我的抢单</h3>
</div>
<div class="container">
    <div class="row">
        <div class="col-3"></div>
        <a href="gotorders.php" class="col-3 myTab-l active">待送达</a>
        <a href="gotorder1.php" class="col-3 myTab-r">已完成</a>
        <div class="col-3"></div>
    </div>
</div>

<?php
include 'utils.php';
//获取数据库连接
$utils =  new Utils;
$dbconn = $utils->get_db_conn();
session_start();
$openid = $_SESSION['openid'];
//查询已经抢到的但是还没有被确认收货的订单
$sql_query = "select * from `order` where sopenid='".$openid."' and receivetime is null";
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
    $apartment = $temp_result->fetch(PDO::FETCH_ASSOC)['name'];
    $extra = $row['extra'];
    $fee = $row['fee'];
    $releasetime = $row['releasetime'];
    $releasetime = $utils->convert_time($releasetime);
    if($dormitory==''){
        echo "<section class='container border'>
        <header>
            <span class='time text-left'>$releasetime </span>
            <span class='place text-right'> 公寓：$apartment</span>
        </header>
        <section class='mid'>
            <img src='".$imgpath."' class='userImg'>
            <span>快递：$express </span>
            <span> 酬金：$fee</span>
            <p>要求：$extra</p>
        </section>
        <footer>
            <div class='row'>
                <div class='col-4'></div>
                <a href='showgotorder.php?oid=".$oid."' class='btn btn-success myBtn col-4'>查看详情</a>
                <div class='col-4'></div>
            </div>

        </footer>
    </section>"; 
    }else{
        // $floor = substr($dormitory, 0,1);
        echo "<section class='container border'>
        <header>
            <span class='time text-left'>$releasetime </span>
            <span class='place text-right'> 公寓：$apartment</span>
        </header>
        <section class='mid'>
            <img src='".$imgpath."' class='userImg'>
            <span>快递：$express </span>
            <span>寝室号：$dormitory </span>
            <span> 酬金：$fee</span>
            <p>要求：$extra</p>
        </section>
        <footer>
            <div class='row'>
                <div class='col-4'></div>
                <a href='showgotorder.php?oid=".$oid."' class='btn btn-success myBtn col-4'>查看详情</a>
                <div class='col-4'></div>
            </div>

        </footer>
    </section>"; 
    }
    
}
?>


</body>
</html>