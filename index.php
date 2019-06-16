<!DOCTYPE html>
<html>
<head>
    <title>抢单页</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, user-scalable=no">
    <link rel="stylesheet" href="css/bootstrap.min.css">

    <link href="css/list.css" rel="stylesheet">
    <link href="bs/bootstrap.css" rel="stylesheet">

    <script src="js/jquery.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script>
        $(window).ready( function() {
            $("#status").fadeOut();
            $("#preloader").delay(350).fadeOut("slow");
        });

    </script>
    <!--<script type="text/javascript">-->
        <!--var ua = navigator.userAgent.toLowerCase();-->
        <!--var isWeixin = ua.indexOf('micromessenger') != -1;-->
        <!--var isAndroid = ua.indexOf('android') != -1;-->
        <!--var isIos = (ua.indexOf('iphone') != -1) || (ua.indexOf('ipad') != -1);-->
        <!--if (!isWeixin) {-->
            <!--document.head.innerHTML = '<title>抱歉，出错了</title><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=0"><link rel="stylesheet" type="text/css" href="https://res.wx.qq.com/open/libs/weui/0.4.1/weui.css">';-->
            <!--document.body.innerHTML = '<div class="weui_msg"><div class="weui_icon_area"><i class="weui_icon_info weui_icon_msg"></i></div><div class="weui_text_area"><h4 class="weui_msg_title">请在微信客户端打开链接</h4></div></div>';-->
        <!--}-->
    <!--</script>-->
    <script>
        (function(){
            var html=document.documentElement;
            var hWidth=html.getBoundingClientRect().width;
            html.style.fontSize=hWidth/15+"px ";//1rem=50px
        })();
    </script>


    <style>

    </style>
</head>
<body>
<div id="preloader">
    <div id="status">
        <p class="center-text"><span>拼命加载中···</span></p>
    </div>
</div>
<div class="d-flex fixed-top">
    <h3>校园马帮</h3>
</div>

<div id="demo" class="carousel slide" data-ride="carousel">

    <!-- 指示符 -->
    <ul class="carousel-indicators">
        <li data-target="#demo" data-slide-to="0" class="active"></li>
        <li data-target="#demo" data-slide-to="1"></li>
        <li data-target="#demo" data-slide-to="2"></li>
    </ul>

    <!-- 轮播图片 -->
    <div class="carousel-inner">
        <div class="carousel-item active">
            <img src="http://static.runoob.com/images/mix/img_fjords_wide.jpg">
            <!--<div class="carousel-caption">-->
                <!--<h3>校园马帮</h3>-->
                <!--<p>看，马帮来啦</p>-->
            <!--</div>-->
        </div>
        <div class="carousel-item">
            <img src="http://static.runoob.com/images/mix/img_nature_wide.jpg">
            <!--<div class="carousel-caption">-->
                <!--<h3>第二张图片描述标题</h3>-->
                <!--<p>描述文字!</p>-->
            <!--</div>-->
        </div>
        <div class="carousel-item">
            <img src="http://static.runoob.com/images/mix/img_mountains_wide.jpg">
            <!--<div class="carousel-caption">-->
                <!--<h3>第三张图片描述标题</h3>-->
                <!--<p>描述文字!</p>-->
            <!--</div>-->
        </div>
    </div>

    <!-- 左右切换按钮 -->
    <a class="carousel-control-prev" href="#demo" data-slide="prev">
        <span class="carousel-control-prev-icon"></span>
    </a>
    <a class="carousel-control-next" href="#demo" data-slide="next">
        <span class="carousel-control-next-icon"></span>
    </a>

</div>


<div class="title">
    <h3><span class="glyphicon glyphicon-tags"> </span> 最新订单</h3>
    
</div>


<?php
include 'utils.php';
include 'weixin/token.php';
// include 'clearsession.php';
 session_start();
