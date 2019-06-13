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
    </script>
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
                	// alert($(this).val());
                    $("#d_number").show();
                }
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
<header>
    <a href="myInfo.php" class="back" rel="external">
        <span class="glyphicon glyphicon-remove"></span>
    </a>
    <h3>发布订单</h3>
</header>
<?php
include 'utils.php';
$utils =  new Utils;
$dbconn = $utils->get_db_conn();
?>
    <div data-role="main" class="ui-content">
        <form action="handle_order.php" method="post" data-ajax="false">
            <div class="ui-field-contain">
                <label >
                    <!--<span class="glyphicon glyphicon-user" style="color:red;"> </span> -->
                    收件人姓名：</label>
                <input type="text" name="name" required="required">
            </div>
            <div class="ui-field-contain">
                <label >手机号：</label>
                <!-- <input type="number" name="number" data-clear-btn="true" required="required"> -->
                <input id="telephone" type="tel" name="number" maxlength="11" data-clear-btn="true" required="required"> 
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
                            // echo "$eid";
                            echo "<option value="."$eid".">$ename</option>"; 
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
                            echo "<option value="."$aid".">$ename</option>"; 
                        }
                        ?>
                    </select>
                </fieldset>
            </div>
                <div class="ui-field-contain" id="d_number">
                    <label >寝室号：(要求规范输入如546，便于提取楼层)</label>
                    <input type="number" name="dormitory">
                </div>
                <div class="ui-field-contain">
                    <label>快递信息（直接复制短信即可）</label>
                    <textarea name="message" data-clear-btn="true" required="required"></textarea>
                </div>
                <div class="ui-field-contain">
                    <label>额外需求(指定送达的时间 地点 或者其他需求)</label>
                    <textarea name="extra"></textarea>
                </div>
                <div class="ui-field-contain">
                <label >酬金:</label>
                    <input type="number" name="fee" step="0.1" min="2.0" required="required">
                </div>
                <!-- <input type="submit" value="提交" > -->
                <button type="submit">提交</button>

           <!--  <button type="submit"><a href="handle_order.php" rel="external">提交</a></button> -->
            </form>

        </div>


    </body>
    </html>