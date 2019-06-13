<!DOCTYPE html>
<html>
<head>
    <title>注册结果页</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1,user-scalable=no">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="bs/bootstrap.css">
    <link rel="stylesheet" href="css/list.css">
    <link rel="stylesheet" href="css/register.css">
    <script src="js/jquery.js"></script>
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
<header>
    <h3>注册</h3>
</header>
<?php
include 'utils.php';
// var_dump($_POST);
if(isset($_POST['sno'])){
    $psno = $_POST['sno'];
}else{
    echo "没有获取到数据";
    exit;
}
if(isset($_POST['pwd'])){
    $ppwd = $_POST['pwd'];
}
if(isset($_POST['sid'])){
    $pid = $_POST['sid'];
}
function get_page($sno,$pwd)
{
    $curl = curl_init();
    $cookie_jar = tempnam('./tmp','cookie');
    curl_setopt($curl, CURLOPT_URL,'http://60.219.165.24/loginAction.do');//
    curl_setopt($curl, CURLOPT_POST, 1);
    $post = array ( 
        'zjh' => $sno, 
        'mm' => $pwd,
    ); 
    // 通过账号密码登录网站
    curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($post));
    curl_setopt($curl, CURLOPT_COOKIEJAR, $cookie_jar);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_HEADER, false);
    curl_setopt($curl, CURLOPT_NOBODY, false);
    curl_exec($curl);
    //获取连接状态码
    $curl_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
    curl_close($curl); //
    if ($curl_code == 200) {
        //爬取页面信息
        $curl2 = curl_init();
        curl_setopt($curl2, CURLOPT_URL, 'http://60.219.165.24/xjInfoAction.do?oper=xjxx');
        curl_setopt($curl2, CURLOPT_HEADER, false);
        curl_setopt($curl2, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl2, CURLOPT_COOKIEFILE, $cookie_jar);
        //返回爬取到的页面代码
        $content = curl_exec($curl2);
        return "$content";
    } else {
        echo '连接失败，状态码：' . $curl_code;
    }
     
}



$content = get_page($psno,$ppwd);

