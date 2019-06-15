
<!DOCTYPE html>
<html>
<head>
<title>支付成功</title>
<meta charset="utf-8" />
<meta name="viewport" content="initial-scale=1.0, width=device-width, user-scalable=no" />
<link rel="stylesheet" type="text/css" href="css/lanren.css">
<style>
  .success_btn_wrap{
    position: fixed;
    width: 100%;
    z-index: 999;
    bottom: 80px;
    text-align: center;
  }
  .success_btn{
    display: inline-block;
    width: 20%;
    padding:5px 25px;
    border-radius: 5px;
    border: 1px solid green;
    text-align: center;
    vertical-align: middle;
    color: green;
    font-size: 14px;
  }
</style>
</head>
<body >
<div class="header">
  <div class="all_w" style="position:relative; z-index:1;">
    <div class="ttwenz" style=" text-align:center; width:100%;">
      <h4>支付详情</h4>
      <h5>微信安全支付</h5>
    </div>
    <a href="index.html" class="fh_but"></a> </div>
</div>

<div class="zfcg_box ">
<div class="all_w">
<img src="images/cg_03.jpg" > 支付成功 </div>

</div>
<div class="cgzf_info">
<div class="wenx_xx">
  <div class="mz">校园马帮平台</div>
  <div class="wxzf_price">￥<?php $_GET['fee']?></div>
</div>

<div class="spxx_shop">
 <div class=" mlr_pm">
 <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td>名   称</td>
    <td align="right">校园马帮代取</td>
  </tr>
   <tr>
    <td>支付时间</td>
    <td align="right" id='time'>2015-12-16 22：41：45</td>
  </tr>
   <tr>
    <td>支付方式</td>
    <td align="right">招商银行</td>
  </tr>
   <tr>
    <td>交易单号</td>
    <td align="right">1205329821521545465665855444</td>
  </tr>
</table>

 </div>

</div>
</div>
<script>

function getNowFormatDate() {//获取当前时间
	var date = new Date();
	var seperator1 = "-";
	var seperator2 = ":";
	var month = date.getMonth() + 1<10? "0"+(date.getMonth() + 1):date.getMonth() + 1;
	var strDate = date.getDate()<10? "0" + date.getDate():date.getDate();
	var currentdate = date.getFullYear() + seperator1  + month  + seperator1  + strDate
			+ " "  + date.getHours()  + seperator2  + date.getMinutes()
			+ seperator2 + date.getSeconds();
	return currentdate;
}

document.getElementById('time').innerText=getNowFormatDate()

</script>
<div class="success_btn_wrap">
  <a class="success_btn">完成跳转到首页</a>
</div>
<div class="wzxfcgde_tb"><img src="images/cg_07.jpg" ></div>
</body>
</html>