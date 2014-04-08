<?php
$title = "账号信息";
require "head.php";
require "../utils/pdo.php";
$stmt = $pdo->query("select user_pwd,user_name,user_account,trading_account from dou_uc where id=" . $_SESSION['uid']);
$user_val = $stmt->fetch(PDO::FETCH_ASSOC);
/*
修改密码
 */
if (isset($_POST['submit']) && (!empty($_POST['oldPassword'])) && !empty($_POST['newPassword']) && !empty($_POST['confirmPassword'])) {
    //判断两次输入的密码是否是一样的
    if ($_POST['newPassword'] != $_POST['confirmPassword']) {
        echo "<script>alert('两次输入新密码不正确');</script>";
    } else {
        //判断输入的密码是否与原来的密码相同
        // $result=$pdo->query("select user_pwd from dou_uc where id=".$_SESSION['id']);
        // $oldPassword=$result->fetchColumn();
        if (md5($_POST['oldPassword']) == $user_val['user_pwd']) {
            //如果密码相同，将相对应的密码更新
            $sql = "update dou_uc set user_pwd=:user_pwd where id=:id";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':id', $_SESSION['uid']);
            $stmt->bindParam(':user_pwd', md5($_POST['newPassword']));
            if ($stmt->execute()) {
                echo "<script>test2('','修改密码成功')</script>";
            }
        } else {
            echo "<script>test4('','原密码有误，修改失败');</script>";
        }

    }
    //判断提交的值是否是空值
} else if (isset($_POST['submit']) && (empty($_POST['oldPassword']) || empty($_POST['newPassword']) || empty($_POST['confirmPassword']))) {
    echo "<script>alert('带*项不能为空');</script>";
}
?>

<div class="right">
    <div class="content_box boxshadow">
        <div class="content_title">
            <h5 class="pdl10">账号信息</h5>
        </div>
        <div class="content">
            <form action="" method="POST">
                <table class="table_person_info">
                    <tr>
                        <td class="tr">交易账号：</td>
                        <td><input type="text" id="accountId" value="<?php echo $user_val['trading_account']; ?>" readonly="readonly" class="border_none"/>
                        </td>
                        <td></td>
                    </tr>
                    <!--<tr>
                        <td class="tr">入金量：</td>
                        <td><input type="text" id="accountId" value="1000.00" readonly="readonly" class="border_none"/>
                        </td>
                        <td></td>
                    </tr>
                    <tr>
                        <td class="tr">出金量：</td>
                        <td><input type="text" id="accountId" value="500.00" readonly="readonly" class="border_none"/>
                        </td>
                        <td></td>
                    </tr>
                    <tr>
                        <td class="tr">账户余额：</td>
                        <td><input type="text" id="accountId" value="500.00" readonly="readonly" class="border_none"/>
                        </td>
                        <td></td>
                    </tr>-->
                    <tr>
                        <td class="tr">会员账号：</td>
                        <td><input type="text" id="loginId" value="<?php echo $user_val['user_account']; ?>"
                                   readonly="readonly" class="border_none"/></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td class="tr" id="oldPasswordText">登录密码：</td>
                        <td><input name="oldPassword" type="password" value="******" id="accountPassword"
                                   readonly="readonly" class="border_none"
                                   onblur="check_accountPassword('accountPassword','oldPwRemind');"/></td>
                        <td id="oldPwRemind" class="hidden"><span class="required">*</span><span
                                class="normal">请输入原来的密码</span><span class="warning hidden"></span><span
                                class="success hidden"></span></td>
                    </tr>
                    <tr id="inputPw1" class="hidden">
                        <td class="tr">新密码：</td>
                        <td><input name="newPassword" type="password" id="newAccountPassword"
                                   onblur="check_newAccountPassword('newAccountPassword','locate1');"/></td>
                        <td id="locate1"><span class="required">*</span><span class="normal">请填写您的新密码，至少6位</span><span
                                class="warning hidden"></span><span class="success hidden"></span></td>
                    </tr>
                    <tr id="inputPw2" class="hidden">
                        <td class="tr">重复新密码：</td>
                        <td><input name="confirmPassword" type="password" id="newAccountPasswordRe"
                                   onblur="check_newAccountPasswordRe('newAccountPasswordRe','locate2','newAccountPassword');"/>
                        </td>
                        <td id="locate2"><span class="required">*</span><span class="normal">请重复填写新密码</span><span
                                class="warning hidden"></span><span class="success hidden"></span></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td><span id="pwChange" class="change">修改密码</span><input name="submit" type="submit" value="保存"
                                                                           id="pwSubmit" class="hidden"/>
                            <button id="pwCancel" class="ml20 hidden">取消</button>
                        </td>
                        <td></td>
                    </tr>
                </table>
            </form>
        </div>
    </div>
    <!--END right_frist content_box-->
</div>
</div>
<!--END main-->
<?php require "foot.php"; ?>