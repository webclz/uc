<?php
$title = "交易信息";   
require "head.php";
require "../utils/pdo.php";
require "../utils/page.class.php";
//根据接收到的表单的值 传递值
if (isset($_POST['search']) && (!empty($_POST['month']) && !empty($_POST['day']))) {
    $url = "uc_trading_information.php?month=" . $_POST['month'] . "&day=" . $_POST['day'];
    echo "<script language='javascript' type='text/javascript'>";
    echo "window.location.href='$url'";
    echo "</script>";
} else if (isset($_POST['search']) && empty($_POST['month']) && empty($_POST['day'])) {
    echo "<script type='text/javascript'>alert('请填写相应的日期')</script>";
} else if (isset($_POST['search']) && !empty($_POST['month']) && empty($_POST['day'])) {
    $url = "uc_trading_information.php?month=" . $_POST['month'];
    echo "<script language='javascript' type='text/javascript'>";
    echo "window.location.href='$url'";
    echo "</script>";
} else if (isset($_POST['all'])) {
    $url = "uc_trading_information.php";
    echo "<script language='javascript' type='text/javascript'>";
    echo "window.location.href='$url'";
    echo "</script>";
} else if (isset($_POST['search']) && empty($_POST['month']) && !empty($_POST['day'])) {
    echo "<script type='text/javascript'>alert('请填写相应月份')</script>";

}
?>
    <!--END left-->
    <div class="right">
        <div class="content_box boxshadow">
            <div class="content_title">
                <h5 class="pdl10">交易信息</h5>
            </div>
            <div class="content" style="overflow:auto;">
                <table class="trading_table" cellspacing="0">

                    <tr>
                        <td>日期</td>
                        <td>交易手数</td>
                        <td>交易品种</td>
                        <td>交易资金量</td>
                        <td>平仓盈亏</td>
                        <td>持仓盈亏</td>
                    </tr>
                    <?php
                    /*
                    根据用户的交易账号，分页 输出交易信息
                    终端会员才有交易信息,根据session查询交易账号
                     */
                    if ($_SESSION['user_type'] == 1) {
                        $result = $pdo->query("select trading_account from dou_uc where id=" . $_SESSION['uid']);
                        $trading_account = $result->fetchColumn();
                    }
                    //根据交易账号 查询交易信息 分页显示 获取总记录数
                    if (!empty($_GET['month']) && !empty($_GET['day'])) {
                        $sql_count = "SELECT COUNT(*) FROM dou_trade WHERE month(trade_time)=" . $_GET['month'] . " and day(trade_time)=" . $_GET['day'] . " and trade_account='" . $trading_account . "'";
                    } else if (!empty($_GET['month']) && empty($_GET['day'])) {
                        $sql_count = "SELECT COUNT(*) FROM dou_trade WHERE month(trade_time)=" . $_GET['month'] . " and trade_account='" . $trading_account . "'";
                    } else {
                        $sql_count = "SELECT COUNT(*) FROM dou_trade WHERE  trade_account='" . $trading_account."'";
                    }
                    $row_count = $pdo->query($sql_count);
                    $num = $row_count->fetchColumn();
                    $page = new Page($num, 10);
                    //搜索显示
                    if (!empty($_GET['month']) && !empty($_GET['day'])) {
                        $sql_page = "SELECT * FROM dou_trade where month(trade_time)=" . $_GET['month'] . " and day(trade_time)=" . $_GET['day'] . " and trade_account='" . $trading_account . "' order by trade_time desc {$page->limit}";
                    } else if (!empty($_GET['month']) && empty($_GET['day'])) {
                        $sql_page = "SELECT * FROM dou_trade where month(trade_time)=" . $_GET['month'] . " and trade_account='" . $trading_account . "' order by trade_time desc {$page->limit}";
                    } else {
                        $sql_page = "SELECT * FROM dou_trade where trade_account='" . $trading_account . "' order by trade_time desc {$page->limit}";
                    }
                    $res = $pdo->query($sql_page);
                    $result_arr = $res->fetchAll(PDO::FETCH_ASSOC);
                    foreach ($result_arr as $v) {
                        ?>
                        <tr>
                            <td><?php echo $v['trade_time']; ?></td>
                            <td><?php echo $v['trade_number']; ?></td>
                            <td><?php echo $v['goods_type']; ?></td>
                            <td><?php echo $v['trade_pay']; ?></td>
                            <td><?php echo $v['level_benefit']; ?></td>
                            <td><?php echo $v['hold_benefit']; ?></td>
                        </tr>

                    <?php } ?>
                </table>
                <div class="heng10"></div>
                <?php echo $page->fpage(4, 5, 6); ?>
                <div class="heng20"></div>
                <p>按日期查询</p>

                <div class="heng10"></div>
                <div class="">
                    <form action="" method="post">
                        <input type="text" style="width:35px;" readonly="readonly" value="2014"/><span
                            class="ml10 pdr10">年</span><input <?php if (!empty($_GET['month'])) {
                            echo "value='" . $_GET['month'] . "'";
                        } ?> type="text" name="month" style="width:20px;"/><span class="ml10 pdr10">月</span><input
                            type="text" <?php if (!empty($_GET['day'])) {
                            echo "value='" . $_GET['day'] . "'";
                        } ?> name="day" style="width:20px;"/><span class="ml10 pdr10">日</span><input type="submit"
                                                                                                     name="search"
                                                                                                     value="查询"/>&nbsp;&nbsp;&nbsp;<input
                            type="submit" name="all" value="全部"/>
                    </form>
                </div>
            </div>
        </div>
        <!--END right_frist content_box-->
    </div>
    </div>
    <!--END main-->
<?php require "foot.php"; ?>