<?php
$title = "经纪商会员管理";
require "head.php";
require "../utils/pdo.php";
require "../utils/page.class.php";?>
<script type="text/javascript">
//添加终端会员  ajax 方式
$(function(){
    $("#add").click(function(){
        if (check_memberId('user_account','locate1') && check_idCard('user_idcard','locate4') && check_realName('user_name','locate3')) {
        var user = new Array();
        user[0] = $('#user_name').val();
        user[1] = $('#user_account').val();
        //user[2] = $('#trading_account').val();
        user[2] = $('#user_idcard').val();
        $.ajax({
            url:"ajax.php?brokerage",
            type:"POST",
            data:{user_data:user},
            dataType:"json",
            error:function(){
                alert('error');
            },
            success:function(data,status){
                /*if(data=='yes'){
                ok('添加成功');
                $('#user_name').val("");
                $('#user_account').val("");
                $('#user_idcard').val("");
                hid('addTable');
              }*/
              if(data['yes'] == 1){
                        $("#brokerage tr").eq(0).after("<tr id="+data['id']+"><td>"+$('#user_account').val()+"</td><td>"+$('#user_name').val()+"</td><td>"+0+"</td><td><a href='detail_brokerage_member.php?uid="+data['id']+"' target='_blank'><button>详情</button></a>&nbsp;<button onclick='del("+data['id']+")'>删除</button></td></tr>");
                        ok('添加成功');
                        $('#user_name').val("");
                        $('#user_account').val("");
                        $('#user_idcard').val("");
                        hid('addTable');
                       // $("#terminal tr").eq(0).after("<tr><td>"+$('#user_name').val()+"</td><td>"+$('#user_account').val()+"</td><td>"+$('#trading_account').val()+"</td><td>"+$('#user_idcard').val()+"</td><td>caozuo</td></tr>");
               }
            }
        
        })
}else {
            warn('请填写正确的信息');
            return false;
        }


    })
})
/*
    删除终端会员  ajax方式
 */
function del(message){
    scscms_alert("确定要删除吗","confirm",function(){
        $(function(){
            $.ajax({
                url:"ajax.php?del",
                type:"POST",
                data:{del_id:message},
                error:function(){alert('error');},
                success:function(data,status){
                    if(data=='del_yes'){
                         $("tr[id='"+message+"']").remove();
                         ok('删除成功');
                    }
                }
            })
        })
    },function(){
    });
}   

</script>
<?php
/*if (isset($_GET['action'])&&$_GET['action'] == 'add' && !empty($_POST['user_name']) && !empty($_POST['user_account']) && !empty($_POST['user_idcard'])) {
    $user_name = $_POST['user_name'];
    $user_account = $_POST['user_account'];
    //$trading_account=$_POST['trading_account'];
    $user_idcard = $_POST['user_idcard'];
    $user_pwd = md5('777777');
    $time = time();
    //经纪商会员 type=0
    $user_type = 0;
    $stmt = $pdo->prepare("INSERT INTO dou_uc (user_name,user_pwd,user_account,user_idcard,user_create,user_type) VALUES (:user_name,:user_pwd,:user_account,:user_idcard,:user_create,:user_type)");
    $stmt->bindParam(':user_name', $user_name);
    $stmt->bindParam(':user_pwd', $user_pwd);
    $stmt->bindParam(':user_account', $user_account);
    $stmt->bindParam(':user_idcard', $user_idcard);
    $stmt->bindParam(':user_create', $time);
    $stmt->bindParam(':user_type', $user_type);
    if ($stmt->execute()) {
        echo "<script>test2('brokerage_member.php','添加成功')</script>";
        // header('location: ./brokerage_member.php?tag=1');
    }
} else */
/*if (isset($_GET['action'])&&$_GET['action'] == 'del') {
    $uid = $_GET['uid'];
    $sql = 'update dou_uc set user_show=0 where id=:uid';
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':uid', $uid);
    if ($stmt->execute()) {
        echo "<script>test2('brokerage_member.php','删除成功')</script>";
    }*/
/*} else if (isset($_GET['action'])&&$_GET['action'] == 'add' && (empty($_POST['user_name']) || empty($_POST['user_account']) || empty($_POST['trading_account']) || empty($_POST['user_idcard']))) {
    //  header('location: ./brokerage_member.php?tag=3');
    echo "<script>test6('请填写完整信息','brokerage_member.php');</script>";
}*/
?>

