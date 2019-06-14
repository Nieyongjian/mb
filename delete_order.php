<!DOCTYPE html>
<html>
<head>
    <title>删除订单详情</title>
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
    <h3>删除订单</h3>
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
$sql_query = "SELECT * FROM `orders` WHERE oid='".$oid."'";
// echo "$sql_query";
$result = $dbconn->query($sql_query);
//获取订单的发布时间
foreach ($result as $row) {
    $releasetime = $row['releasetime'];
}
// echo "$releasetime";
if($releasetime){
    //当期时间减去订单发布的时间大于15分钟，便可以直接删除
    if(($time = time()-$releasetime)>900){
        $sql_query = "DELETE FROM `orders` where oid='".$oid."' and openid='".$openid."' and sopenid is null";
        if($dbconn->exec($sql_query)){
            echo "<!-- 模态框 -->
            <div class='modal fade show'  style='display: block;top:30%'>
                <div class='modal-dialog'>
                    <div class='modal-content'>

                        <!-- 模态框头部 -->
                        <div class='modal-header bg-light text-dark' style='display: block;'>
                            <h4 class= 'text-success text-center' >订单删除成功</h4>
                        </div>

                        <!-- 模态框底部 -->
                        <div class='modal-body'>
                            <a href='order.php' class='btn btn-info myBtn' style='margin-left: 20px'>重新发布</a>
                            <a href='index.php' class='btn btn-info float-right myBtn' style='margin-right: 20px'>返回首页</a>
                        </div>

                    </div>
                </div>
            </div>";
        }else{
            echo "<!-- 模态框 -->
            <div class='modal fade show'  style='display: block;top:30%'>
                <div class='modal-dialog'>
                    <div class='modal-content'>

                        <!-- 模态框头部 -->
                        <div class='modal-header bg-light text-dark' style='display: block;'>
                            <h4 class= 'text-success text-center' >订单删除失败,订单已经被接收</h4>
                        </div>

                        <!-- 模态框底部 -->
                        <div class='modal-body'>
                            <a href='order.php' class='btn btn-info myBtn' style='margin-left: 20px'>重新发布</a>
                            <a href='index.php' class='btn btn-info float-right myBtn' style='margin-right: 20px'>返回首页</a>
                        </div>

                    </div>
                </div>
            </div>";
        }
    }else{
        $time = 900 - $time;
        //向上取整，获取分钟数
        $time = floor($time/60);
        echo "<!-- 模态框 -->
            <div class='modal fade show'  style='display: block;top:30%'>
                <div class='modal-dialog'>
                    <div class='modal-content'>

                        <!-- 模态框头部 -->
                        <div class='modal-header bg-light text-dark' style='display: block;'>
                            <h4 class= 'text-success text-center' >删除失败，请于 $time 分钟后删除</h4>
                        </div>

                        <!-- 模态框底部 -->
                        <div class='modal-body'>
                            <a href='myorders.php' class='btn btn-info myBtn' style='margin-left: 20px'>我的订单</a>
                            <a href='index.php' class='btn btn-info float-right myBtn' style='margin-right: 20px'>返回首页</a>
                        </div>

                    </div>
                </div>
            </div>";
    }
}

?>






</body>
</html>