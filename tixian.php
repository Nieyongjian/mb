<!DOCTYPE html>
<html>
<head>
<title>提现</title>
<meta charset="utf-8" />
<meta name="viewport" content="initial-scale=1.0, width=device-width, user-scalable=no" />
<link rel="stylesheet" type="text/css" href="./css/lanren.css">
<script src="./js/jquery.js"></script>
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
					location.href="tixiansuccess.php?total=<?echo $_GET['total']?>";
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
</head>
<body>
<div class="header">
  <div class="all_w ">
    <div class="gofh"> <a href="myInfo.php"><img src="images/jt_03.jpg" ></a> </div>
    <div class="ttwenz">
      <h4>确认提现</h4>
      <h5>微信安全支付</h5>
    </div>
  </div>
</div>
<?
<?php 
include 'utils.php';
session_start();
$utils =  new Utils;
$dbconn = $utils->get_db_conn();
$total = $_GET['total'];
if(isset($_SESSION['openid'])){
    $openid = $_SESSION['openid'];
}else{
    echo "openid未获取到";
    exit;
}
$sql_query = "INSERT INTO `bill` VALUES('".$openid."','-".$total."','".time()."')";
$dbconn->exec($sql_query);
?>
<div class="wenx_xx">
  <div class="mz">校园马帮平台</div>
  <div class="wxzf_price" id='price'>￥<?php echo $total;?></div>
</div>
<div class="skf_xinf">
  <div class="all_w"> <span class="bt">收款方</span> <span class="fr">校园马帮</span> </div>
</div>
<a href="javascript:void(0);" class="ljzf_but all_w">立即提现</a> 

<!--浮动层-->

<div class="ftc_wzsf">
  <div class="srzfmm_box">
    <div class="qsrzfmm_bt clear_wl"> <img src="images/xx_03.jpg" class="tx close fl" ><span class="fl">请输入支付密码</span> </div>
    <div class="zfmmxx_shop">
      <div class="mz">校园马帮</div>
      <div class="wxzf_price">￥<?php echo $total;?></div>
    </div>
    <a href="#" class="blank_yh"> <img src="images/jftc_07.jpg" class="fl"  ><span class="fl ml5">招商银行信用卡</span> <img src="images/jftc_09.jpg" class="fr"></a>
    <ul class="mm_box">
      <li></li>
      <li></li>
      <li></li>
      <li></li>
      <li></li>
      <li></li>
    </ul>
  </div>
  <div class="numb_box">
    <div class="xiaq_tb"> <img src="images/jftc_14.jpg" height="10"> </div>
    <ul class="nub_ggg">
      <li><a href="javascript:void(0);">1</a></li>
      <li><a href="javascript:void(0);" class="zj_x">2</a></li>
      <li><a href="javascript:void(0);">3</a></li>
      <li><a href="javascript:void(0);">4</a></li>
      <li><a href="javascript:void(0);" class="zj_x">5</a></li>
      <li><a href="javascript:void(0);">6</a></li>
      <li><a href="javascript:void(0);">7</a></li>
      <li><a href="javascript:void(0);" class="zj_x">8</a></li>
      <li><a href="javascript:void(0);">9</a></li>
      <li><span></span></li>
      <li><a href="javascript:void(0);" class="zj_x">0</a></li>
      <li><span  class="del" > <img src="images/jftc_18.jpg"   ></span></li>
    </ul>
  </div>
  <div class="hbbj"></div>
</div>
</body>
</html>