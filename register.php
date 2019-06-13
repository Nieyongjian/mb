<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>注册</title>
    <meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=no">
    <link rel="stylesheet" href="css/register.css">
    <link href="bs/bootstrap.css" rel="stylesheet">

</head>
<body>
<header>
    <a href="index.html" class="back">
        <span class="glyphicon glyphicon-chevron-left"></span>
    </a>
    <h3>注册</h3>
</header>
<div id="wrap">
    <div class="header"></div>

    <div class="inner">
        <form action="demo.php" method="post">
            <input type='text' required=''  name="sno">
            <label alt='请输入校园一卡通学号'  ></label>
            <input required=''  type='password' name="pwd">
            <label alt='请输入校园一卡通密码' ></label>
            <input required=''  type='text' name="sid"> 
            <label alt='请输入身份证号码' ></label>
            <!-- <button type="submit">提交</button> -->
           	<input type="submit" value="提交" >
        </form>
        <!-- <button type="submit"><a href="demo.php">提交</a></button> -->
       <!--  <form action="demo.php" method="post">
            <h3>请填入登录教务系统的学号和密码</h3>
            学号：<input type="text" name="sno"><br>
            密码：<input type="password" name="pwd"><br>
            身份证号：（用于验证身份信息）<br>
            <input type="text" name="sid"><br>
            <input type="submit" value="提交验证">
            </form> -->
        
    </div>
    <div class="face"></div>

</div>

</body>
</html>
