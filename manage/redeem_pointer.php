<?php
$title = "积分兑换管理";
require "head.php";?>
<script type="text/javascript">
    function pointer_confirm(){
             scscms_alert("确定要计算积分吗","confirm",function(){
                document.getElementById("form").submit();
                },function(){
             });
          }
</script>
<?php
require "../utils/pdo.php";
require "../utils/page.class.php";
?>
<div class="right">
    <div class="content_box boxshadow">
        <div class="content_title">
            <h5 class="pdl10">积分兑换管理</h5>
        </div>
        <div class="content">
            <table class="table_border lh30 tc" cellspacing="0" width="100%">
                <tr>
                    <th>兑换单号</th>
                    <th>账号</th>
                    <th>兑换物品</th>
                    <th>联系电话</th>
                    <th>当前状态</th>
                    <th>兑换时间</th>
                    <th>操作</th>
                </tr>
                <?php
                /*
                查询订单的对应信息  根据exchange_statues=0和id进行排序
                 */
                $sql_count = "select count(*) from dou_exchange";
                $row_count = $pdo->query($sql_count);
                $num = $row_count->fetchColumn();
                $page = new Page($num, 6);
                $stmt = $pdo->query("select * from dou_exchange order by exchange_status=0 desc,id desc {$page->limit}");
                $result = $stmt->fetchAll();
                foreach ($result as $v) {
                    /*
                       根据uid查询对应的用户信息
                    */
                    $rs = $pdo->query("select id,user_account,user_phone from dou_uc where id=" . $v['uid']);
                    $user_v = $rs->fetchAll(PDO::FETCH_ASSOC);
                    $user_value = array();
                    foreach ($user_v as $value) {
                        $user_value['account'] = $value['user_account'];
                        $user_value['phone'] = $value['user_phone'];
                        $user_value['id'] = $value['id'];
                    }
                    /*
                    根据商品id查询商品信息
                     */
                    $rs = $pdo->query("select goods_name from dou_goods where id=" . $v['goods_id']);
                    $goods_v = $rs->fetchAll(PDO::FETCH_ASSOC);
                    $goods_value = array();
                    foreach ($goods_v as $value) {
                        $goods_value['goods_name'] = $value['goods_name'];
                    }
                    ?>
                    <tr>
                        <td><?php echo $v['exchange_id']; ?></td>
                        <td><a href="detail_terminal_member.php?uid=<?php echo $user_value['id'] ?>" target="_blank" ><?php echo $user_value['account']; ?></a></td>
                        <td><?php echo $goods_value['goods_name']; ?></td>
                        <td><?php echo $v['express_to_phone']; ?></td>
                        <td><?php if ($v['exchange_status'] == 0) {
                                echo "未处理";
                            } else if($v['exchange_status'] == 1) {
                                echo "已处理(兑换成功)";
                            } else if($v['exchange_status'] == 2){
                                echo "已处理(兑换失败)";}
                             ?></td>
                            
                        <td><?php echo date("Y-m-d", $v['exchange_time']); ?></td>
                        <td><a href="detail_redeem_pointer.php" target="_blank"><a
                                    href="detail_redeem_pointer.php?id=<?php echo $v['id']; ?>" target="_blank">
                                    <button>详情</button>
                                </a></a></td>
                    </tr>
                    <!-- <tr>
                        <td>DH201412120953001</td>
                        <td>whf001</td>
                        <td>联想电脑 Y…</td>
                        <td>13712345678</td>
                        <td>未处理</td>
                        <td>2014-12-12</td>
                        <td><a href="detail_redeem_pointer.php" target="_blank"><button>详情</button></a></td>
                    </tr>
                    <tr>
                        <td>DH201412120953001</td>
                        <td>whf001</td>
                        <td>联想电脑 Y…</td>
                        <td>13712345678</td>
                        <td>未处理</td>
                        <td>2014-12-12</td>
                        <td><a href="detail_redeem_pointer.php" target="_blank"><button>详情</button></a></td>
                    </tr> -->
                <?php } ?>
            </table>
            <div style="margin-left:320px;margin-top: 9px;"><?php echo $page->fpage(4, 5, 6); ?></div>
            <div style="margin-left:10px;padding-left:450px;">
            <form method="POST" id="form" action="../utils/dou_exchange_data.php"> 
                <select name="statue">
                    <option value="5">全部</option>
                    <option value="1">已处理</option>
                    <option value="0">未处理</option>
                </select>
                <select name="mon">
                                <option value="1">1月</option>
                                <option value="2">2月</option>
                                <option value="3">3月</option>
                                <option value="4">4月</option>
                                <option value="5">5月</option>
                                <option value="6">6月</option>
                                <option value="7">7月</option>
                                <option value="8">8月</option>
                                <option value="9">9月</option>
                                <option value="10">10月</option>
                                <option value="11">11月</option>
                                <option value="12">12月</option>
                </select>
                <input type="button" name="button" onclick="pointer_confirm()" value="导出数据">&nbsp;.xls格式
            </form>
            </div>
        </div>
    </div>
    <!--END right_frist content_box-->
</div>
</div>
<!--END main-->
<?php require "foot.php"; ?>
