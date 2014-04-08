<?php 
        $title = "我的积分";
        require "head.php";
        require "../utils/pdo.php";
        require "../utils/page.class.php";
        //根据用户id，查询用户的账号
        $result = $pdo->query("select trading_account from dou_uc where id=" . $_SESSION['uid']);
        $trading_account = $result->fetchColumn();
?>
    <div class="right">
        <div class="content_box boxshadow">
            <div class="content_title">
                <h5 class="pdl10">我的积分</h5>
            </div>
            <form action="" method="GET"> 
            <div class="content">
                <?php
                /*
                    用户总积分查询
                 */
                $uc_pointer = "select user_pointer from dou_uc where trading_account='" . $trading_account . "'";
                $tmp_pointer = $pdo->query($uc_pointer);
                $user_pointer_number = $tmp_pointer->fetchColumn();
                ?>
                <p>
                    <span>总积分：</span>
                    <span class="ft_09c"><?php echo floor($user_pointer_number); ?></span>
                    <span class="ml60">到期时间：</span><span>2014-12-31</span>
                    <?php
                    $sql = "select max(month) from dou_month_pointer where trade_account='".$trading_account."' order by time desc";
                    $month = $pdo->query($sql)->fetchColumn();
                    /*
                    根据月份和用户id查询出用户本月的积分显示
                           */
                    if(!empty($month)){
                    $month_pointer = "SELECT pointer FROM dou_month_pointer where trade_account=" . $trading_account . " and month=" . $month;
                    $mon_pointer = $pdo->query($month_pointer)->fetchColumn();
                    echo '<span class="ml60">'.$month.'月入金积分：</span><span>'.floor($mon_pointer).'</span>';
                }
                    ?>
                    <!-- <span class="ml60"><?php echo $month;?>月入金积分：</span><span><?php echo $month_pointer; ?></span>                            -->
                </p>
            </div>
            </form>
        </div>
        <!--END right_frist content_box-->
        <div class="heng10"></div>
        <div class="content_box boxshadow">
            <div class="content_title">
                <h5 class="pdl10">积分消费信息</h5>
            </div>
            <div class="content">
                <table class="table_border line_height30" width="100%" cellspacing="0">
                    <tr>
                        <td class="tc" width="15%"><strong>时&nbsp;&nbsp;&nbsp;&nbsp;间</strong></td>
                        <td class="tc" width="40%"><strong>消费项目</strong></td>
                        <td class="tc" width="15%"><strong>消费额度</strong></td>
                        <td class="tc" width="15%"><strong>订单状态</strong></td> 
                        <td class="tc" width="15%"><strong>操作</strong></td> 
                    </tr>
                    <?php
                    //用户兑换信息显示
                    $sql_count = "SELECT count(*) FROM dou_exchange where uid=" . $_SESSION['uid'];
                    $count_val = $pdo->query($sql_count);
                    $count = $count_val->fetchColumn();
                    $page = new Page($count, 10);
                    $sql_page = "select * from dou_exchange where uid=" . $_SESSION['uid'] . " order by id desc {$page->limit}";
                    $res = $pdo->query($sql_page);
                    $result_v = $res->fetchAll(PDO::FETCH_ASSOC);
                    foreach ($result_v as $v) {
                        //根据商品id查询商品的积分
                        $sql_goods = "SELECT id,goods_pointer,goods_name from dou_goods where id=" . $v['goods_id'];
                        $goods_result = $pdo->query($sql_goods, PDO::FETCH_ASSOC)->fetch();
                        ?>
                        <tr>
                            <td class="tc"><?php echo date("Y-m-d", $v['exchange_time']); ?></td>
                            <td class="tc"><?php echo $v['exchange_status'] == 3 ? '兑换' . $goods_result['goods_name'] . '未成功返还积分' : '兑换' . $goods_result['goods_name'] . '扣除积分'; ?></td>

                            <td class="tc">
                            <?php
                            switch($v['exchange_status']){
                                case 2;
                                echo 0;
                                break;
                                default:
                                echo $goods_result['goods_pointer'];
                            }
                            ?>
                            </td>
                            <td class="tc">
                            <?php
                            switch($v['exchange_status']){
                                case 0:
                                echo "已提交";
                                break;
                                case 1:
                                echo "兑换成功";
                                break;
                                case 2;
                                echo "兑换失败";
                                break;
                            }
                            ?>
                            </td>
                            <td class="tc"><a href="goods_order_detail.php?id=<?php echo $v['id']?>">详细</a></td>
                        </tr>
                    <?php } ?>
                </table>
                <div style="margin-left:320px;margin-top:5px;"><?php echo $page->fpage(4, 5, 6); ?></div>
            </div>
        </div>
        <!--END right_second content_box-->
    </div>
    </div>
    <!--END main-->
<?php require "foot.php"; ?>