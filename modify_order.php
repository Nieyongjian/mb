<!DOCTYPE html>
<html>
<head>
    <title>订单修改结果页</title>
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
<body>
<header>
    <h3>修改结果</h3>
</header>
<?php
include 'utils.php';
if(isset($_GET['oid'])){
    $oid = $_GET['oid'];
}else{
	exit;
}
if(isset($_POST['name'])){
    $name = $_POST['name'];
}
if(isset($_POST['number'])){
    $number = $_POST['number'];
}
if(isset($_POST['express'])){
    $express = $_POST['express'];
}
if(isset($_POST['apartment'])){
    $apartment = $_POST['apartment'];
}
if(isset($_POST['message'])){
    $message = $_POST['message'];
}
if(isset($_POST['dormitory'])){
    $dormitory = $_POST['dormitory'];
}
if(isset($_POST['extra'])){
    $extra = $_POST['extra'];
}
if(isset($_POST['fee'])){
    $fee = $_POST['fee'];
}
session_start();
if(isset($_SESSION['openid'])){
    $openid = $_SESSION['openid'];
}

$utils =  new Utils;
$dbconn = $utils->get_db_conn();
// $sql_query = "INSERT INTO `order`(name,number,express,apartment,message,extra,fee) VALUES('".$name."','".$number."','".$express."','".$apartment."','".$message."','".$extra."','".$fee."')";
// if($dbconn->exec($sql_query)){
//  echo "a new record has been inserted.";
// }
$sql_query = "UPDATE `order` SET name=:name,number=:number,express=:express,apartment=:apartment,dormitory=:dormitory,message=:message,extra=:extra,fee=:fee WHERE oid=:oid and openid=:openid";
$prepare_conn = $dbconn->prepare($sql_query);
if($prepare_conn->execute(array(
    ':name'=>$name,
    ':number'=>$number,
    ':express'=>$express,
    ':apartment'=>$apartment,
    ':dormitory'=>$dormitory,
    ':message'=>$message,
    ':extra'=>$extra,
    ':fee'=>$fee,
    ':oid'=>$oid,
    ':openid'=>$openid
    ))){
    echo "<!-- 模态框 -->
        <div class='modal fade show'  style='display: block;top:30%'>
            <div class='modal-dialog'>
                <div class='modal-content'>

                    <!-- 模态框头部 -->
                    <div class='modal-header bg-light text-dark' style='display: block;'>
                        <h4 class= 'text-success text-center' >订单修改成功</h4>
                    </div>

                    <!-- 模态框底部 -->
                    <div class='modal-body'>
                        <a href='index.php' class='btn btn-info myBtn' style='margin-left: 20px'>返回首页</a>
                        <a href='myorders.php' class='btn btn-info float-right myBtn' style='margin-right: 20px'>我的发布</a>
                    </div>

                </div>
            </div>
        </div>";
}
?>
</body>
</html>