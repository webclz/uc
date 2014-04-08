<?php
session_start();
include('../utils/pdo.php');
//退出动作 销毁session
if (isset($_GET['action'])&&$_GET['action'] == 'logout') {
    session_destroy();
    header("Location: ./login.php");
} else if (isset($_GET['action'])&&$_GET['action'] == 'login') {
   // $code = strtolower($_POST['vcode']);
    if (strtolower(trim($_POST['vcode'])) == strtolower($_SESSION['captcha'])) {
        $rs = $pdo->prepare("select * from dou_admin where user_name=:content");
        $rs->bindParam(':content', $name);
        $name = trim($_POST['name']);
        $rs->execute();
        $numcount = $rs->rowCount();
        if ($numcount != 0) {
            while ($row = $rs->fetch()) {
                if (md5(trim($_POST['pwd'])) == $row['password']) {
                    //登陆成功后 重写最后登陆时间和登陆ip
                    $last_login = time();
                    $last_ip = ip2long($_SERVER["REMOTE_ADDR"]);
                    $sql = "update dou_admin set last_login=" . $last_login . ",last_ip=" . $last_ip . " where user_id=" . $row['user_id'];
                    $stmt = $pdo->prepare($sql);
                    $stmt->execute();
                    //写入session，判断用户是否登陆
                    $_SESSION['admin_login'] = 1;
                    $_SESSION['manage'] = $_POST['name'];
                    unset($_SESSION['captcha']);
                    header("Location: ./admin_uc_index.php");
                } else {
                    header("Location: ./login.php?vcode=3");
                }
            }
        } else {
            header("Location: ./login.php?vcode=2");
        }
    } else {
        header("Location: ./login.php?vcode=1");
    }
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="author" content="slzc"/>
    <title>世银用户管理中心-登陆</title>
    <link href="css/base.css" rel="stylesheet"/>
    <link href="css/part.css" rel="stylesheet"/>
    <script type="text/javascript" src="js/jquery-1.9.1-min.js"></script>
    <script type="text/javascript" src="js/check.js"></script>
    <script type="text/javascript" src="js/IdCardGenerator.js"></script>
    <script type="text/javascript" src="js/base.js"></script>
    <!--注意js的引入的顺序 -->
</head>

<body>
<div class="middle">
    <div class="header"><a href="#"><img src="images/logo.jpg" width="200" class="fl pdt10"/></a> <span class="uc_name">用户管理中心</span>

        <div class="logined_info">
            <div class="heng30"></div>
            <p class="tr">--欢迎来到世银商品--</p>
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
                <!--<div class="login_select">
                    <div id="user_enter" class="enter_active">交易用户登录</div><div id="ib_enter">经纪商登录</div>
                </div>-->
                <div class="heng20"></div>
                <!--交易用户登录表单-->
                <form action="login.php?action=login" method="post">
                    <table id="table_user">
                        <tr>
                            <td>用户名：</td>
                            <td><input type="text" name="name" id="userName" placeholder="管理员账号"/></td>
                        </tr>
                        <tr>
                            <td>密<span style="color:#fff;">密</span>码：</td>
                            <td><input name="pwd" type="password" id="userPassword"/></td>
                        </tr>
                        <tr>
                            <td>验证码：</td>
                            <td><input name="vcode" type="text" id="userCheckCode" style="width:90px;"/><img
                                    src="../utils/captcha.php" onclick="javascript:this.src='../utils/captcha.php?tm='+Math.random();"
                                    class="fr" height="30px"/></td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <?php if (isset($_GET['vcode']) && $_GET['vcode'] == 1) {
                                    echo "<span style='color:red'>验证码不正确</span>";
                                } else if (isset($_GET['vcode']) && $_GET['vcode'] == 2) {
                                    echo "<span style='color:red'>用户不存在</span>";
                                } else if (isset($_GET['vcode']) && $_GET['vcode'] == 3) {
                                    echo "<span style='color:red'>密码错误</span>";
                                }
                                ?></td>

                        </tr>
                        <tr>
                            <td colspan="2"><input type="submit" value="登录"/></td>
                        </tr>
                    </table>
                </form>
                <!--经济商用户登录表单-->
                <!-- <table id="table_ib" class="hidden">
                     <tr>
                         <td>用户名：</td>
                         <td><input type="text" id="userName" placeholder="IB账号/会员名称" /></td>
                     </tr>
                     <tr>
                         <td>密<span style="color:#fff;">密</span>码：</td>
                         <td><input type="password" id="userPassword" /></td>
                     </tr>
                     <tr>
                         <td>验证码：</td>
                         <td><input type="text" id="userCheckCode" style="width:90px;" /><img src="images/checkCode.jpg" height="26px" class="fr" /></td>
                     </tr>
                     <tr>
                         <td></td>
                         <td></td>
                     </tr>
                     <tr>
                         <td colspan="2"><input type="submit" value="登录" /></td>
                     </tr>
                 </table>-->
            </div>
        </div>
    </div>
    <!--END login_box-->
    <?php
    /**
     * Created by PhpStorm.
     * User: Administrator
     * Date: 14-2-27
     * Time: 下午2:49
     */
    ?>
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
