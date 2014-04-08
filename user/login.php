<?php
session_start();
include('../utils/pdo.php');
include('../utils/redirect.class.php');
$redirect = new utils();
//退出动作 销毁session
if (isset($_GET['action'])&&$_GET['action'] == 'logout') {
    session_destroy();
    $redirect->redirect('./login.php');
} else if (isset($_GET['action'])&&$_GET['action'] == 'login') {
   // $code = strtolower($_POST['vcode']);
    if (strtolower(trim($_POST['vcode'])) == strtolower($_SESSION['captcha'])) {
        $name = trim($_POST['name']);
        //根据用户交易账号和会员账号进行登录
       // $sql = "select * from dou_uc where trading_account='".$name."' and user_show=1";
        $rs = $pdo->prepare("select * from dou_uc where trim(trading_account)='".$name."' or trim(user_account)='".$name."' and user_show=1");
        $rs->execute();
        $result = $rs->fetch(PDO::FETCH_ASSOC);
        if (!empty($result)) {
                if (md5(trim($_POST['pwd'])) == $result['user_pwd']) {
                    $_SESSION['user_login'] = 1;
                    $_SESSION['user'] = $result['user_name'];
                    $_SESSION['uid'] = $result['id'];
                    $_SESSION['user_type'] = $result['user_type'];
                    unset($_SESSION['captcha']);
                    $redirect->redirect('uc_index.php');
                } 
            
        } else {
            $redirect->redirect('./login.php?vcode=2');
        }
    } else {
            $redirect->redirect('./login.php?vcode=1');
    }
}?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="author" content="slzc"/>
    <title>世银用户中心-登录</title>
    <link href="css/base.css" rel="stylesheet"/>
    <link href="css/part.css" rel="stylesheet"/>
    <script type="text/javascript" src="js/jquery-1.9.1-min.js"></script>
    <script type="text/javascript" src="js/base.js"></script>
</head>
<body>
<div class="middle">
    <div class="header"><a href="#"><img src="images/logo.jpg" width="200" class="fl pdt10"/></a> <span class="uc_name">用户中心</span>

        <div class="logined_info">
            <div class="heng30"></div>
        </div>
    </div>
    <!--END header-->
    <div class="heng20"></div>
    <div class="content_box">
        <div class="content">
            <div id="ad_logo">
                <img src="images/video_start.jpg" width="100%"/>
            </div>
            <div id="logo_box">
                <div class="heng30"></div>
                <div class="login_select">
                    <div id="user_enter" class="enter_active">交易用户登录</div>
                    <div id="ib_enter">经纪商登录</div>
                </div>
                <div class="heng20"></div>
                <!--交易用户登录表单-->
                <form action="login.php?action=login" method="post">
                    <table id="table_user">
                        <tr>
                            <td>用户名：</td>
                            <td><input type="text" name="name" id="userName" placeholder="交易账号/会员账号"/></td>
                        </tr>
                        <tr>
                            <td>密<span style="color:#fff;">密</span>码：</td>
                            <td><input name="pwd" type="password" id="userPassword"/></td>
                        </tr>
                        <tr>
                            <td>验证码：</td>
                            <td><input name="vcode" type="text" id="userCheckCode" style="width:90px;"/><img
                                    src="../utils/captcha.php" onclick="javascript:this.src='../utils/captcha.php?tm='+Math.random();"
                                    height="30px" class="fr"/></td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <?php if (isset($_GET['vcode']) && $_GET['vcode'] == 1) {
                                    echo "<span style='color:red'>验证码不正确</span>";
                                } else if (isset($_GET['vcode']) && $_GET['vcode'] == 2) {
                                    echo "<span style='color:red'>用户名或密码不正确</span>";
                                } 
                                ?>
                            </td>

                        </tr>
                        <tr>
                            <td colspan="2"><input type="submit" value="登录"/></td>
                        </tr>
                    </table>
                </form>
                <!--经济商用户登录表单-->
                <form action="login.php?action=login" method="post">
                    <table id="table_ib" class="hidden">
                        <tr>
                            <td>用户名：</td>
                            <td><input name="name" type="text" id="userName" placeholder="IB账号/会员名称"/></td>
                        </tr>
                        <tr>
                            <td>密<span style="color:#fff;">密</span>码：</td>
                            <td><input name="pwd" type="password" id="userPassword"/></td>
                        </tr>
                        <tr>
                            <td>验证码：</td>
                            <td><input name="vcode" type="text" id="userCheckCode" style="width:90px;"/><img
                                    src="./vcode.php" onclick="javascript:this.src='./vcode.php?tm='+Math.random();"
                                    height="26px" class="fr"/></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td colspan="2"><input type="submit" value="登录"/></td>
                        </tr>
                    </table>
                </form>
            </div>
        </div>
    </div>
    <!--END login_box-->
    <div class="heng20"></div>
    <div class="footer"> 版权：Copyright©2013-2014 xhdz007.com 浙江世银商品经营有限公司版权所有<br/>
        增值电信业务经营许可证：浙ICP备14004664号<br/>
        法律顾问：浙江海浩律师事务所袁晨<br/>
        技术支持：杭州世欧网络科技有限公司
    </div>
    <!--END footer-->
</div>
</body>
</html>