<!DOCTYPE html>
<html>
<head>
    <title>个人主页</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, user-scalable=no">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link href="css/case.css" rel="stylesheet">
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
    <script>
        $(window).ready( function() {
            $("#status").fadeOut();
            $("#preloader").delay(350).fadeOut("slow");
        });

    </script>


</head>
<body>
<div id="preloader">
    <div id="status">
        <p class="center-text"><span>拼命加载中···</span></p>
    </div>
</div>
<div class="d-flex fixed-top">
    <h3>个人中心</h3>
</div>
<header class="header">

<?php
include "utils.php";
$utils = new Utils;
session_start();
$headimgurl = $_SESSION['headimgurl'];
$nickname = $_SESSION['nickname'];
$subscribe_time = $_SESSION['subscribe_time'];
$subscribe_time = $utils->convert_time_nyr($subscribe_time);
?>
    <section class="info">
        <div class="headerImg"><img src=<?php echo "$headimgurl"; ?>></div>
        <div class="userName">
            <span class="glyphicon glyphicon-user" style="color:white;"></span>
            <span>
                <?php echo "$nickname"; ?>
            </span>
        </div>
        <p class="regTime">注册时间：<?php echo "$subscribe_time"; ?></p>
    </section>
</header>



    <section class="menu">
        <a href="order.php" class="item">
            <i class="glyphicon glyphicon-comment" style="color:#8BC34A;">&nbsp;</i>
            <span>发布任务</span>
        </a>
        <a href="myorders.php" class="item">
            <i class="glyphicon glyphicon-open" style="color:#007bff;">&nbsp;</i>
            <span>我的发布</span>
        </a>
        <a href="gotorders.php" class="item">
            <i class="glyphicon glyphicon-import" style="color:orange;">&nbsp;</i>
            <span>我的抢单</span>
        </a>


    </section>
<section class="menu2">

    <a href="#" class="item">
        <i class="glyphicon glyphicon-cog" style="color:#007aff;">&nbsp;</i>
        <span>设置</span>
    </a>
    <a href="#" class="item">
        <i class="glyphicon glyphicon-knight" style="color:yellow;">&nbsp;</i>
        <span>关于我们</span>
    </a>
    <a href="#" class="item">
        <i class="glyphicon glyphicon-inbox" style="color:#6641e2;">&nbsp;</i>
        <span>常用地址</span>
    </a>
    <a href="my.php" class="item">
        <i class="glyphicon glyphicon-piggy-bank" style="color:#1e88e5;">&nbsp;</i>
        <span>个人账户</span>
    </a>
</section>
    <!--<h3 class="title">安全设置</h3>-->
    <!--<section class="safe">-->
        <!--<a href="" class="item">-->
            <!--<i class="glyphicon glyphicon-book" style="color:#01847f;">&nbsp;</i>-->
            <!--<span>修改密码</span>-->
        <!--</a>-->
        <!--<a href="" class="item">-->
            <!--<i class="glyphicon glyphicon-book" style="color:#01847f;">&nbsp;</i>-->
            <!--<span>修改密码</span>-->
        <!--</a>-->
        <!--<a href="" class="item">-->
            <!--<i class="emile">&nbsp;</i>-->
            <!--<span>修改绑定邮箱</span>-->
        <!--</a>-->
    <!--</section>-->


<div class="d-flex fixed-bottom myFix">
    <a href="index.php" class="flex-fill">
        <i class="glyphicon glyphicon-home"></i>
        <span>首页</span>
    </a>

    <a href="#" class="flex-fill my">
        <i class="glyphicon glyphicon-user"></i>
        <span>我的</span>
    </a>
</div>
</body>
</html>