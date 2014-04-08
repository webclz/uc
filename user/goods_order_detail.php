<?php
$title = "账号信息";
require "head.php";
require "../utils/pdo.php";
$exchange_val = $pdo->query("select * from dou_exchange where id=".$_GET['id'],PDO::FETCH_ASSOC)->fetch();
$goods_val = $pdo->query("select * from dou_goods where id=".$exchange_val['goods_id'],PDO::FETCH_ASSOC)->fetch();
?>

<div class="right">
    <div class="content_box boxshadow">
        <div class="content_title">
            <h5 class="pdl10">订单详细信息</h5>
        </div>
        <div class="content">
            <form action="" method="POST">
                <table class="table_person_info">
                   
                    <tr>
                        <td colspan="3" style="font-weight:bold;">物品详情</td>
                    </tr>
                     <tr>
                        <td class="tr">兑换订单号：</td>
                        <td><?php echo $exchange_val['exchange_id'];?>
                        </td>
                        <td></td>
                    </tr>
                    <tr>
                        <td class="tr">物品名称：</td>
                        <td><a href="uc_goods_detail.php?id=<?php echo $goods_val['id'];?>"><?php echo $goods_val['goods_name']?></a>
                        </td>
                        <td></td>
                    </tr>
                    <tr>
                        <td class="tr">型号：</td>
                        <td><?php echo $goods_val['goods_model'];?>
                        </td>
                        <td></td>
                    </tr>
                    <tr>
                        <td class="tr">颜色：</td>
                        <td><?php echo $goods_val['goods_color'];?>
                        </td>
                        <td></td>
                    </tr>
                     <tr>
                        <td class="tr">尺寸：</td>
                        <td><?php echo $goods_val['goods_size'];?>
                        </td>
                        <td></td>
                    </tr>
                    <tr>
                        <td class="tr">积分：</td>
                        <td><?php echo $goods_val['goods_pointer'];?>
                        </td>
                        <td></td>
                    </tr>
                    <tr>
                        <td class="tr">兑换时间：</td>
                        <td><?php echo date("Y-m-d",$exchange_val['exchange_time']);?>
                        </td>
                        <td></td>
                    </tr>
                    <tr>
                        <td class="tr">兑换状态：</td>
                        <td>
                        <?php
                          switch($exchange_val['exchange_status']){
                            case 0:
                                  echo "已提交";
                                  break;
                            case 1:
                                  echo "兑换成功";
                                  break;
                            case 2:
                                  echo "兑换失败";
                                  break;      
                          }
                        ?>
                        </td>
                        <td></td>
                    </tr>
                    <tr>
                        <td colspan="3" style="font-weight:bold;">邮寄详情</td>
                    </tr>
                    <tr>
                        <td class="tr">姓名：</td>
                        <td><?php echo $exchange_val['express_to_name'];?>
                        </td>
                        <td></td>
                    </tr>
                    <tr>
                        <td class="tr">地址：</td>
                        <td><?php echo $exchange_val['express_to_address'];?>
                        </td>
                        <td></td>
                    </tr>
                    <tr>
                        <td class="tr">电话：</td>
                        <td><?php echo $exchange_val['express_to_phone'];?>
                        </td>
                        <td></td>
                    </tr>
                    <tr>
                        <td class="tr">备注：</td>
                        <td><?php echo $exchange_val['express_remark'];?>
                        </td>
                        <td></td>
                    </tr>
                   <!--  <tr>
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
                   </tr> -->
                </table>
            </form>
        </div>
    </div>
    <!--END right_frist content_box-->
</div>
</div>
<!--END main-->
<?php require "foot.php"; ?>