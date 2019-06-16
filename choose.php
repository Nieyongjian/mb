<!DOCTYPE html>
<html>
<head>
    <title>选单结果</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, user-scalable=no">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link href="css/register.css" rel="stylesheet">
    <link href="bs/bootstrap.css" rel="stylesheet">
    <link href="css/list.css" rel="stylesheet">
    <script src="js/jquery.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>

</head>
<style>

</style>
<body style="margin-top:0;">
<header>
    <h3>选单结果</h3>
</header>
<?php
include 'utils.php';
include 'weixin/token.php';
$utils =  new Utils;
session_start();
if(isset($_SESSION['openid'])){
	$openid = $_SESSION['openid'];
}else{
	echo "没有得到openID，请重试";
	exit;
}
if(isset($_GET['oid'])){
	$oid = $_GET['oid'];
}

if(isset($openid) && isset($oid)){
	$dbconn = $utils->get_db_conn();
	$sql_query = "select * from `user` where openid='".$openid."'";
	$result = $dbconn->query($sql_query);
	$rownum = $result->rowCount();
	if($rownum == 1 ){
		$sql_query = "update `orders` set sopenid = '".$openid."' , gottime='".time()."' where oid='".$oid."' and sopenid is null";
		if($dbconn->exec($sql_query)){
			echo "<div class='modal fade show'  style='display: block;top:30%'>
				    <div class='modal-dialog'>
				        <div class='modal-content'>

				            <!-- 模态框头部 -->
				            <div class='modal-header bg-light text-dark' style='display: block;'>
				                <h4 class='text-success text-center' >
				                    <span class='glyphicon glyphicon-ok' style='font-size: 18px;color:#28a745;'> </span> 选单成功</h4>
				            </div>

				            <!-- 模态框底部 -->
				            <div class='modal-body'>
				                <a href='index.php' class='btn btn-info myBtn' style='margin-left: 20px'>返回首页</a>
				                <a href='gotorders.php' class='btn btn-info float-right myBtn' style='margin-right: 20px'>我的抢单</a>
				            </div>

				        </div>
				    </div>
				</div>";
				//获取接单人相关信息，用于模板消息
				foreach ($result as $row) {
					$sname = $row['sname'];
					$sno = $row['sno'];
				}
				//通过订单号获取订单发送者的信息
				$sql_query = "select * from `orders` where oid=".$oid;
				$result = $dbconn->query($sql_query);
				foreach ($result as $row) {
					$touser = $row['openid'];
				}
				//通过快递编号获取快递公司名称
				$sql = "select * from `express` where eid = $express";
			    $temp_result = $dbconn->query($sql);
			    foreach ($temp_result as $row1) {
			         $express = $row1['name'];
			    }
			    //获取access_token
				$token = token();
				//构造模板消息内容
				$data = array(
					'touser'=>$touser,
					'template_id'=>'cFVUsZFqnsyM3v1pRwP3F4gssXHZXfJWkrAfBoTVYzQ',
					'url'=>'http://cc.k8ff.cn/myInfo.php',
					'data'=>array(
						'express' => array('value' => $express),
						'name' => array('value' => $sname),
						'sno' => array('value' => $sno)
					 )
				);
				$data = json_encode($data,JSON_UNESCAPED_UNICODE);
				$utils->send_module_message($token,$data);
				
		}else{
			echo "<div class='modal fade show'  style='display: block;top:30%'>
			    <div class='modal-dialog'>
			        <div class='modal-content'>

			            <!-- 模态框头部 -->
			            <div class='modal-header bg-light text-dark' style='display: block;'>
			                <h4 class= 'text-danger text-center'>
			                    <span class='glyphicon glyphicon-remove text-danger' style='font-size: 18px;'> </span> 选单失败</h4>
			            </div>
			            <!-- 模态框主体 -->
			            <div class='modal-body'>
			                <h3 class='text-warning center-text'>手慢了！此订单已被抢走</h3>
			            </div>
			            <!-- 模态框底部 -->
			            <div class='modal-body'>
			                <a href='index.php' class='btn btn-warning myBtn' style='margin-left:35%;color:white;'>返回首页</a>

			            </div>

			        </div>
			    </div>
			</div>";
		}
	}else{
		echo "<div class='modal fade show'  style='display: block;top:30%'>
			    <div class='modal-dialog'>
			        <div class='modal-content'>

			            <!-- 模态框头部 -->
			            <div class='modal-header bg-light text-dark' style='display: block;'>
			                <h4 class= 'text-danger text-center'>
			                    <span class='glyphicon glyphicon-remove text-danger' style='font-size: 18px;'> </span> 选单失败</h4>
			            </div>
			            <!-- 模态框主体 -->
			            <div class='modal-body'>
			                <h3 class='text-warning center-text'>您还未注册，请先注册！</h3>
			            </div>
			            <!-- 模态框底部 -->
			            <div class='modal-body'>
			                <a href='register.php' class='btn btn-warning myBtn' style='margin-left:35%;color:white;'>前往注册</a>

			            </div>

			        </div>
			    </div>
			</div>";
	}
}
?>


</body>
</html>