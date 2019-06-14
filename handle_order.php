<!DOCTYPE html>
<html>
<head>
    <title>订单发布结果页</title>
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
    <h3>发布结果</h3>
</header>
<?php
/**
 * 处理index.php表单中提交过来的数据
 */
include 'utils.php';
if(isset($_POST['name'])){
    $name = $_POST['name'];
}else{
    echo "未获取到数据";
    exit();
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
if(!isset($openid)){
    echo "抱歉，未获取到用户信息，无法进行需求发布";
    exit;
}
//获取数据连接
$utils =  new Utils;
$dbconn = $utils->get_db_conn();
//构造插入语句
$sql_query = "INSERT INTO `orders`(openid,name,number,express,apartment,dormitory,message,extra,fee,releasetime) VALUES(:openid,:name,:number,:express,:apartment,:dormitory,:message,:extra,:fee,:releasetime)";
$prepare_conn = $dbconn->prepare($sql_query);
if($prepare_conn->execute(array(
    ':openid'=>$openid,
    ':name'=>$name,
    ':number'=>$number,
    ':express'=>$express,
    ':apartment'=>$apartment,
    ':dormitory'=>$dormitory,
    ':message'=>$message,
    ':extra'=>$extra,
    ':fee'=>$fee,
    ':releasetime'=>time()
    ))){
    echo " <!-- 模态框 -->
    <div class='modal fade show'  style='display: block;top:30%'>
        <div class='modal-dialog'>
            <div class='modal-content'>

                <!-- 模态框头部 -->
                <div class='modal-header bg-light text-dark' style='display: block;'>
                    <h4 class='text-success text-center' >订单发布成功</h4>
                </div>

                <!-- 模态框底部 -->
                <div class='modal-body'>
                    <a href='index.php' class='btn btn-info myBtn' style='margin-left: 20px'>返回首页</a>
                    <a href='myorders.php' class='btn btn-info float-right myBtn' style='margin-right: 20px'>我的发布</a>
                </div>

            </div>
        </div>
    </div>";
}else{
    echo "发布失败";
    exit;
}
?>


   



</body>
</html>