$utils = new Utils;
if(isset($_GET['code'])){
    $code =  $_GET['code'];
}
$access_token = token();
//微信端通过以snsapi_base为scope发起的网页授权获取到code，然后用code换取openid
if($code){
    if(!isset($_SESSION['mbtime'])){
        //通过user_info方式获取用户信息
            // $output = $utils->get_access_token($code);
            // $data = json_decode($output,true);
            // $access_token = $data['access_token'];
            // $openid = $data['openid'];
            // //将用户票据和openid存储到session中
            // $_SESSION['access_token'] = $access_token;
            // $_SESSION['openid'] = $openid;
            // //根据用户票据和openid得到用户的信息
            // $output = $utils->get_userinfo($access_token,$openid);
            // $arr = json_decode($output,true);
            // $src = $arr['headimgurl'];
            // $nickname = $arr['nickname'];
            // $time = time();
            // //将头像地址、数据存储时间、以及昵称存入到session中
            // $_SESSION['src'] = $src;
            // $_SESSION['time'] = $time;
            // $_SESSION['nickname'] = $nickname;
            // 使用code换取openid
            $output = $utils->get_openid($code);
            $data = json_decode($output,true);
            $openid = $data['openid'];
            //通过access_token和openid来拉取用户信息
            $output = $utils->get_userinfo_by_openid($access_token,$openid);
            $data = json_decode($output,true);
            $nickname = $data['nickname'];
            $headimgurl = $data['headimgurl'];
            $subscribe_time = $data['subscribe_time'];
            $time = time();
            $_SESSION['openid'] = $openid;
            $_SESSION['mbtime'] = $time;
            $_SESSION['nickname'] = $nickname;
            $_SESSION['headimgurl'] = $headimgurl;
            $_SESSION['subscribe_time'] = $subscribe_time;
            echo "no session";
                echo $headimgurl;
                echo $nickname;
                exit;
    }else{
        if((($_SESSION['mbtime']+7000)-time())<0){
            //通过user_info方式获取用户信息
            // $output = $utils->get_access_token($code);
            // $data = json_decode($output,true);
            // $access_token = $data['access_token'];
            // $openid = $data['openid'];
            // //将用户票据和openid存储到session中
            // $_SESSION['access_token'] = $access_token;
            // $_SESSION['openid'] = $openid;
            // //根据用户票据和openid得到用户的信息
            // $output = $utils->get_userinfo($access_token,$openid);
            // $arr = json_decode($output,true);
            // $src = $arr['headimgurl'];
            // $nickname = $arr['nickname'];
            // $time = time();
            // //将头像地址、数据存储时间、以及昵称存入到session中
            // $_SESSION['src'] = $src;
            // $_SESSION['time'] = $time;
            // $_SESSION['nickname'] = $nickname;
            // $output = $utils->get_openid($code);
            $output = $utils->get_openid($code);
            $data = json_decode($output,true);
            $openid = $data['openid'];
            $output = $utils->get_userinfo_by_openid($access_token,$openid);
            $data = json_decode($output,true);
            $nickname = $data['nickname'];
            $headimgurl = $data['headimgurl'];
            $subscribe_time = $data['subscribe_time'];
            $time = time();
            $_SESSION['openid'] = $openid;
            $_SESSION['mbtime'] = $time;
            $_SESSION['nickname'] = $nickname;
            $_SESSION['headimgurl'] = $headimgurl;
            $_SESSION['subscribe_time'] = $subscribe_time;
            echo "you session";
                            echo $headimgurl;
                echo $nickname;
                exit;

        }
    }
}

//获取数据连接
$dbconn = $utils->get_db_conn();
//构造sql语句查询开放订单
$sql_query = 'select * from `orders` where sopenid is null';
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
    $releasetime = $row['releasetime'];
    $releasetime = $utils->convert_time($releasetime);
    $extra = $row['extra'];
    if(!$extra){
        $extra = "无额外要求";
    }
    $fee = $row['fee'];
    if($dormitory==''){
        echo "<section class='container border'>
            <header>
                <span class='time text-left'>$releasetime </span>
                <span class='place text-right'> $apartment</span>
            </header>
                <section class='mid'>
                        <img src='".$imgpath."' class='userImg'>
                            <span>快递：$express </span>
                            <span> 酬金：$fee</span>
                            <p>要求：$extra</p>
                </section>
                <footer><a href='choose.php?oid=".$oid."' class='btn btn-success myBtn'>选取此单</a></footer>
            </section>"; 
    }else{
        $floor = substr($dormitory,0,1);
        echo "<section class='container border'>
            <header>
                <span class='time text-left'>$releasetime </span>
                <span class='place text-right'> $apartment</span>
            </header>
                <section class='mid'>
                        <img src='".$imgpath."'  class='userImg'>
                            <span>快递：$express </span>
                            <span>楼层：$floor </span>
                            <span> 酬金：$fee</span>
                            <p>要求：$extra</p>
                </section>
                <footer><a href='choose.php?oid=".$oid."' class='btn btn-success myBtn'>选取此单</a></footer>
            </section>";
    }
    
}
?>
<div class="d-flex fixed-bottom myFix">
    <a href="#" class="flex-fill my">
        <i class="glyphicon glyphicon-home"></i>
        <span>首页</span>
    </a>

    <a href="myInfo.php" class="flex-fill">
        <i class="glyphicon glyphicon-user"></i>
        <span>我的</span>
    </a>
</div>
</body>
</html>
 
</ul>
</body>
</html>