if($content){
    //因为爬取到的页面是gbk格式，为了通过正则匹配信息，将这些关键字进行编码转换
    $ssno = iconv("UTF-8","GBK",'学号:');
    $sname = iconv("UTF-8","GBK",'姓名:');
    $ssid = iconv("UTF-8","GBK",'身份证号:');
    $ssex = iconv("UTF-8","GBK",'性别:');
    $ssclass= iconv("UTF-8","GBK",'学生类别:');
    $sxs = iconv("UTF-8","GBK",'系所:');
    $szy = iconv("UTF-8","GBK",'专业:');
    $smd = iconv("UTF-8","GBK",'专业方向:');
    $snj = iconv("UTF-8","GBK",'年级:');
    $sbj = iconv("UTF-8","GBK",'班级:');
    $sxj = iconv("UTF-8","GBK",'是否有学籍:');
    //学号
    /*
    学号:&nbsp;</td>
                                            
                                            <td width="275">
                                            2015026752
                                            </td>
                                    
                                            <td class="fieldName" width="180">姓名:
     */
    $r_sno = "/$ssno&nbsp;<\/td>\s+<td width=\"275\">(.*)<\/td>\s+<td class=\"fieldName\" width=\"180\">$sname/s";
    preg_match_all($r_sno, $content,$sno);
    $sno = trim($sno[1][0]);


    //姓名
    /*
    姓名:&nbsp;</td>
                                            
                                            <td width="275">
                                            闫旭本
                                            </td>
                                    
                                            <td class="fieldName" width="150"></td>
     */
    $r_name = "/$sname&nbsp;<\/td>\s+<td width=\"275\">(.*)<\/td>\s+<td class=\"fieldName\" width=\"150\"><\/td>/s";
    preg_match_all($r_name, $content,$name);
    $name = trim($name[1][0]);


    //身份证号
    /*
    身份证号:&nbsp;
                                        </td>
                                        
                                        
                                        <td align="left" width="275">
                                        
                                          152827199512243938
                                        </td>
                                        
                                        
                                    <tr> 
                                    
                                        <td class="fieldName" width="180">
                                    性别:
     */
    $r_sid = "/$ssid&nbsp;\s+<\/td>\s+<td align=\"left\" width=\"275\">(.*)<\/td>\s+<tr>\s+<td class=\"fieldName\" width=\"180\">\s+$ssex/s";
    preg_match_all($r_sid, $content,$sid);
    $sid = trim($sid[1][0]);


    // 性别
    /*
    性别:&nbsp;
                                        </td>
                                        
                                        
                                        <td align="left" width="275">
                                        
                                          男
                                        </td>
                                        
                                        
                                        <td class="fieldName" width="180">
                                    学生类别:&nbsp;

     */
    $r_ssex = "/$ssex&nbsp;\s+<\/td>\s+<td align=\"left\" width=\"275\">(.*)<\/td>\s+<td class=\"fieldName\" width=\"180\">\s+$ssclass&nbsp;/s";
    preg_match_all($r_ssex, $content,$sex);
    $sex = trim($sex[1][0]);

    // 院系
    /*
    系所:&nbsp;
                                        </td>
                                        
                                        
                                        <td align="left" width="275">
                                        
                                          管理学院
                                        </td>
                                        
                                        
                                    <tr> 
                                    
                                        <td class="fieldName" width="180">
                                    专业:
     */
    $r_sxs = "/$sxs&nbsp;\s+<\/td>\s+<td align=\"left\" width=\"275\">(.*)<\/td>\s+<tr>\s+<td class=\"fieldName\" width=\"180\">\s+$szy/s";
    preg_match_all($r_sxs, $content,$xs);
    $xs = trim($xs[1][0]);

    // 专业
    /*
    专业:&nbsp;
                                        </td>
                                        
                                        
                                        <td align="left" width="275">
                                        
                                          信息管理与信息系统
                                        </td>
                                        
                                        
                                        <td class="fieldName" width="180">
                                    专业方向:

     */
    $r_szy = "/$szy&nbsp;\s+<\/td>\s+<td align=\"left\" width=\"275\">(.*)<\/td>\s+<td class=\"fieldName\" width=\"180\">\s+$smd/s";
    preg_match_all($r_szy, $content,$zy);
    $zy = trim($zy[1][0]);


    // 年级
    /*
    年级:&nbsp;
                                        </td>
                                        
                                        
                                        <td align="left" width="275">
                                        
                                          2015级
                                        </td>
                                        
                                        
                                        <td class="fieldName" width="180">
                                    班级:
     */
    $r_snj = "/$snj&nbsp;\s+<\/td>\s+<td align=\"left\" width=\"275\">(.*)<\/td>\s+<td class=\"fieldName\" width=\"180\">\s+$sbj/s";
    preg_match_all($r_snj, $content,$nj);
    $nj = trim($nj[1][0]);


    // 班级
    /*
    班级:&nbsp;
                                        </td>
                                        
                                        
                                        <td align="left" width="275">
                                        
                                          信管15-2
                                        </td>
                                        
                                        
                                    <tr> 
                                    
                                        <td class="fieldName" width="180">
                                    是否有学籍
     */
    $r_sbj = "/$sbj&nbsp;\s+<\/td>\s+<td align=\"left\" width=\"275\">(.*)<\/td>\s+<tr>\s+<td class=\"fieldName\" width=\"180\">\s+$sxj/s";
    preg_match_all($r_sbj, $content,$bj);
    $bj = trim($bj[1][0]);

    //将提取到的数据的编码，转换回utf8
    $sno = iconv("GBK","UTF-8",$sno);
    $name = iconv("GBK","UTF-8",$name);
    $sid = iconv("GBK","UTF-8",$sid);
    $sex = iconv("GBK","UTF-8",$sex);
    $xs = iconv("GBK","UTF-8",$xs);
    $zy = iconv("GBK","UTF-8",$zy);
    $nj = iconv("GBK","UTF-8",$nj);
    $bj = iconv("GBK","UTF-8",$bj);
    $info = array(
        'sno'=>$sno,
        'sname'=>$name,
        'sid'=>$sid,
        'sex'=>$sex,
        'xs'=>$xs,
        'zy'=>$zy,
        'nj'=>$nj,
        'bj'=>$bj,
        );
    if($sno =='' && $bj==''){
        echo "学号或者密码有误";
        exit;
    }
    // var_dump($info);
    //判断用户提交的身份证信息与爬取到的信息是否一致
    if($sid==$pid){
        // echo "ok";
        /*
        插入数据库操作
         */
        session_start();
        if(isset($_SESSION['openid'])){
            $openid = $_SESSION['openid'];
            // echo "$openid";
        }else{
            echo "未获取到openid";
            exit;
        }
        if(isset($openid)){
            //将用户注册信息录入到数据库中
            $utils =  new Utils;
            $dbconn = $utils->get_db_conn();
            $sql_query = "INSERT INTO `user` set openid=:openid,sid=:sid,sno=:sno,name=:sname,ssex=:ssex";
            $prepare_conn = $dbconn->prepare($sql_query);
            if($prepare_conn->execute(array(
                ':openid'=>$openid,
                ':sid'=>$sid,
                ':sno'=>$sno,
                ':sname'=>$name,
                ':ssex'=>$sex,
                // ':snj'=>$nj,
                // ':sxs'=>$xs,
                // ':szy'=>$zy,
                // ':sbj'=>$bj
                ))){
                echo "<!-- 模态框 -->
                <div class='modal fade show'  style='display: block;top:30%'>
                    <div class='modal-dialog'>
                        <div class='modal-content'>

                            <!-- 模态框头部 -->
                            <div class='modal-header bg-light text-dark' style='display: block;'>
                                <h4 class='text-success text-center' >
                                    <span class='glyphicon glyphicon-ok' style='font-size: 18px;color:#28a745;'> </span> 注册成功</h4>
                            </div>

                            <!-- 模态框底部 -->
                            <div class='modal-body'>
                                <a href='index.php' class='btn btn-info myBtn' style='margin-left: 20px'>返回首页</a>
                                <a href='myInfo.php' class='btn btn-info float-right myBtn' style='margin-right: 20px'>我的主页</a>
                            </div>

                        </div>
                    </div>
                </div>";
            }else{
                echo "<!-- 模态框 -->
                <div class='modal fade show'  style='display: block;top:30%'>
                    <div class='modal-dialog'>
                        <div class='modal-content'>

                            <!-- 模态框头部 -->
                            <div class='modal-header bg-light text-dark' style='display: block;'>
                                <h4 class='text-success text-center' >
                                    <span class='glyphicon glyphicon-ok' style='font-size: 18px;color:#28a745;'> </span> 注册失败,该学号已经绑定其他微信号</h4>
                            </div>

                            <!-- 模态框底部 -->
                            <div class='modal-body'>
                                <a href='index.php' class='btn btn-info myBtn' style='margin-left: 20px'>返回首页</a>
                                <a href='register.php' class='btn btn-info float-right myBtn' style='margin-right: 20px'>返回注册</a>
                            </div>

                        </div>
                    </div>
                </div>";
            }
        }
    }else{
        echo "<!-- 模态框 -->
                <div class='modal fade show'  style='display: block;top:30%'>
                    <div class='modal-dialog'>
                        <div class='modal-content'>

                            <!-- 模态框头部 -->
                            <div class='modal-header bg-light text-dark' style='display: block;'>
                                <h4 class='text-success text-center' >
                                    <span class='glyphicon glyphicon-ok' style='font-size: 18px;color:#28a745;'> </span> 注册失败,身份证信息有误</h4>
                            </div>

                            <!-- 模态框底部 -->
                            <div class='modal-body'>
                                <a href='index.php' class='btn btn-info myBtn' style='margin-left: 20px'>返回首页</a>
                                <a href='register.php' class='btn btn-info float-right myBtn' style='margin-right: 20px'>返回注册</a>
                            </div>

                        </div>
                    </div>
                </div>";
    }
}

 
?>





</body>
</html>