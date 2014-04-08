<?php
$title = "积分兑换详情";
require "head.php"; 
?>
<script type="text/javascript">
        //兑换成功   发送邮件确认   检验表单内容是否正确 js验证
         function success_confirm(){
             if (check_orderId('orderId','locate1') && check_expressId('expressId','locate2') && check_expressCompany('expressCompany','locate3','expressCompanyOther')) {
                scscms_alert("确定要发送邮件吗","confirm",function(){    
             document.getElementById("mail").submit();          
                },function(){
             }); }else{warn("带*号的为必填信息")};
          }
        //兑换失败  发送邮件确认
        function fail_confirm(){
            if ($("textarea[name='failContent']").val() != "") {
             scscms_alert("确定要发送邮件吗","confirm",function(){
                document.getElementById("mail2").submit();
                },function(){
             });}else{
                warn("请输入兑换失败原因");
             }
          }
</script>
</script>
<?php
require "../utils/pdo.php";
require "../utils/mail.class.php";
?>
<div class="right">
<div class="content_box boxshadow">
<div class="content_title">
    <h5 class="pdl10">积分兑换管理-详情</h5>
</div>
<div class="content">
<table class="lh30" cellspacing="0" width="100%">
<tr>
    <td width="13%"><strong>物品详情</strong></td>
    <td width="50%"></td>
    <td></td>
</tr>
<?php
/*
邮件发送  兑换成功动作 将状态设置1  根据传过来的id查询出用户的邮件
 */
if (isset($_POST['orderId']) && !empty($_POST['orderId'])) {
    $smtpserver = "smtp.163.com"; //SMTP服务器
    $smtpserverport = 25; //SMTP服务器端口
    $smtpusermail = "13067884697@163.com"; //SMTP服务器的用户邮箱
    $smtpemailto = $_POST['user_email']; //发送给谁
    $smtpuser = "13067884697@163.com"; //SMTP服务器的用户帐号
    $smtppass = "ibelieveican1989"; //SMTP服务器的用户密码
    $mailsubject = "Test Subject"; //邮件主题
    $express_name = (empty($_POST['express_name'])||$_POST['express_name']=='empty') ? $_POST['express_name_other'] : $_POST['express_name'];
    $mailbody = "尊敬的会员，" . $_POST['user_name'] . "：<br />您的商品已成功兑换。订单号：" . $_POST['orderId'] . "，运单号:" . $_POST['expressId'] . ",快递公司：" . $express_name . "。"; //邮件内容
    $mailtype = "HTML"; //邮件格式（HTML/TXT）,TXT为文本邮件
    $smtp = new smtp($smtpserver, $smtpserverport, true, $smtpuser, $smtppass); //这里面的一个true是表示使用身份验证,否则不使用身份验证.
    $smtp->debug = FALSE; //是否显示发送的调试信息
    if ($smtp->sendmail($smtpemailto, $smtpusermail, $mailsubject, $mailbody, $mailtype)) {
        // echo "<img src='images/loading.gif' style='margin-left:100px;'>";
        //邮件发送成功以后，change_status 设置为1,已经处理并兑换成功
        $sql = "update dou_exchange set exchange_status=1,order_number='".$_POST['orderId']."',express_number='".$_POST['expressId']."',express_company='".$express_name."' where id=:id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id', $_POST['id']);
        if ($stmt->execute()) {
            echo "<script>test2('','发送成功')</script>";
        }
    } else {
        echo "<script>test4('','发送失败，请确保网络畅通或邮箱正确')</script>";
    }
    /*
    兑换失败 邮件发送动作
     */
}  else if (isset($_POST['failContent']) && !empty($_POST['failContent'])) {
    $smtpserver = "smtp.163.com"; //SMTP服务器
    $smtpserverport = 25; //SMTP服务器端口
    $smtpusermail = "13067884697@163.com"; //SMTP服务器的用户邮箱
    $smtpemailto = $_POST['user_email']; //发送给谁
    $smtpuser = "13067884697@163.com"; //SMTP服务器的用户帐号
    $smtppass = "ibelieveican1989"; //SMTP服务器的用户密码
    $mailsubject = "Test Subject"; //邮件主题
    $mailbody = $_POST['failContent']; //邮件内容
    $mailtype = "TXT"; //邮件格式（HTML/TXT）,TXT为文本邮件
    $smtp = new smtp($smtpserver, $smtpserverport, true, $smtpuser, $smtppass); //这里面的一个true是表示使用身份验证,否则不使用身份验证.
    $smtp->debug = FALSE; //是否显示发送的调试信息
    if ($smtp->sendmail($smtpemailto, $smtpusermail, $mailsubject, $mailbody, $mailtype)) {
        //还原用户的积分 兑换id $_POST['id'] 查询商品的id和用户的id
        $sql_return = "select * from dou_exchange where id=" . $_POST['id'];
        $re = $pdo->query($sql_return, PDO::FETCH_ASSOC)->fetch();
        //根据用户的id和商品的id查询 积分
        $user_pointer = $pdo->query("select user_pointer from dou_uc where id=" . $re['uid'])->fetchColumn();
        $goods_pointer = $pdo->query("select goods_pointer from dou_goods where id=" . $re['goods_id'])->fetchColumn();
        //将状态设置为2 
        $sql = "update dou_exchange set exchange_status=2,fail_content=:fail_content where id=:id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id', $_POST['id']);
        $stmt->bindParam(':fail_content', $_POST['failContent']);
        $stmt->execute();
        //将用户的积分进行更新
        $sql_update = "update dou_uc set user_pointer=" . ($user_pointer + $goods_pointer) ." where id=".$re['uid'];
        if ($pdo->exec($sql_update)) {
            echo "<script>test2('','发送成功')</script>";
        }
    } else {
        echo "<script>test4('','发送失败，请确保网络畅通或邮箱正确')</script>";
    }
} 
/*
查询订单的对应信息
 */
