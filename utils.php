<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title></title>
</head>
<body>
<?php

class Utils{
	//公众号的信息
	const APPID= 'wx8c779eed17997e6d';
	const APP_SECRET = '0b00d91cf8f37b0b132e1eb256c9348f';
	//将时间戳转化为普通格式
	function convert_time($time){
		return date("Y年m月d日H:i:s",$time);
		// return date("Y-m-d H:i:s",$time);
	}
	function convert_time_nyr($time){
		return date("Y年m月d日",$time);
		// return date("Y-m-d H:i:s",$time);
	}
	//通过此方法来获取与云数据库的连接
	function get_db_conn(){
		$dbname = 'mb';
		$host = 'localhost';
	//	$port = 3306;
		$user = 'root';//用户AK
		$pwd = 'root';//用户SK
		try{
		    $dbconn = new PDO("mysql:host=$host;dbname=$dbname",$user,$pwd,array(PDO::MYSQL_ATTR_INIT_COMMAND => "set names utf8"));
		} catch(PDOException $e){
		    echo "Connection error message:".$e->getMessage();
		}
		//mysql_query('set names utf8', $dbconn);
		return $dbconn;
		
	}
	//通过此方法发送当用户订单被接单时的通知
	function send_module_message($token,$data){
		$url = 'https://api.weixin.qq.com/cgi-bin/message/template/send?access_token='.$token;
		$message = $this->post($url,$data);
	}
	/*	
	//通过snsapi_userinfo授权方式获取用户票据和openid
	function get_access_token($code){
		$url  = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=".self::APPID."&secret=".self::APP_SECRET."&code=".$code."&grant_type=authorization_code";
		$output = $this->get($url);
		return $output;
	}
	//使用用户票据和openid来获取用户信息
	function get_userinfo($access_token,$openid){
		$url = 'https://api.weixin.qq.com/sns/userinfo?access_token='.$access_token.'&openid='.$openid.'&lang=zh_CN';
		$output = $this->get($url);
		// file_put_contents('user.txt',$output);
		return $output;
		
	}
	*/
	//通过用户的openid来获取用户信息
	function get_userinfo_by_openid($token,$openid){
		$url = 'https://api.weixin.qq.com/cgi-bin/user/info?access_token='.$token.'&openid='.$openid.'&lang=zh_CN';
		$output = $this->get($url);
		return $output;
	}

	function get_openid($code){
		$url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=".self::APPID."&secret=".self::APP_SECRET."&code=".$code."&grant_type=authorization_code ";
		$output = $this->get($url);
		return $output;
	}
	function post($url,$data){
		$ch = curl_init();
		curl_setopt($ch,CURLOPT_URL,$url);
		curl_setopt($ch,CURLOPT_POST,1);
		curl_setopt($ch,CURLOPT_POSTFIELDS,$data);
		curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,0);
		curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,0);
		curl_setopt($ch,CURLOPT_HEADER,0);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
		$output = curl_exec($ch);
		curl_close($ch);
		return $output;
	}

	function get($url){
		$ch = curl_init();
		curl_setopt($ch,CURLOPT_URL,$url);
		curl_setopt($ch,CURLOPT_HEADER,0);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
		$output = curl_exec($ch);
		curl_close($ch);
		return $output;
	}
}?>
</body>
</html>
