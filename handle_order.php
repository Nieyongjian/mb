<!DOCTYPE html>
<html>
<head>
    <title>订单发布结果页</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1,user-scalable=no">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/register.css">
    <link rel="stylesheet" type="text/css" href="./css/lanren.css">
    <script src="js/jquery.js"></script>
    <script type="text/javascript">
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
    echo "<div class='header'>
  <div class='all_w '>
    <div class='gofh'> <a href='#'><img src='images/jt_03.jpg' ></a> </div>
    <div class='ttwenz'>
      <h4>确认支付</h4>
      <h5>微信安全支付</h5>
    </div>
  </div>
</div>
<div class='wenx_xx'>
  <div class='mz'>校园马帮平台</div>
  <div class='wxzf_price' id='price'>￥$fee</div>
</div>
<div class='skf_xinf'>
  <div class='all_w'> <span class='bt'>收款方</span> <span class='fr'>校园马帮</span> </div>
</div>
<a href='javascript:void(0);' class='ljzf_but all_w'>立即支付</a> 

<!--浮动层-->

<div class='ftc_wzsf'>
  <div class='srzfmm_box'>
    <div class='qsrzfmm_bt clear_wl'> <img src='images/xx_03.jpg' class='tx close fl' > <img src='' class='tx fl' ><span class='fl'>请输入支付密码</span> </div>
    <div class='zfmmxx_shop'>
      <div class='mz'>校园马帮</div>
      <div class='wxzf_price'>￥$fee</div>
    </div>
    <a href='#' class='blank_yh'> <img src='images/jftc_07.jpg' class='fl'  ><span class='fl ml5'>招商银行信用卡</span> <img src='images/jftc_09.jpg' class='fr'></a>
    <ul class='mm_box'>
      <li></li>
      <li></li>
      <li></li>
      <li></li>
      <li></li>
      <li></li>
    </ul>
  </div>
  <div class='numb_box'>
    <div class='xiaq_tb'> <img src='images/jftc_14.jpg' height='10'> </div>
    <ul class='nub_ggg'>
      <li><a href='javascript:void(0);'>1</a></li>
      <li><a href='javascript:void(0);' class='zj_x'>2</a></li>
      <li><a href='javascript:void(0);'>3</a></li>
      <li><a href='javascript:void(0);'>4</a></li>
      <li><a href='javascript:void(0);' class='zj_x'>5</a></li>
      <li><a href='javascript:void(0);'>6</a></li>
      <li><a href='javascript:void(0);'>7</a></li>
      <li><a href='javascript:void(0);' class='zj_x'>8</a></li>
      <li><a href='javascript:void(0);'>9</a></li>
      <li><span></span></li>
      <li><a href='javascript:void(0);' class='zj_x'>0</a></li>
      <li><span  class='del' > <img src='images/jftc_18.jpg'   ></span></li>
    </ul>
  </div>
  <div class='hbbj'></div>
</div>";
}else{
    echo " <!-- 模态框 -->
    <div class='modal fade show'  style='display: block;top:30%'>
        <div class='modal-dialog'>
            <div class='modal-content'>

                <!-- 模态框头部 -->
                <div class='modal-header bg-light text-dark' style='display: block;'>
                    <h4 class='text-success text-center' >订单发布失败</h4>
                </div>

                <!-- 模态框底部 -->
                <div class='modal-body'>
                    <a href='index.php' class='btn btn-info myBtn' style='margin-left: 20px'>返回首页</a>
                    <a href='myorders.php' class='btn btn-info float-right myBtn' style='margin-right: 20px'>我的发布</a>
                </div>

            </div>
        </div>
    </div>";
    exit;
}
?>
</body>
    <script type="text/javascript">
    $(function(){
        //出现浮动层
        $(".ljzf_but").click(function(){
            $(".ftc_wzsf").show();
            });
        //关闭浮动
        $(".close").click(function(){
            $(".ftc_wzsf").hide();
            });
            //数字显示隐藏
            $(".xiaq_tb").click(function(){
            $(".numb_box").slideUp(500);
            });
            $(".mm_box").click(function(){
            $(".numb_box").slideDown(500);
            });
            //----
        var i = 0;
        // var price=document.getElementById('price').innerText;
        // alert(price)
            $(".nub_ggg li a").click(function(){
                i++
                if(i<6){
                    $(".mm_box li").eq(i-1).addClass("mmdd");
                    }else{
                        $(".mm_box li").eq(i-1).addClass("mmdd");
                        setTimeout(function(){
                        location.href="zhifusuccess.php?fee=<?php echo $fee ?>";
                        },500);
                        //window.document.location="cg.html"
                 }
            });
            
            $(".nub_ggg li .del").click(function(){
                
                if(i>0){
                    i--
                    $(".mm_box li").eq(i).removeClass("mmdd");
                    i==0;
                    }
                //alert(i);
                
                
                 
            });
            
     
            
         
    });
    </script>
</html>