$stmt = $pdo->query("select * from dou_exchange where id=" . $_GET['id']);
$result = $stmt->fetchAll();
foreach ($result as $v){
/*
根据uid查询对应的用户信息
 */
$rs = $pdo->query("select * from dou_uc where id=" . $v['uid']);
$user_v = $rs->fetchAll();
$user_value = array();
foreach ($user_v as $value) {
    $user_value['account'] = $value['user_account'];
    $user_value['phone'] = $value['user_phone'];
    $user_value['name'] = $value['user_name'];
    $user_value['address'] = $value['user_address'];
    $user_value['phone'] = $value['user_phone'];
    $user_value['mail'] = $value['user_email'];
    $user_value['id'] = $value['id'];
}
/*
根据商品id查询商品信息
 */
$rs = $pdo->query("select * from dou_goods where id=" . $v['goods_id']);
$goods_v = $rs->fetchAll(PDO::FETCH_ASSOC);
$goods_value = array();
foreach ($goods_v as $value) {
    $goods_value['goods_name'] = $value['goods_name'];
    $goods_value['goods_pointer'] = $value['goods_pointer'];
    $goods_value['goods_link'] = $value['goods_link'];
}
?>
<tr>
    <td>兑换单号：</td>
    <td><?php echo $v['exchange_id'] ?></td>
    <td></td>
</tr>
<tr>
    <td>兑换物品：</td>
    <td><?php echo $goods_value['goods_name']; ?></td>
    <td></td>
</tr>
<tr>
    <td>物品积分：</td>
    <td><?php echo $goods_value['goods_pointer']; ?></td>
    <td></td>
</tr>
<tr>
    <td>兑换时间：</td>
    <td><?php echo date("Y-m-d", $v['exchange_time']); ?></td>
    <td></td>
</tr>
<tr>
    <td>兑换状态：</td>
    <td><?php if ($v['exchange_status'] == 0) {
           echo "未处理";
        } else if ($v['exchange_status'] == 1) {
            echo "兑换成功已发货";
        } else if($v['exchange_status'] == 2) {
            echo "兑换失败";
        } ?>
       </td>
    <td></td>
</tr>
<tr>
    <td><strong>邮寄详情</strong></td>
    <td></td>
    <td></td>
</tr>
<tr>
    <td>姓名：</td>
    <td><?php echo $v['express_to_name']; ?></td>
    <td></td>
</tr>
<tr>
    <td>地址：</td>
    <td><?php echo $v['express_to_address']; ?></td>
    <td></td>
</tr>
<tr>
    <td>电话：</td>
    <td><?php echo $v['express_to_phone']; ?></td>
    <td></td>
</tr>
<tr>
    <td>物品网链：</td>
    <td class="ft_900"><a href="<?php echo $goods_value['goods_link']; ?>"
                          target="_blank"><?php echo $goods_value['goods_name']; ?><span
                class="pdl10 ft_09c">点击进入商品订购</span></a></td>
    <td></td>
</tr>
<tr>
    <td>
    <strong>
    <?php 
        if ($v['exchange_status'] == 1 || $v['exchange_status'] ==2) {
        echo "处理情况";
        }else {echo "处理";}
    ?>
    </strong>:</td>
    <td><?php if ($v['exchange_status'] == 1 || $v['exchange_status'] ==2) {
       echo "已处理，成功发送邮件！";
    }?></td>
    <td></td>
</tr>
<tr <?php if ($v['exchange_status'] ==0 || $v['exchange_status'] ==2){echo "style='display:none;'";} ?>>
    <td>邮件内容：</td>
    <td><span class="ft_999">尊敬的会员，<?php echo $user_value['name'];?>：<br/>您的商品已成功兑换，订单号：<?php echo $v['order_number']?>，<br/>运单号：<?php echo $v['express_number'];?>,快递公司：<?php echo $v['express_company']?>。</span></td>
    <td></td>
</tr>
<tr <?php if($v['exchange_status'] ==1 || $v['exchange_status'] ==0){echo "style='display:none;'";}?>>
    <td>邮件内容：</td>
    <td><?php echo $v['fail_content'];?></td>
    <td></td>
</tr>
<form action="" id="mail" method="POST" name="mail">
    <tr <?php if ($v['exchange_status'] == 1 || $v['exchange_status'] ==2){echo "style='display:none;'";} ?>>
        <td>订单号：</td>
        <td><input name="orderId" type="text" placeholder="请输入商城订单号" id="orderId"
                   onblur="check_orderId('orderId','locate1');"/></td>
        <td id="locate1"><span class="required">*</span><span class="normal">请输入网络订单号</span><span
                class="warning hidden"></span><span class="success hidden"></span></td>
    </tr>
    <tr <?php if ($v['exchange_status'] == 1 || $v['exchange_status'] ==2){echo "style='display:none;'";} ?>>
        <td>快递单号：</td>
        <td><input name="expressId" type="text" placeholder="请输入商品邮寄快递单号" id="expressId"
                   onblur="check_expressId('expressId','locate2');"/></td>
        <td id="locate2"><span class="required">*</span><span class="normal">请输入快递单号</span><span
                class="warning hidden"></span><span class="success hidden"></span></td>
    </tr>
    <tr <?php if ($v['exchange_status'] == 1 || $v['exchange_status'] ==2){echo "style='display:none;'";} ?>>
        <td>快递公司：</td>
        <td>
            <select name="express_name" id="expressCompany"
                    onblur="check_expressCompany('expressCompany','locate3','expressCompanyOther');"
                    onchange="check_expressCompany('expressCompany','locate3','expressCompanyOther');">
                <option value="empty" selected="selected">请选择快递公司或输入快递公司</option>
                <option value="圆通">圆通</option>
                <option value="申通">申通</option>
                <option value="中通">中通</option>
                <option value="EMS">EMS</option>
                <option value="顺风">顺风</option>
            </select>
            <br/><span class="pdl10 pdr5">其他</span><input name="express_name_other" type="text" placeholder="请输入其他快递公司"
                                                          id="expressCompanyOther"
                                                          onblur="check_expressCompany('expressCompany','locate3','expressCompanyOther');"/>
        </td>
        <td id="locate3"><span class="required">*</span><span class="normal">请选择快递公司</span><span
                class="warning hidden"></span><span class="success hidden"></span></td>
    </tr>
    <!-- 隐藏表单发送兑换id，提交更新状态使用;用户名称发送使用-->
    <input type="hidden" name="id" value="<?php echo $v['id']; ?>">
    <input type="hidden" name="user_name" value="<?php echo $user_value['name']; ?>">
    <input type="hidden" name="user_email" value="<?php echo $v['express_to_email']; ?>">
    <?php } ?>
    <tr>
        <td>&nbsp;</td>
        <td></td>
        <td></td>
    </tr>
    <tr <?php if ($v['exchange_status'] == 1 || $v['exchange_status'] ==2){echo "style='display:none;'";} ?>>
        <td></td>
        <td><span class="ft_999">尊敬的会员，XXX：<br/>您的商品已成功兑换，订单号：XXXXXX，运单号：XXXXX,快递公司：XXXXXX。</span><!-- <button class="fr">发送成功信息</button> --><input
                class="fr" type="button"  onclick="success_confirm()"  name="button" value="发送成功信息"/></td>
        <td><span class="warning pdl10">点击后将发送信息至用户<!-- 手机及 -->邮箱</span></td>
    </tr>
</form>
<tr <?php if ($v['exchange_status'] == 1 || $v['exchange_status'] ==2){echo "style='display:none;'";} ?>>
    <td>&nbsp;</td>
    <td></td>
    <td></td>
</tr>
<form action="" method="POST" id="mail2" name="mail2" >
    <tr <?php if ($v['exchange_status'] == 1 || $v['exchange_status'] ==2){echo "style='display:none;'";} ?>>
        <td>
            <input type="hidden" name="id" value="<?php echo $v['id']; ?>">
            <input type="hidden" name="user_email" value="<?php echo $v['express_to_email']; ?>">
            <input type="hidden" name="user_id" value="<?php echo $_GET['id']; ?>">
        </td>
        <td><textarea name="failContent" style="resize:none; width:200px; height:80px;"
                      placeholder="请输入兑换失败原因"></textarea><!-- button class="fr mt30">发送失败信息</button> --><input
                class="fr mt30" type="button"  onclick="fail_confirm()" name="button" value="发送失败信息"/></td>
        <td><span class="warning pdl10">点击后将发送信息至用户<!-- 手机及 -->邮箱</span></td>
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