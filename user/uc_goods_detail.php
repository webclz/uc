<?php
$title = "账号信息";
require "head.php";
require "../utils/pdo.php";
?>
<script type="text/javascript">
    function get_confirm(message){
             scscms_alert("确定兑换吗","confirm",function(){
              $.ajax({
                    url:"ajax.php?pointer",
                    type:"POST",
                   // dataType:"json",
                    data:{id:message},
                    error:function(){
                    alert('error');
                        },
                    success:function(data,status){
                        if(data==1){
                          window.location.href="uc_goods_email.php?id="+message;
                        }else if(data==2){
                          warn('对不起，您的积分不足无法兑换');
                        }
                    }    
               })
                },function(){
                    return false;
             }); 
            
          }
</script>
<div class="right">
 <?php
                      //根据id查询商品的详细信息
                      $sql = "select * from dou_goods where id=".$_GET['id'];
                      $result = $pdo->query($sql,PDO::FETCH_ASSOC)->fetch(PDO::FETCH_ASSOC);
               ?>
    <div class="content_box boxshadow">
        <div class="content_title">
            <h5 class="pdl10">积分商城</h5>
        </div>
        <div class="content">
       
         <div class="mall_bread"><span class="pdl5 pdr10"><a href="uc_integration_mall.php"><strong>商城首页</strong></a></span>>&nbsp;<span><a href="./uc_integration_mall.php?<?php if(isset($_GET['pointer'])){echo "pointer=".$_GET['pointer'];} if(isset($_GET['class'])){echo "&class=".$_GET['class'];} ?>"><?php echo $_GET['pointer'];?>,<?php echo $_GET['class']; ?>&nbsp;></a></span><?php echo $result['goods_name'];?></a></span></div>          
           <div id="goods_img"><img src="/uc/manage/<?php echo $result['goods_img'];?>" /></div>
           <div id="goods_content">
               <table class="table_person_info">
                   <tr><td>商品名称：</td><td><?php echo $result['goods_name'];?></td></tr>
                   <tr><td>商品种类：</td><td><?php echo $result['goods_type'];?></td></tr>
                   <tr><td>商品型号：</td><td><?php echo $result['goods_model'];?></td></tr>
                   <tr><td>商品尺寸：</td><td><?php echo $result['goods_size'];?></td></tr>
                   <tr><td>商品颜色：</td><td><?php echo $result['goods_color'];?></td></tr>
                   <tr><td>商品积分：</td><td><?php echo $result['goods_pointer'];?></td></tr>
                   <tr><td colspan="2"><button type="button" onclick="get_confirm(<?php echo $_GET['id'];?>)">立即兑换</button> </td></tr>
                   
               </table> 
              
           </div>
           <div class="heng20"></div>
           
           <h4 class="pdl5">商品简介</h4>
           <div class="content"><?php echo $result['goods_introduce'];?></div>
        </div>
    </div>
    <!--END right_frist content_box-->
</div>
</div>
<!--END main-->
<?php require "foot.php"; ?>