<?php @session_start();
if (empty($_SESSION['admin_login'])) {
    $url = "login.php";
    echo "<script language='javascript' type='text/javascript'>";
    echo "window.location.href='$url'";
    echo "</script>";
}
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
