<?php
$title = "抽奖活动管理";
require "head.php";?>
<script type="text/javascript">
   function del(message){
    /*scscms_alert("确定要删除吗","confirm",function(){*/
        $(function(){
           // var myData = new Array();
          //  myData[0] = message1;
          //  myData[1] = message2;
            $.ajax({
                url:"ajax.php?statue",
                type:"POST",
               // dataType:json,
                data:{myData:message},
                error:function(){alert('error');},
                success:function(data,status){
                    if(data==1){
                      scscms_alert("改为未处理，1秒自动关闭","ok","",1);
                       $("#"+message).html("未处理");
                    }else if(data==2){
                      scscms_alert("改为已处理，1秒自动关闭","ok","",1);
                        $("#"+message).html("已处理");
                    }
                }
            })
        })
   /* },function(){
        
    });*/
}   
</script>
<?php
require "../utils/pdo.php";
require "../utils/page.class.php";
?>
<div class="right">
    <div class="content_box boxshadow">
        <div class="content_title">
            <h5 class="pdl10">抽奖活动管理</h5>
        </div>
        <div class="content">
           <table class="table_border line_height30" width="100%" cellspacing="0">
                    <tr>
                        <td class="tc" width="20%"><strong>时&nbsp;&nbsp;&nbsp;&nbsp;间</strong></td>
                        <td class="tc" width="20%"><strong>抽奖项目</strong></td>
                        <td class="tc" width="20%"><strong>中奖会员</strong></td>
                        
                        <td class="tc" width="25%"><strong>奖项</strong></td>
                        <td class="tc" width="15%"><strong>操作</strong></td>
                    </tr>
                    <?php
                        /*
                        查询用户中奖纪录
                         */
                        $rotate_count = $pdo->query("select count(*) from dou_rotate where statue=1 or statue=2",PDO::FETCH_ASSOC)->fetchColumn();
                        $page = new Page($rotate_count, 3);
                        $sql_page = "select * from dou_rotate where statue=1 or statue=2 order by id desc {$page->limit}";
                        $res = $pdo->query($sql_page);
                        $result_v = $res->fetchAll(PDO::FETCH_ASSOC);
                        foreach($result_v as $value){
                    ?>
                    <tr >
                        <td class="tc" ><?php echo date("Y-m-d",$value['created']);?></td>
                        <td class="tc"><?php echo $value['project'];?></td>
                        <td class="tc"><a href="detail_terminal_member.php?uid=<?php echo $value['uid'];?>">
                            <?php
                                $user_result=$pdo->query("select user_name,user_phone from dou_uc where id=".$value['uid'],PDO::FETCH_ASSOC)->fetchAll();
                                $user_name = $user_result[0]['user_name'];
                                $user_phone = $user_result[0]['user_phone'];
                                echo $user_name;
                            ?>
                        </td>
                        <td class="tc" ><?php echo $value['lottery'];?></td>
                        <td class="tc" ><div style="height:45px;width:auto;background:url('./images/rotate_bg.png') no-repeat;background-position: center;line-height: 43px;cursor:pointer" id="<?php echo $value['id'];?>" onclick="del(<?php echo $value['id'];?>)">
                        <?php
                           if($value['statue'] ==1){
                                echo "未处理";
                            }else if($value['statue'] ==2){
                                echo "已处理";
                            }
                        ?>
                        </div></td>
                    </tr>
                    <?php  } ?>
                    </table>
        </div>
        <div style="margin-left:320px;"><?php echo $page->fpage(4, 5, 6); ?></div>
    </div>
    <!--END right_frist content_box-->
</div>
</div>
<!--END main-->
<?php require "foot.php"; ?>
