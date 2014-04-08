<?php @session_start();
if (empty($_SESSION['user_login'])) {
    $url = "login.php";
    echo "<script language='javascript' type='text/javascript'>";
    echo "window.location.href='$url'";
    echo "</script>";
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="author" content="slzc"/>
    <title>世银用户中心-<?php echo $title;?></title>
    <link href="css/base.css" rel="stylesheet"/>
    <link href="css/part.css" rel="stylesheet"/>
    <script type="text/javascript" src="js/jquery-1.9.1-min.js"></script>
    <script type="text/javascript" src="js/check.js"></script>
    <script type="text/javascript" src="js/IdCardGenerator.js"></script>
    <script type="text/javascript" src="js/base.js"></script>
    <!--注意js的引入的顺序 -->
    <!-- 弹出框js  start-->
    <script type="text/javascript">
        function scscms_alert(msg, sign, ok, can) {
            var c_ = false;//是否已经关闭窗口，解决自动关闭与手动关闭冲突
            sign = sign || "";
            var s = "<div id='mask_layer'></div><div id='scs_alert'><div id='alert_top'></div><div id='alert_bg'><table width='260' align='center' border='0' cellspacing='0' cellpadding='1'><tr>";
            if (sign != "")s += "<td width='45'><div id='inco_" + sign + "'></div></td>";
            s += "<td id='alert_txt'>" + msg + "</td></tr></table>";
            if (sign == "confirm") {
                s += "<a href='javascript:void(0)' id='confirm_ok'>确 定</a><a href='javascript:void(0)' id='confirm_cancel'>取 消</a>";
            } else {
                s += "<a href='javascript:void(0)' id='alert_ok'>确 定</a>"
            }
            s += "</div><div id='alert_foot'></div></div>";
            $("body").append(s);
            $("#scs_alert").css("margin-top", -($("#scs_alert").height() / 2) + "px"); //使其垂直居中
            $("#scs_alert").focus(); //获取焦点，以防回车后无法触发函数

            if (typeof can == "number") {
                //定时关闭提示
                setTimeout(function () {
                    close_info();
                }, can * 1000);
            }
            function close_info() {
                //关闭提示窗口
                if (!c_) {
                    $("#mask_layer").fadeOut("fast", function () {
                        $("#scs_alert").remove();
                        $(this).remove();
                    });
                    c_ = true;
                }
            }

            $("#alert_ok").click(function () {
                close_info();
                if (typeof(ok) == "function")ok();
            });
            $("#confirm_ok").click(function () {
                close_info();
                if (typeof(ok) == "function")ok();
            });
            $("#confirm_cancel").click(function () {
                close_info();
                if (typeof(can) == "function")can();
            });
            function modal_key(e) {
                e = e || event;
                close_info();
                var code = e.which || event.keyCode;
                if (code == 13 || code == 32) {
                    if (typeof(ok) == "function")ok()
                }
                if (code == 27) {
                    if (typeof(can) == "function")can()
                }
            }

            //绑定回车与ESC键
            if (document.attachEvent)
                document.attachEvent("onkeydown", modal_key);
            else
                document.addEventListener("keydown", modal_key, true);
        }
        //兑换确认提示信息
        function test8(message1, message2) {
            scscms_alert(message2, "confirm", function () {
                window.location.href = message1;
            }, function () {
            });
        }
        //兑换确认提示信息
        function test9(message1, message2,message3) {
            scscms_alert(message2, "confirm", function () {
                window.location.href = message1;
            }, function () {
                window.location.href = message3;
            });
        }
        //积分不足提示信息
        function test4(message1, message2) {
            scscms_alert(message2, "error", function () {
                window.location.href = message1;
            });
        }
        //兑换成功提示信息
        function test2(message1, message2) {
            scscms_alert(message1, "ok", function () {
                window.location.href = message2;
            });
        }
         // 警告提示信息
        function test6(message1, message2) {
            scscms_alert(message1, "warn", function () {
                window.location.href = message2;
            });
        }
    //无跳转警告提示信息
        function warn(message){
    scscms_alert(message,"warn");
}
    //提示成功消息  无跳转
      function ok(message){
    scscms_alert(message,"ok");
}

    </script>
    <!-- 弹出框js end-->
</head>

<body>
<div class="middle">
    <div class="header"><a href="#"><img src="images/logo.jpg" width="200" class="fl pdt10"/></a> <span class="uc_name">用户中心</span>

        <div class="logined_info">
            <div class="heng30"></div>
            <p class="tr">--欢迎来到世银商品--</p>

            <p class="tr"><span id="userName" class="ft_09c ft_bold"><?php echo $_SESSION['user']; ?></span><span
                    id="userVIP" class="pdl10">会员</span><span class="pdl10 ft_900"><a href="login.php?action=logout">[退出]</a></span>
            </p>
        </div>
    </div>
    <!--END header-->
    <div class="heng20"></div>
    <div class="main">
        <div class="left">
            <ul class="nav">
                <li><a href="uc_index.php"><span class="nav1"></span>个人信息</a></li>
                <!-- <li class="nav_active"><a href="uc_account_information.php"><span class="nav2_"></span>账号信息</a></li> -->
                <!-- 判断是终端会员还是经纪商会员，是否输出“交易信息”-->
                <?php if ($_SESSION['user_type'] == 1) {
                    echo '<li><a href="uc_trading_information.php"><span class="nav3"></span>交易信息</a></li>';
                } ?>
                <?php if ($_SESSION['user_type'] == 1) {
                    echo '<li class=""><a href="uc_account_information.php"><span class="nav2"></span>账号信息</a></li>';
                } ?>
                <li><a href="uc_integration_information.php"><span class="nav4"></span>我的积分</a></li>
                <li><a href="uc_integration_mall.php"><span class="nav5"></span>积分商城</a></li>
                <li><a href="rotate.php"><span class="nav6"></span>积分活动</a></li>
            </ul>
        </div>
        <!--END left-->
        <script type="text/javascript">
        	$(document).ready(function(e) {
                var src = window.location.href;
				for(var i=0; i<$(".nav").children("li").length;i++){
					if(src.match($(".nav").children("li:eq("+i+")").children("a").attr("href"))){
						$(".nav").children("li:eq("+i+")").addClass("nav_active");
						var newClass = $(".nav").children("li:eq("+i+")").addClass("nav_active").children("a").children("span").attr("class")+"_";
						//alert(newClass);
						$(".nav").children("li:eq("+i+")").addClass("nav_active").children("a").children("span").attr("class",newClass);
					}
				}
            });
        </script>