<?php
define("APP_ID", 'wx8c779eed17997e6d');//测试号
define("APP_SECRET", '0b00d91cf8f37b0b132e1eb256c9348f');
// define("APP_ID", 'wxa420167558521c0d');//erp微信订阅号
// define("APP_SECRET", '854d1e95b66b8fb9a0c8966a8819c18c');

/**
 * 通过文件来存储token值
 * 两个小时以内获取token直接返回文件中存储的值
 * 两个小时以外获取token值就重新获取和存储。
 */
function token(){
    $redis = redis_conn();
    $result = $redis->ttl('access_token');
    if($result == -2){
        //已经过期
        //重新获取
         $token = get_token();
         $redis->set('access_token',$token);
         $redis->expire('access_token',7200);
        
    }else{
        //没有过期
        $token = $redis->get('access_token');
       
    }
    $redis->close();
    return $token;
}

function redis_conn(){
    $ip = "127.0.0.1";
    $port = 6379;
    $redis = new Redis();
    $redis->pconnect($ip, $port, 1);
    return $redis;
}



//从微信接口中获取到access_token
function get_token()
{
    $ch = curl_init();
    $url = 'https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid='.APP_ID.'&secret='.APP_SECRET;
    curl_setopt($ch, CURLOPT_URL, $url);
    //将 curl_exec() 获取的信息以文件流的形式返回，而不是直接输出。 
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    //启用时会将头文件的信息作为数据流输出。 
    curl_setopt($ch, CURLOPT_HEADER, 0);
    $output = curl_exec($ch);
    curl_close($ch);
    $json = json_decode($output,true);
    $token = $json['access_token'];
    return $token;
}
?>
