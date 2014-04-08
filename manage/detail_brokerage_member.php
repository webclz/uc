<?php 
$title = "经纪商会员详情";
require "head.php"; ?>
    <div class="right">
        <div class="content_box boxshadow">
            <div class="content_title">
                <h5 class="pdl10">经纪商会员管理-详情</h5>
            </div>
            <div class="content">
                <table class="lh30" cellspacing="0" width="">
                    <?php
                    //根据用户id查询详细的信息
                    require('../utils/pdo.php');
                    //用户密码重置
                    if (isset($_GET['pwd']) && $_GET['pwd'] == 1) {
                        $sql = "update dou_uc set user_pwd=:user_pwd where id=:id";
                        $stmt = $pdo->prepare($sql);
                        $pwd = md5(777777);
                        $stmt->bindParam(':id', $_GET['uid']);
                        $stmt->bindParam(':user_pwd', $pwd);
                        if ($stmt->execute()) {
                            echo "<script>test2('detail_brokerage_member.php?uid=" . $_GET['uid'] . "','密码重置成功！')</script>";
                        }
                    }
                    $stmt = $pdo->query("select * from dou_uc where id=" . $_GET['uid']);
                    $result = $stmt->fetchAll();
                    foreach ($result as $v) {

                        ?>
                        <tr>
                            <td>会员账号：</td>
                            <td><?php echo $v['user_account']; ?></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>客户姓名：</td>
                            <td><?php echo $v['user_name']; ?></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>身份证号：</td>
                            <td><?php echo $v['user_idcard']; ?></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>手机号码：</td>
                            <td><?php echo $v['user_phone']; ?></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>电子邮箱：</td>
                            <td><?php echo $v['user_email']; ?></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>联系地址：</td>
                            <td><?php echo $v['user_address']; ?></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>会员积分：</td>
                            <td><?php echo floor($v['user_pointer']) ?></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>登录密码：</td>
                            <td>*******</td>
                            <td>
                                <button
                                    onclick="test8('detail_brokerage_member.php?pwd=1&uid=<?php echo $_GET["uid"]; ?>','确定要重置吗')">
                                    密码重置
                                </button>
                            </td>
                        </tr>
                    <?php } ?>
                </table>
            </div>
        </div>
        <!--END right_frist content_box-->
    </div>
    </div>
    <!--END main-->
<?php require "foot.php"; ?>