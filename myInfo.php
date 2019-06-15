<!DOCTYPE html>
<html>
<head>
    <title>个人主页</title>
    <meta charset="utf-8">
    <meta content="width=device-width,initial-scale=1.0,maximum-scale=1.0,user-scalable=0" name="viewport"/>
    <meta content="yes" name="apple-mobile-web-app-capable"/>
    <meta content="black" name="apple-mobile-web-app-status-bar-style"/>
    <meta content="telephone=no" name="format-detection"/>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link href="css/case.css" rel="stylesheet">
    <link href="css/list.css" rel="stylesheet">
    <link href="bs/bootstrap.css" rel="stylesheet">
    <link href="css/my.css" rel="stylesheet" type="text/css"/>
    <style type="text/css">

    a:link,
    a:hover,
    a:active,
    a:visited{
      text-decoration: none;
      color: #000;
    }
    a:{
  -webkit-tap-heighlight-color: transparent;
    }
    </style>
    <script src="js/jquery.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script>
        $(window).ready( function() {
            $("#status").fadeOut();
            $("#preloader").delay(350).fadeOut("slow");
        });

    </script>
    <script>
        (function(){
            var html=document.documentElement;
            var hWidth=html.getBoundingClientRect().width;
            html.style.fontSize=hWidth/15+"px ";//1rem=50px
        })();
    </script>

</head>
<body style="margin-bottom: 3.2rem">
<div id="preloader">
    <div id="status">
        <p class="center-text"><span>拼命加载中···</span></p>
    </div>
</div>



<?php
    include "utils.php";
    $utils = new Utils;
    session_start();
    $headimgurl = $_SESSION['headimgurl'];
    $nickname = $_SESSION['nickname'];
    $subscribe_time = $_SESSION['subscribe_time'];
    $subscribe_time = $utils->convert_time_nyr($subscribe_time);
    if(isset($_SESSION['openid'])){
        $openid = $_SESSION['openid'];
    }else{
        echo "没有得到openID，请重试";
        exit;
    }
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
        }
    }

?>

<section class="aui-flexView">
            <section class="aui-scrollView">
                <div class="aui-flex-box">
                    <div class="aui-flex-box-hd">
                        <img src="<?php echo $headimgurl;?>" alt="">
                    </div>
                    <div class="aui-flex-box-bd"><?php echo $nickname;?>
                    </div>
                    <!-- <div class="aui-flex-box-fr">实名认证</div> -->
                </div>
                <div class="aui-flex-box">
                    <div class="aui-flex-box-bd">
                        <h2>
                            总资产(元) 
                        </h2>
                        <h3>
                        <?php 
                        if($total)
                            echo "$total";
                        else
                            echo "0.0";
                        ?>
                        </h3>
                    </div>
                   
                </div>
                
                <div class="divHeight"></div>
                <div class="aui-icon-box">
                    <a class="aui-flex-box" href="order.php">
                        <div class="aui-flex-box-hd">
                            <img src="images/fabudd.png" alt="">
                        </div>
                        <div class="aui-flex-box-bd">发布订单
                        </div>
                        <div class="aui-flex-box-fr"></div> 
                    </a>
                    <div class="divHeight"></div>
                    
                    <a class="aui-flex-box" href="gotorders.php">
                        <div class="aui-flex-box-hd">
                            <img src="images/wdqiangdan.png" alt="">
                        </div>
                        <div class="aui-flex-box-bd">我的抢单
                        </div>
                        <div class="aui-flex-box-fr"></div>
                    </a>
                    <a class="aui-flex-box" href="myorders.php">
                            <div class="aui-flex-box-hd">
                                <img src="images/wdfabu.png" alt="">
                            </div>
                            <div class="aui-flex-box-bd">我的发布
                            </div>
                            <div class="aui-flex-box-fr"></div>
                        </a>
                    
                    <div class="divHeight"></div>
                    <a class="aui-flex-box" href="tixian.html">
                            <div class="aui-flex-box-hd">
                                <img src="images/tx.png" alt="">
                            </div>
                            <div class="aui-flex-box-bd">提现
                            </div>
                            <div class="aui-flex-box-fr"></div>
                    </a>
                    <div class="divHeight"></div>
                    <a class="aui-flex-box" href="about.html">
                        <div class="aui-flex-box-hd">
                            <img src="images/gywm.png" alt="">
                        </div>
                        <div class="aui-flex-box-bd">关于我们
                        </div>
                        <div class="aui-flex-box-fr"></div>
                    </a>
                   
                    
                    <div class="divHeight"></div>
                </div>
            </section>
            
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