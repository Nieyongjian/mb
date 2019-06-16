<!DOCTYPE html>
<html>
<head>
    <title>确认收货详情页</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1,user-scalable=no">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/register.css">
    <script src="js/jquery.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <style>
        .myBtn{
            background-color: #009688;
            border-color: #009688;
        }
    </style>
</head>
<body style="margin-top:0;">
<header>
    <h3>确认收货</h3>
</header>

<?php
include 'utils.php';
$utils =  new Utils;
$dbconn = $utils->get_db_conn();

session_start();
if(isset($_SESSION['openid'])){
    $openid = $_SESSION['openid'];
}else{
    echo "openid未获取到";
    exit;
}
if(isset($_GET['oid'])){
    $oid = $_GET['oid'];
}else{
    echo "未得到oid";
    exit;
}

$sql_query = "UPDATE `orders` SET receivetime='".time()."' where  gottime is not null and sopenid is not null and oid = $oid";
if($dbconn->exec($sql_query)){
    
}else{
    echo "订单验收失败";
    exit;
}
$sql_query = "select * from `orders` where oid = $oid and gottime is not null";
$result = $dbconn->query($sql_query);
foreach ($result as $row) {
    $fee =  $row['fee'];
    $sopenid = $row['sopenid'];
}
if(isset($fee)){
    $sql_query = "INSERT INTO `bill` VALUES('".$sopenid."','".$fee."','".time()."')";
    if($dbconn->exec($sql_query)){
        echo "<!-- 模态框 -->
				<div class='modal fade show' style='display: block;top:30%'>
				    <div class='modal-dialog'>
				        <div class='modal-content'>

				            <!-- 模态框头部 -->
				            <div class='modal-header bg-light text-dark' style='display: block;'>
				                <h4 class='text-success text-center' >收货成功</h4>
				            </div>

				            <!-- 模态框底部 -->
				            <div class='modal-body'>
				                <a href='index.php' class='btn btn-info myBtn' style='margin-left: 20px'>返回首页</a>
				                <a href='myorders.php' class='btn btn-info float-right myBtn' style='margin-right: 20px'>我的发布</a>
				            </div>

				        </div>
				    </div>
				</div>
				";
    }else{
        echo "流水账记录失败";
        exit();
    }
}else{
    echo "酬金未获取到";
}

?>




</body>
</html>