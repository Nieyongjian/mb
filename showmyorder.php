<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="css/jquery.mobile-1.4.5.min.css">
    <link href="bs/bootstrap.css" rel="stylesheet">
    <link href="css/register.css" rel="stylesheet">
    <script src="js/jquery.min.js"></script>
    <script src="js/jquery.mobile-1.4.5.min.js"></script>
        <script>
        $(function(){
				if($("#place").val()==1){
                    $("#d_number").hide();
                				}		
            //给delect添加change事件
            $("#place").change(function(){
                if($(this).val()==1){
                    $("#d_number").hide();
                }else{
                    $("#d_number").show();
                }
            })
        })
    </script>
    <script>
        $(function () {
            $('#submit').hide();
            $('input,select,textarea',$('form[name="my_form"]')).prop('disabled',true);
            $("#update").on("tap",function(){
                $(this).hide();
                $('#submit').show();
                $('.ui-btn-icon-right:after').css('background-color','rgba(6, 165, 52, 0.65)');
                $('input,select,textarea',$('form[name="my_form"]')).prop('disabled',false);
                // $('input,select,textarea',$('form[name="my_form"]')).attr('readonly',false);
                $("#title").text("修改信息");

            });

            $(function () {
                // 验证手机号
                function isPhoneNo(phone) {
                    var pattern = /^1[34578]\d{9}$/;
                    return pattern.test(phone);
                }
                /*手机号判断*/
                function userTel(inputid, spanid) {
                    $(inputid).blur(function() {
                        if ($.trim($(inputid).val()).length == 0) {
                            $(spanid).html("× 手机号没有输入").css('color','red');
                        } else {
                            if (isPhoneNo($.trim($(inputid).val())) == false) {
                                $(spanid).html("× 手机号码不正确").css('color','red');
                            }
                        }
                        $(inputid).focus(function() {
                            $(spanid).html("");
                        });
                    });
                }
                userTel('#telephone', "#checkExistPhone");

            })
        })
    </script>
    <style>
        .ui-btn-icon-right:after {
            background-color: #666;
            background-color: rgba(6, 165, 52, 0.65);}
    </style>
</head>
<body>
<?php
include 'utils.php';
if(isset($_GET['oid'])){
	$oid = $_GET['oid'];
}else{
	echo "未获取到订单id";
	exit;
}

$utils =  new Utils;
$dbconn = $utils->get_db_conn();
session_start();
if(isset($_SESSION['openid'])){
	$openid = $_SESSION['openid'];
}else{
	echo "未获取到openid";
	exit;
}

$sql_query = "select * from `orders` where openid='".$openid."' and oid ='".$oid."'";
$result = $dbconn->query($sql_query);
foreach ($result as $row) {
	// $oid = $row['oid'];
	$name = $row['name'];
	$number = $row['number'];
	$express = $row['express'];
	$apartment = $row['apartment'];
	$dormitory = $row['dormitory'];
	$message = $row['message'];
	$extra = $row['extra'];
	$fee = $row['fee'];
	// // echo "订单信息获取成功";
	// // echo "订单信息获取成功";
 //    //通过编号获取快递公司名称
 //    $sql = "select * from `express` where eid = $express";
 //    $temp_result = $dbconn->query($sql);
 //    $express_name = $temp_result->fetch(PDO::FETCH_ASSOC)['name'];
 //    //通过编号获取公寓名称
 //    $sql = "select * from `apartment` where aid = $apartment";
 //    $temp_result = $dbconn->query($sql);
 //    $apartment_name = $temp_result->fetch(PDO::FETCH_ASSOC)['name'];
}
?>
<div data-role="page">
    <header>
        <a href="myorders.php" class="back" rel="external">
            <span class="glyphicon glyphicon-chevron-left"></span>
        </a>
        <h3>订单详情详情</h3>
        <a href="#" class="update" id="update">
            <span class="glyphicon glyphicon glyphicon-edit"> </span> <span class="btn btn-primary">修改</span>
        </a>
    </header>
    <div data-role="main" class="ui-content">
     		<form data-ajax="false" action="modify_order.php?oid=<?php echo "$oid"?>" name="my_form" method="post">
            <div class="ui-field-contain">
                <label>
                    <!--<span class="glyphicon glyphicon-user" style="color:red;"> </span> -->
                    收件人姓名：</label>
                <input type="text" name="name" value=<?php echo "$name";?>>
            </div>
            <div class="ui-field-contain">
                <label >手机号：</label>
                <input id="telephone" type="tel" name="number" maxlength="11" data-clear-btn="true" value=<?php echo "$number";?>>
                <span  id="checkExistPhone"></span>
            </div>
            <div class="ui-field-contain">
                <fieldset data-role="fieldcontain">
                    <label>快递公司:</label>
                    <select name="express">
                      <?php 
                        $sql_query = 'select * from express';
                        $result = $dbconn->query($sql_query);
                        foreach ($result as $row) {
                            $eid = $row['eid'];
                            $ename = $row['name'];
                            if($eid==$express){
                                echo "<option value="."$eid"." selected='selected'>$ename</option>";  
                            }else{
                                echo "<option value="."$eid".">$ename</option>"; 
                                
                                
                            }
                        }
                        ?>
                    </select>
                </fieldset>
            </div>
            <div class="ui-field-contain">
                <fieldset data-role="fieldcontain">
                    <label>所在公寓（送达地点不在公寓选择其他即可）</label>
                    <select name="apartment" id="place">
                    <?php 
                    $sql_query = 'select * from apartment';
                    $result = $dbconn->query($sql_query);
                    foreach ($result as $row) {
                        $aid = $row['aid'];
                        $ename = $row['name'];
                        // echo "$eid";
                        if($aid==$apartment){
                            echo "<option value="."$aid"." selected='selected'>$ename</option>"; 
                        }else{
                            echo "<option value="."$aid".">$ename</option>"; 
                        }
                    }
                    ?>
                  </select>
                </fieldset>
            </div>
            <div class="ui-field-contain" id="d_number"> 
                <label >寝室号：(要求规范输入如546，便于提取楼层)</label>
                <input type="number" name="dormitory" value=<?php echo "$dormitory";?> >
            </div>
            <div class="ui-field-contain">
                <label>快递信息（直接复制短信即可）</label>
                <textarea name="message" id='message'></textarea>
            </div>
            <div class="ui-field-contain">
                <label>额外需求(指定送达的时间 地点 或者其他需求)</label>
                <textarea name="extra" id='extra'></textarea>
            </div>
            <script type="text/javascript">
				document.getElementById('message').value="<?php echo "$message";?>";
				document.getElementById('extra').value="<?php echo "$extra";?>";
			</script>
            <div class="ui-field-contain">
                <label >酬金:</label>
                <input type="number" name="fee" step="0.1" min=<?php echo "$fee";?>  value=<?php echo "$fee";?>>
            </div>
			<button type="submit" id="submit">提交</button>
            <!-- <a href='modify.php?oid=<?php echo "$oid"?>' rel="external">修改</a> -->
            </form>
    </div>
</div>

</body>
</html>