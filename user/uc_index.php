<?php
$title = "个人信息";
require "head.php";
require "../utils/pdo.php";
if (isset($_POST['submit'])) {
    //修改用户信息
    $sql = "update dou_uc set user_phone=:user_phone,user_email=:user_email,user_address=:user_address where id=:id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id', $_SESSION['uid']);
    $stmt->bindParam(':user_address', $_POST['user_address']);
    $stmt->bindParam(':user_email', $_POST['user_email']);
    $stmt->bindParam(':user_phone', $_POST['user_phone']);
    if ($stmt->execute()) {
        echo "<script>test2('修改成功','');</script>";
    }
}
?>
    <div class="right">
        <div class="content_box boxshadow">
            <div class="content_title">
                <h5 class="pdl10">个人信息</h5>
            </div>
            <div class="content">
                <table class="table_person_info">
                    <?php
                    // 根据用户id查询用户的详细信息
                    $v = $pdo->query("select * from dou_uc where id=" . $_SESSION['uid'],PDO::FETCH_ASSOC)->fetch();
                        ?>
                        <!-- <form action="" method="post"> -->
                        <tr>
                            <td class="tr">账户名：</td>
                            <td>
                                <input type="text" id="userName" onblur="check_userName('userName','locate1');"
                                       readonly="readonly" class="border_none"
                                       value="<?php echo $v['user_account']; ?>"/>
                            </td>
                            <td id="locate1">
                                <!--<span class="required">*</span><span class="normal">用户名由4-12个字母或2-6个中文组成</span><span class="warning hidden"></span><span class="success hidden"></span>--></td>
                        </tr>
                        <tr>
                            <td class="tr">真实姓名：</td>
                            <td>
                                <input type="text" id="realName" onblur="check_realName('realName','locate2');"
                                       readonly="readonly" class="border_none" value="<?php echo $v['user_name'] ?>"/>
                            </td>
                            <td id="locate2">
                                <!--<span class="required">*</span><span class="normal">请务必填写您的真实姓名以保障您的权益</span><span class="warning hidden"></span><span class="success hidden"></span>--></td>
                        </tr>
                        <tr>
                            <td class="tr">身份证号：</td>
                            <td>
                                <input type="text" id="idCard" onblur="check_idCard('idCard','locate3');"
                                       readonly="readonly" class="border_none" value="<?php echo $v['user_idcard'] ?>"/>
                            </td>
                            <td id="locate3">
                                <!--<span class="required">*</span><span class="normal">与真实姓名对应的身份证号码（用于身份核对）</span><span class="warning hidden"></span><span class="success hidden"></span>--></td>
                        </tr>
                        <!--
                        <tr>
                            <td class="tr">身份证地址：</td>
                            <td>
                                <input type="text" id="idCardAddress" onblur="check_idCardAddress('idCardAddress','locate4','idCard');" />
                            </td>
                            <td id="locate4"><span class="required">*</span><span class="normal">身份证上的地址（用于身份核对,格式：XX省XX市/县）</span><span class="warning hidden"></span><span class="success hidden"></span></td>
                        </tr>
                        -->
                        <form action="" method="post">
                            <tr>
                                <td class="tr">手机号：</td>
                                <td>
                                    <input type="text" name="user_phone" id="mobile"
                                           onblur="check_mobile('mobile','locate5');" readonly="readonly"
                                           class="border_none" value="<?php echo $v['user_phone']; ?>"/>
                                </td>
                                <td id="locate5" class="hidden"><span class="required">*</span><span class="normal">请填写11位有效手机号码</span><span
                                        class="warning hidden"></span><span class="success hidden"></span></td>
                            </tr>
                            <tr>
                                <td class="tr">电子邮箱：</td>
                                <td>
                                    <input type="text" name="user_email" id="mail"
                                           onblur="check_mail('mail','locate6');" readonly="readonly"
                                           class="border_none" value="<?php echo $v['user_email']; ?>"/>
                                </td>
                                <td id="locate6" class="hidden"><span class="required">*</span><span class="normal">请填写有效的电子邮箱</span><span
                                        class="warning hidden"></span><span class="success hidden"></span></td>
                            </tr>
                            <tr>
                                <td class="tr">联系地址：</td>
                                <td>
                                    <input type="text" name="user_address" id="address"
                                           onblur="check_address('address','locate7');" readonly="readonly"
                                           class="border_none" value="<?php echo $v['user_address']; ?>"/>
                                </td>
                                <td id="locate7" class="hidden"><span class="required">*</span><span class="normal">请填写您的详细联系地址</span><span
                                        class="warning hidden"></span><span class="success hidden"></span></td>
                            </tr>
                            <tr>
                                <td></td>
                                <td><span id="change" class="change">修改</span><input type="submit" name="submit"
                                                                                     value="保存" class="hidden"
                                                                                     id="sub"/>
                                    <button class="hidden ml20" id="cancel">取消</button>
                                </td>
                                <td></td>
                            </tr>
                        </form>
                </table>
            </div>
        </div>
        <!--END right_frist content_box-->
    </div>
    </div>
    <!--END main-->
<?php require "foot.php"; ?>