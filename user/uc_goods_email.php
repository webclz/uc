<?php
$title = "账号信息";
require "head.php";
require "../utils/pdo.php";
?>
<script type="text/javascript">


   $(document).ready(function(){
    $("#goods_email").click(function(){
    if(check_mobile('mobile','locate5') && check_realName('realName','locate2') && check_mail('mail','locate6') && check_address('address','locate7') && check_remark('mark','locate8')){
      //将订购信息写入数据表中
          var myData = new Array();
          myData[0] = $('#realName').val();
          myData[1] = $('#mobile').val();
          myData[2] = $('#mail').val();
          myData[3] = $('#address').val();
          myData[4] = $('#goods_id').val();
          myData[5] = $('#mark').val();
          $.ajax({
                    url:"ajax.php?goods",
                    type:"POST",
                    dataType:"json",
                    data:{exchange:myData},
                    error:function(){
                          alert('eeeee');
                                    },
                    success:function(data,status){
                       if(data['success']==1){
                        test2("兑换成功，请注意查收",'goods_order_detail.php?id='+data['id']);
                       }
                    }    
               })
    }else{return false;}
})
})
 
 /* function get_confirm(message){
             scscms_alert("确定兑换吗","confirm",function(){
               var id = message; 

               $.ajax({
                    url:"ajax.php?goods",
                    type:"POST",
                    //dataType:"json",
                    data:{id:id},
                    error:function(){
                    alert('error');
                        },
                    success:function(data,status){
                        if(data == 0){
                            warn("请先完善个人信息");
                        }else if(data ==1){
                            warn("对不起，您的积分不足");
                        }else if(data ==3){
                            ok("兑换成功，请注意查收");
                        }
                    }    
               })
                },function(){
                    return false;
             });
          }*/
</script>
<div class="right">
    <div class="content_box boxshadow">
        <div class="content_title">
            <h5 class="pdl10">邮寄信息填写</h5>
        </div>
        <div class="content">
                <table class="table_person_info">
                    <?php
                    // 根据用户id查询用户的详细信息
                    $v = $pdo->query("select * from dou_uc where id=" . $_SESSION['uid'],PDO::FETCH_ASSOC)->fetch();
                        ?>
                       
                        <form action="" method="post">
                      
                          <tr>
                                <td class="tr">姓名：</td>
                                <td>
                                    <input type="text" name="realName" id="realName"
                                           onblur="check_realName('realName','locate2');"
                                           value="<?php echo trim($v['user_name']); ?>"/>
                                </td>
                                <td id="locate2"><span class="required">*</span><span class="normal">请填写接收人姓名</span><span
                                        class="warning hidden"></span><span class="success hidden"></span></td>
                            </tr>
                          
                            <tr>
                                <td class="tr">手机号：</td>
                                <td>
                                    <input type="text" name="user_phone" id="mobile"
                                           onblur="check_mobile('mobile','locate5');" 
                                            value="<?php echo trim($v['user_phone']); ?>"/>
                                </td>
                                <td id="locate5"><span class="required">*</span><span class="normal">请填写手机号</span><span
                                        class="warning hidden"></span><span class="success hidden"></span></td>
                            </tr>
                            <tr>
                                <td class="tr">电子邮箱：</td>
                                <td>
                                    <input type="text" name="user_email" id="mail"
                                           onblur="check_mail('mail','locate6');"
                                            value="<?php echo trim($v['user_email']); ?>"/>
                                </td>
                                <td id="locate6" ><span class="required">*</span><span class="normal">请填写有效的电子邮箱</span><span
                                        class="warning hidden"></span><span class="success hidden"></span></td>
                            </tr>
                            <tr>
                                <td class="tr">邮寄地址：</td>
                                <td>
                                    <input type="text" name="user_address" id="address"
                                           onblur="check_address('address','locate7');" 
                                            value="<?php echo trim($v['user_address']); ?>"/>
                                </td>
                                <td id="locate7" ><span class="required">*</span><span class="normal">请填写详细的邮寄地址</span><span
                                        class="warning hidden"></span><span class="success hidden"></span></td>
                            </tr>
                            <tr>
                                <td class="tr">备注：</td>
                                <td>
                                   <textarea rows="2" cols="20" id="mark"  onblur="check_remark('mark','locate8');"></textarea>
                                </td>
                                <td id="locate8"><span class="required">*</span><span class="normal">最多可100个汉字</span><span
                                        class="warning hidden"></span><span class="success hidden"></span></td>
                            </tr>
                            <tr>
                                <td></td>
                                <td style="padding-top:7px;"><!-- <span id="goods_email" class="goods_email">修改</span> -->
                                <input type="hidden" name="id" id="goods_id" value="<?php echo $_GET['id'];?>"> 
                                <input type="button" id="goods_email" name="button"  value="确定" />
                                
                                </td>
                                <td></td>
                            </tr>
                        </form>
                </table>
           
    </div>
    <!--END right_frist content_box-->
</div>
</div>
<!--END main-->
<?php require "foot.php"; ?>