<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>我的主页</title>
</head>
<body>
<?php
include 'utils.php';
session_start();
$utils = new Utils;
if(isset($_SESSION['openid'])){
	$openid = $_SESSION['openid'];
}else{
	echo "没有得到openID，请重试";
	exit;
}
if($openid){
	
	$dbconn = $utils->get_db_conn();
	$sql_query = "select * from `bill` where openid='".$openid."'";
	$result = $dbconn->query($sql_query);
	$rownum = $result->rowCount();
	if($rownum>=1){
		$sql_query = "select openid,sum(amount) total from `bill` where openid = '".$openid."'";
		$result = $dbconn->query($sql_query);
		foreach ($result as $row) {
			$openid = $row['openid'];
			$total = $row['total'];
			echo "<br>我的余额：$total";
		}
	}
}
?>
</body>
</html>