
<script type="text/javascript">
/*
ajax  删除商品事件
 */
function del(message){
    scscms_alert("确定要删除吗","confirm",function(){
        $(function(){
            $.ajax({
                url:"ajax.php?goods_del",
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

/*
  添加种类
 */
function type_add(message){
    if(message == ""){
        warn("分类名称不能为空");
        return false;
    }else{
        $(function(){
            $.ajax({
                url:"ajax.php?type_add",
                type:"POST",
                //dataType: "json",
                data:{type_name:message},
                error:function(){alert('error');},
                success:function(data,status){
                    /*if(data=='add_yes'){
                         $("tr[id='"+message+"']").remove();
                         ok('删除成功');
                    }*/
                    if(data == 1){
                        $("#commodityType option").eq(0).after("<option value="+message+">"+message+"</option>");
                        $('#commodityTypeOther').val("");
                        ok("添加成功");
                    }

                }
            })
        })
    }
}
</script>
<?php
$title = "积分商品管理";
require "head.php";?>
<link rel="stylesheet" href="../utils/kindeditor/themes/default/default.css" />
        <script charset="utf-8" src="../utils/kindeditor/kindeditor-min.js"></script>
        <script charset="utf-8" src="../utils/kindeditor/lang/zh_CN.js"></script>
        <script>
            var editor;
            KindEditor.ready(function(K) {
                editor = K.create('textarea[name="goods_introduce"]', {
                    resizeType : 1,
                    allowPreviewEmoticons : false,
                    allowImageUpload : true,
                    width : "130%",
                    //height:60px;
                    items : [
                        'fontname', 'fontsize', '|', 'forecolor', 'hilitecolor', 'bold', 'italic', 'underline',
                        'removeformat', '|', 'justifyleft', 'justifycenter', 'justifyright', 'insertorderedlist',
                        'insertunorderedlist', '|', 'emoticons', 'image', 'link']
                });
            });
        </script>
<?php
require "../utils/pdo.php";
require "../utils/page.class.php";
//引入上传文件的类
include('../utils/upload.php');
if (isset($_POST['typeAdd']) && !empty($_POST['type_name']) && $_POST['type_name'] != 'empty') {
    $stmt = $pdo->prepare("INSERT INTO dou_goods_type(goods_typename) VALUES (:goods_typename)");
    $stmt->bindParam(':goods_typename', $_POST['type_name']);
    if ($stmt->execute()) {
        echo "<script>test2('','添加成功');</script>";
    }
}
if (isset($_POST['submit'])) { 
    /* 商品录入动作*/
    //file是上传input的名称 uploads为上传的路径
    $upfos = new ieb_upload('file', 'uploads');
    $upfos->upload($upfos->newName());
    //获得上传文件的路径如uploads/1.jpg
    $img_url = $upfos->filePath();
    /*if(empty($img_url)){
        echo "<script>test6('添加失败：商品图片为必填项','pointer_commodity.php');</script>";
        return false;
    }*/
    $stmt = $pdo->prepare("INSERT INTO dou_goods(goods_name,goods_type,goods_img,goods_create,goods_pointer,goods_model,goods_size,goods_color,goods_introduce) VALUES (:goods_name,:goods_type,:goods_img,:goods_create,:goods_pointer,:goods_model,:goods_size,:goods_color,:goods_introduce)");
    $time = time();
    $stmt->bindParam(':goods_name', $_POST['goods_name']);
    $stmt->bindParam(':goods_type', $_POST['goods_type']);
    $stmt->bindParam(':goods_img', $img_url);
   // $stmt->bindParam(':goods_link', $_POST['goods_link']);
    $stmt->bindParam(':goods_create', $time);
    $stmt->bindParam(':goods_pointer', $_POST['goods_pointer']);
    $stmt->bindParam(':goods_size', $_POST['goods_size']);
    $stmt->bindParam(':goods_color', $_POST['goods_color']);
    $stmt->bindParam(':goods_model', $_POST['goods_model']);
    $stmt->bindParam(':goods_introduce', $_POST['goods_introduce']);
    if ($stmt->execute()) {
        echo "<script>test2('pointer_commodity.php','添加成功')</script>";
    }} /*else {
        echo "<script>test2('pointer_commodity.php','添加失败，请检查')</script>";
    }
}else if(isset($_POST['submit']) && (empty($_POST['goods_name']) || empty($_POST['goods_type']) || $_POST['goods_type']=='empty' || empty($_POST['goods_link']) || empty($_POST['goods_pointer']))){
    echo "<script>test6('请填写正确的信息','pointer_commodity.php');</script>";
}*/

/*if (!empty($_GET['del'])) {
    $id = $_GET['del'];
    $sql = 'update dou_goods set goods_statue=0 where id=:id';
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id', $id);
    if ($stmt->execute()) {
        echo "<script>test2('pointer_commodity.php','删除成功')</script>";
    } else {
        echo "<script>test2('pointer_commodity.php','删除失败');</script>";
    }
}*/
?>


    <div class="right">
        <div class="content_box boxshadow">
            <div class="content_title">
                <h5 class="pdl10">商品录入</h5>
            </div>
            <div class="content">
                <form action="" method="POST" id="form4" enctype="multipart/form-data" onsubmit=" if(check_commodityName('commodityName','locate1') && cehck_commodityType('commodityType','locate2','commodityTypeOther','addCommodityType') && check_commodityPointer('commodityPointer','locate3') && check_commodityImage('commodityImage','locate5')){
           
            return true;
    }else{warn('请填写正确的信息');return false;}">
                    <table class="lh40" cellspacing="0" width="100%">
                        <tr>
                            <td width="12%">商品名称：</td>
                            <td width="50%"><input type="text" name="goods_name" placeholder="请输入商品名称"
                                                   style="width:290px;" id="commodityName"
                                                   onblur="check_commodityName('commodityName','locate1');"/></td>
                            <td id="locate1"><span class="required">*</span><span class="normal">请填写商品名称</span><span
                                    class="warning hidden"></span><span class="success hidden"></span></td>
                        </tr>
                        <tr>
                            <td>商品分类：</td>
                            <td>
                                <select name="goods_type" id="commodityType"
                                        onblur="cehck_commodityType('commodityType','locate2','commodityTypeOther','addCommodityType');"
                                        onchange="cehck_commodityType('commodityType','locate2','commodityTypeOther','addCommodityType');">
                                    <option value="empty" selected="selected">请选择商品分类</option>
                                    <?php
                                    //遍历 商品类别名称 下拉选择
                                    $stmt = $pdo->query("select * from dou_goods_type");
                                    $result = $stmt->fetchAll();
                                    foreach ($result as $v) {
                                        ?>
                                        <option
                                            value="<?php echo $v['goods_typename']; ?>"><?php echo $v['goods_typename'] ?></option>
                                    <?php } ?>
                                    <option value="other">其他</option>
                                </select>

                                <input type="text" name="type_name"
                                                                                  placeholder="新分类" class="ml5"
                                                                                  style="width:100px;"
                                                                                  id="commodityTypeOther"
                                                                                  onblur="cehck_commodityType('commodityType','locate2','commodityTypeOther','addCommodityType');"/><button
                                        type="button" onclick="type_add($('#commodityTypeOther').val())" name="typeAdd" class="ml5" value="添加分类" id="addCommodityType"/>添加新分类</button>
                               
                            </td>
                            <td id="locate2"><span class="required">*</span><span class="normal">请选择商品分类，若没有请添加分类</span><span
                                    class="warning hidden"></span><span class="success hidden"></span></td>
                        </tr>
                        <tr>
                            <td>兑换积分：</td>
                            <td><input name="goods_pointer" type="text" placeholder="请输入兑换所需积分" id="commodityPointer"
                                       onblur="check_commodityPointer('commodityPointer','locate3');"/><span
                                    class="pdl5">分</span></td>
                            <td id="locate3"><span class="required">*</span><span class="normal">请输入兑换所需积分</span><span
                                    class="warning hidden"></span><span class="success hidden"></span></td>
                        </tr>

                         <tr>
                            <td>商品型号：</td>
                            <td><input name="goods_model" type="text" placeholder="请输入商品的型号" id="goods_model"
                                       /><span
                                    class="pdl5"></span></td>
                            
                        </tr>

                         <tr>
                            <td>商品颜色：</td>
                            <td><input name="goods_color" type="text" placeholder="请输入商品的颜色" id="goods_color"
                                       /><span
                                    class="pdl5"></span></td>
                            
                        </tr>

                         <tr>
                            <td>商品尺寸：</td>
                            <td><input name="goods_size" type="text" placeholder="请输入商品的尺寸" id="commodityPointer"
                                       /><span
                                    class="pdl5"></span></td>
                           
                        </tr>


                        <tr>
                            <td>商品图片：</td>
                            <td><input type="file" name="file" placeholder="请选择商品图片" id="commodityImage"
                                       onblur="check_commodityImage('commodityImage','locate5');"/></td>
                            <td id="locate5"><span class="required">*</span><span class="normal">请选择商品图片</span><span
                                    class="warning hidden"></span><span class="success hidden"></span></td>
                        </tr>
                        <!-- <tr>
                            <td>商品网链：</td>
                            <td><textarea name="goods_link" style="resize:none; width:300px; height:60px;"
                                          placeholder="输入商品网络链接地址。格式：http://……或https://……" id="commodityLink"
                                          onblur="check_commodityLink('commodityLink','locate4');"></textarea></td>
                            <td id="locate4"><span class="required">*</span><span
                                    class="normal">格式：http://……或https://……</span><span
                                    class="warning hidden"></span><span class="success hidden"></span></td>
                        </tr> -->
                         <tr>
                            <td>商品简介：</td>
                            <td><textarea id="123" name="goods_introduce" 
                                        ></textarea></td>
                            <td ></td>
                        </tr>
                        <tr>
                            <td>上架时间：</td>
                            <td><input type="text" name="goods_create" value="" class="border_none" readonly="readonly"
                                       placeholder="系统自动生成"/></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td><input type="submit"  name="submit" value="添加商品"/></td>
                            <td></td>
                        </tr>
                    </table>
                </form>
            </div>
        </div>
        <!--END right_frist content_box-->
        <div class="heng10"></div>
        <div class="content_box boxshadow">
            <div class="content_title">
                <h5 class="pdl10">商品列表</h5>
            </div>
            <div class="content">
                <table class=" table_border lh30 tc" cellspacing="0" width="100%">
                    <tr>
                        <th>商品ID</th>
                        <th>商品名称</th>
                        <th>分类</th>
                        <th>积分</th>
                        <th>上架时间</th>
                        <th width="21%">操作</th>
                    </tr>
                    <?php
                    /*遍历商品，显示最新的4个*/
                    $sql_count = "select count(*) from dou_goods where goods_statue=1";
                    $row_count = $pdo->query($sql_count);
                    $num = $row_count->fetchColumn();
                    $page = new Page($num, 3);
                    $stmt = $pdo->query("select id,goods_name,goods_type,goods_pointer,goods_create from dou_goods where goods_statue=1 order by id desc {$page->limit}");
                    $result = $stmt->fetchAll();
                    foreach ($result as $v) {
                        ?>
                        <tr id="<?php echo $v['id'];?>">
                            <td><?php echo $v['id']; ?></td>
                            <td><?php echo $v['goods_name']; ?></td>
                            <td><?php echo $v['goods_type']; ?></td>
                            <td><?php echo $v['goods_pointer']; ?></td>
                            <td><?php echo date('Y-m-d', $v['goods_create']); ?></td>
                            <td><a href="detail_pointer_commodity.php?id=<?php echo $v['id']; ?>" target="_blank">
                                    <button>详情/修改</button>
                                </a><!-- <a href="?del=<?php echo $v['id'];?>"> -->
                                <button onclick="del(<?php echo $v['id']?>)"
                                        class="ml5">删除
                                </button>
                            </td>
                        </tr>
                    <?php } ?>
                </table>
            </div>
            <div style="margin-left:320px;"><?php echo $page->fpage(4, 5, 6); ?></div>
        </div>
        <!--END right_frist content_box-->
    </div>
    </div>
    <!--END main-->
<?php require "foot.php"; ?>