<div class="right">
    <div class="content_box boxshadow">
        <div class="content_title">
            <h5 class="pdl10">经纪商会员管理</h5>
        </div>
        <div class="content">
            <button class="fr" onclick="show('addTable');">增加经济商会员</button>
            <div class="heng10"></div>
            <form action="brokerage_member.php?action=add" method="post">
                <table class="line_height30 hidden" id="addTable">
                    <tr>
                        <td>会员账号：</td>
                        <td><input type="text" value="" id="user_account" name="user_account" id="memberId" placeholder="会员账号"
                                   onblur="check_memberId('user_account','locate1');"/></td>
                        <td id="locate1"><span class="required">*</span><span class="normal">请填写终端会员的账号</span><span
                                class="warning hidden"></span><span class="success hidden"></span></td>
                    </tr>

                    <tr>
                        <td>姓名：</td>
                        <td><input id="user_name" type="text" name="user_name" value="" placeholder="姓名" id="realName"
                                   onblur="check_realName('user_name','locate3');"/></td>
                        <td id="locate3"><span class="required">*</span><span class="normal">请填写会员真实姓名</span><span
                                class="warning hidden"></span><span class="success hidden"></span></td>
                    </tr>
                    <tr>
                        <td>身份证号：</td>
                        <td><input type="text" id="user_idcard" name="user_idcard" value="" id="idCard" placeholder="身份证号码"
                                   onblur="check_idCard('user_idcard','locate4');"/></td>
                        <td id="locate4"><span class="required">*</span><span class="normal">请填写会员身份证信息</span><span
                                class="warning hidden"></span><span class="success hidden"></span></td>
                    </tr>
                    <tr>
                        <td>初始密码：</td>
                        <td><input type="text" value="777777" readonly="readonly"/></td>
                        <td><span class="required">*</span><span class="normal">会员账号初始密码固定</span><span
                                class="warning hidden"></span><span class="success hidden"></span></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td><input type="button" id="add" value="提交"/><span class="ml10 button_cancel" onclick="hid('addTable');">取消</span>
                        </td>
                        <td></td>
                    </tr>
                </table>
            </form>
            <div class="heng10"></div>
            <table class="table_border lh30 tc" cellspacing="0" width="100%" id="brokerage">
                <tr>
                    <th>会员账号</th>
                    <th>会员姓名</th>
                    <th>会员积分</th>
                    <th width="15%">操作</th>
                </tr>
                <?php
                $sql_count = "SELECT count(*) FROM dou_uc where user_show=1 and user_type=0";
                $count_val = $pdo->query($sql_count);
                $count = $count_val->fetchColumn();
                $page = new Page($count, 10);
                $stmt = $pdo->query("select id,user_account,trading_account,user_name,user_pointer from dou_uc where user_show=1 and user_type=0 order by id desc {$page->limit}");
                $result = $stmt->fetchAll();
                foreach ($result as $v) {
                    ?>
                    <tr id="<?php echo $v['id'];?>">
                        <td><?php echo $v['user_account']; ?></td>
                        <td><?php echo $v['user_name']; ?></td>
                        <td><?php echo floor($v['user_pointer']); ?></td>
                        <td><a href="detail_terminal_member.php?uid=<?php echo $v['id'] ?>" target="_blank">
                                <button>详情</button>
                            </a>
                            <!-- <button
                                onclick="test8('brokerage_member.php?action=del&uid=<?php echo $v["id"]; ?>','确定要删除吗')">
                                删除
                            </button> -->
                            <button onclick="del(<?php echo $v['id'];?>)" value="删除">删除</button>
                        </td>
                    </tr>
                    <!-- <tr>
                        <td>whf001</td>
                        <td>王海峰</td>
                        <td>2000</td>
                        <td><a href="detail_brokerage_member.php" target="_blank"><button>详情</button></a><button>删除</button></td>
                    </tr>
                    <tr>
                        <td>whf001</td>
                        <td>王海峰</td>
                        <td>2000</td>
                        <td><a href="detail_brokerage_member.php" target="_blank"><button>详情</button></a><button>删除</button></td>
                    </tr> -->
                <?php } ?>
            </table>
        </div>
        <div style="margin-left:320px;"><?php echo $page->fpage(4, 5, 6); ?></div><div><button style="margin-left:520px;" class="change" type="button" onclick="test8('../utils/dou_uc_data.php?type=0','确定要导出数据吗')">导出经纪商会员数据</button>&nbsp;.xls格式</div>
    </div>
    <!--END right_frist content_box-->
</div>
</div>
<!--END main-->
<?php require "foot.php"; ?>
