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

</head>
<body>
<header>
    <a href="" onclick="history.go(-1);" class="back">
        <span class="glyphicon glyphicon-chevron-left"></span>
    </a>
    <h3>订单详情</h3>
</header>
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

$sql_query = "select * from `orders` where sopenid='".$openid."' and oid ='".$oid."'";
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
    // echo "订单信息获取成功";
    //通过编号获取快递公司名称
    $sql = "select * from `express` where eid = $express";
    $temp_result = $dbconn->query($sql);
    $express = $temp_result->fetch(PDO::FETCH_ASSOC)['name'];
    //通过编号获取公寓名称
    $sql = "select * from `apartment` where aid = $apartment";
    $temp_result = $dbconn->query($sql);
    $apartment = $temp_result->fetch(PDO::FETCH_ASSOC)['name'];
}
?>

    <div data-role="main" class="ui-content">
        <form method="post" action="">
            <div class="ui-field-contain">
                <label >
                    <!--<span class="glyphicon glyphicon-user" style="color:red;"> </span> -->
                    收件人姓名：</label>
                <input type="text" name="name" readonly value=<?php echo "$name";?>>
            </div>
            <div class="ui-field-contain">
                <label >手机号：</label>
                <input type="tel" name="number" readonly value=<?php echo "$number";?>>
            </div>
            <div class="ui-field-contain">
                <fieldset data-role="fieldcontain" >
                    <label>快递公司:</label>
                    <input type="text" name="express" value=<?php echo "$express";?> readonly="readonly">
                </fieldset>
            </div>
            <div class="ui-field-contain" >
                <fieldset data-role="fieldcontain">
                    <label>所在公寓（送达地点不在公寓选择其他即可）</label>
                    <input type="text" name="apartment" value=<?php echo "$apartment";?> readonly="readonly">
                </fieldset>
            </div>
            <div class="ui-field-contain" >
                <label >寝室号：(要求规范输入如546，便于提取楼层)</label>
                <input type="number" name="dormitory" readonly value=<?php echo "$dormitory";?>>
            </div>
            <div class="ui-field-contain" >
                <label>快递信息（直接复制短信即可）</label>
                <textarea name="message" readonly id='message' ></textarea>
            </div>
            <div class="ui-field-contain" >
                <label>额外需求(指定送达的时间 地点 或者其他需求)</label>
                <textarea name="extra" readonly id='extra'></textarea>
            </div>
            <script type="text/javascript">
                document.getElementById('message').value="<?php echo "$message";?>";
                document.getElementById('extra').value="<?php echo "$extra";?>";
            </script>
            <div class="ui-field-contain" >
                <label >酬金:</label>
                <input type="number" name="fee" step="0.1" min=<?php echo "$fee";?> value=<?php echo "$fee";?> readonly="readonly">
            </div>
        </form>
    </div>


</body>
</html>