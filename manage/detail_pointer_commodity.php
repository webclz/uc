<script type="text/javascript">
 function check_goods(){
   if($("input[name='goods_name']").val() == "" && $("input[name='goods_pointer']").val() == "" && ($("select[name='goods_type']").val() == "" || $("select[name='goods_type']").val() == "empty") && $("input[name='file']").val() == "" && $("input[name='goods_model']").val() == "" && $("input[name='goods_size']").val() == "" && $("input[name='goods_color']").val() == "" && $("textarea[name='intro']").val() == ""){
    warn("请填写修改的内容");
    return false;
   }else{document.getElementById("form").submit();}
}
</script>
<?php
$title = "积分商品详情";
require "head.php";?>
<link rel="stylesheet" href="../utils/kindeditor/themes/default/default.css" />
        <script charset="utf-8" src="../utils/kindeditor/kindeditor-min.js"></script>
        <script charset="utf-8" src="../utils/kindeditor/lang/zh_CN.js"></script>
        <script>
            var editor;
            KindEditor.ready(function(K) {
                editor = K.create('textarea[name="intro"]', {
                    resizeType : 1,
                    allowPreviewEmoticons : false,
                    allowImageUpload : true,
                    width : "100%",
                    afterBlur:function(){
                      this.sync();
                    },
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
require "../utils/upload.php";
//对商品的url进行检验
/*function url($a){
    $str1 = substr($a,0,7);
    $str2 = substr($a,0,8);
    if((trim($str1)=='http://') || trim($str2)=='https://'){
        return true;
    }else{return false;}
}*/
if (isset($_POST['typeAdd'])) {
    //商品种类添加动作
    $stmt = $pdo->prepare("INSERT INTO dou_goods_type(goods_typename) VALUES (:goods_typename)");
    $stmt->bindParam(':goods_typename', $_POST['type_name']);
    if ($stmt->execute()) {
        echo "<script>test2('','添加分类成功')</script>";
    }
}
/* 对商品信息进行修改  */
if (isset($_POST['change'])&&$_POST['change']==1){
    $upfos = new ieb_upload('file', 'uploads');
    $newName = $upfos->newName();
    $name = $upfos->upload($newName);
    $img_url = $upfos->filePath();
/*
    if (!empty($_POST['goods_link'])) {
        if(url(trim($_POST['goods_link']))){
        $sql = "update dou_goods set goods_link=:goods_link where id=:id";
        $stmt = $pdo->prepare($sql);
        $id = (int)$_POST['id'];
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':goods_link', $_POST['goods_link']);
        $link_change = $stmt->execute();
        }else{
            echo "<script>test6('商品链接必须为http://或https://开头','');</script>";
        }
        
    }
*/
    if (!empty($img_url)) {
        $sql = "update dou_goods set goods_img=:img_url where id=:id";
        $stmt = $pdo->prepare($sql);
        $id = (int)$_POST['id'];
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':img_url', $img_url);
        $img_change = $stmt->execute();
    }
    if (!empty($_POST['goods_name'])) {
        $sql = "update dou_goods set goods_name=:goods_name where id=:id";
        $stmt = $pdo->prepare($sql);
        $id = (int)$_POST['id'];
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':goods_name', $_POST['goods_name']);
        $goods_change = $stmt->execute();
    }
    if (!empty($_POST['goods_type']) && $_POST['goods_type'] != "empty") {
        $sql = "update dou_goods set goods_type=:goods_type where id=:id";
        $stmt = $pdo->prepare($sql);
        $id = (int)$_POST['id'];
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':goods_type', $_POST['goods_type']);
        $type_change = $stmt->execute();
    }
    if (!empty($_POST['goods_pointer'])) {
        $sql = "update dou_goods set goods_pointer=:goods_pointer where id=:id";
        $stmt = $pdo->prepare($sql);
        $id = (int)$_POST['id'];
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':goods_pointer', $_POST['goods_pointer']);
        $pointer_change = $stmt->execute();
    }
    if(isset($_POST['goods_model'])&&!empty($_POST['goods_model'])){
        $sql = "update dou_goods set goods_model=:goods_model where id=:id";
        $stmt = $pdo->prepare($sql);
        $id = (int)$_POST['id'];
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':goods_model', $_POST['goods_model']);
        $model_change = $stmt->execute();
    }

    if(isset($_POST['goods_size'])&&!empty($_POST['goods_size'])){
        $sql = "update dou_goods set goods_size=:goods_size where id=:id";
        $stmt = $pdo->prepare($sql);
        $id = (int)$_POST['id'];
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':goods_size', $_POST['goods_size']);
        $size_change = $stmt->execute();
    }

    if(isset($_POST['goods_color'])&&!empty($_POST['goods_color'])){
        $sql = "update dou_goods set goods_color=:goods_color where id=:id";
        $stmt = $pdo->prepare($sql);
        $id = (int)$_POST['id'];
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':goods_color', $_POST['goods_color']);
        $color_change = $stmt->execute();
    }

   if(isset($_POST['intro'])&&!empty($_POST['intro'])){
        $sql = "update dou_goods set goods_introduce=:intro where id=:id";
        $stmt = $pdo->prepare($sql);
        $id = (int)$_POST['id'];
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':intro', $_POST['intro']);
        $introduce_change = $stmt->execute();
    }


    if($img_change || $goods_change || $type_change || $pointer_change ||$link_change || $color_change || $model_change || $size_change || $introduce_change){
        echo "<script>test2('','修改成功')</script>";
    }
}
?>
    <div class="right">
        <div class="content_box boxshadow">
            <div class="content_title">
                <h5 class="pdl10">积分商品详情</h5>
            </div>
            <div class="content">
                <form action="" method="POST" id="form" name="form" enctype="multipart/form-data">
                    <table class="table_border lh40 tc" cellspacing="0" width="100%">
                        <?php
                        //根据id查询商品的详细信息
                        $stmt = $pdo->query("select * from dou_goods where id=" . $_GET['id']);
                        $result = $stmt->fetchAll();
                        foreach ($result as $v) {
                            ?>
                            <tr>
                                <td width="15%">商品ID：</td>
                                <td width="45%"><?php echo $v['id']; ?></td>
                                <td width="40%"><strong>修改</strong></td>
                            </tr>
                            <tr>
                                <td>商品名称：</td>
                                <td><?php echo $v['goods_name']; ?></td>
                                <td><input name="goods_name" type="text" placeholder="新商品名称"/></td>
                            </tr>
                            <tr>
                                <td>图片：</td>
                                <td><img src="<?php echo $v['goods_img']; ?>"
                                         style="max-height:180px; max-width:170px;"/></td>
                                <td><input type="file" name="file"/></td>
                            </tr>
                            <tr>
                                <td>分类：</td>
                                <td><?php echo $v['goods_type']; ?></td>
                                <td>
                                    <select name="goods_type">
                                        <option value="empty">请选择商品分类</option>
                                        <?php
                                        //遍历 商品类别名称 下拉选择
                                        $stmt = $pdo->query("select * from dou_goods_type");
                                        $result_type = $stmt->fetchAll();
                                        foreach ($result_type as $vv) {
                                            ?>
                                            <option
                                                value="<?php echo $vv['goods_typename']; ?>"><?php echo $vv['goods_typename'] ?></option>
                                        <?php } ?>
                                        <option value="other">其他</option>
                                    </select>
                                    <br/>

                                    <form name="form2" action="" method="POST"><input name="type_name" type="text"
                                                                                      name="typeAdd" placeholder="新分类"
                                                                                      class="ml5" style="width:100px;"/><input
                                            type="submit" name="typeAdd" class="ml5" value="添加分类"/></form>
                                </td>
                            </tr>
                            <tr>
                                <td>兑换积分：</td>
                                <td><?php echo $v['goods_pointer']; ?></td>
                                <td><input id="goods_pointer" name="goods_pointer" type="text" placeholder="新积分"/></td>
                            </tr>
                            <tr>
                                <td>商品型号：</td>
                                <td><?php echo $v['goods_model']; ?></td>
                                <td><input id="goods_model" name="goods_model" type="text" placeholder="新型号"/></td>
                            </tr>
                            <tr>
                                <td>商品尺寸：</td>
                                <td><?php echo $v['goods_size']; ?></td>
                                <td><input id="goods_size" name="goods_size" type="text" placeholder="新尺寸"/></td>
                            </tr>
                            <tr>
                                <td>商品颜色：</td>
                                <td><?php echo $v['goods_color']; ?></td>
                                <td><input id="goods_color" name="goods_color" type="text" placeholder="新颜色"/></td>
                            </tr>
                          <!--   <tr>
                               <td>商品网链：</td>
                               <td class="ft_09c"><a href="<?php echo $v['goods_link'];?>"
                                                     target="_blank"><?php echo $v['goods_link']; ?></a></td>
                               <td>
                                   <textarea id="goods_link" name="goods_link" placeholder="新的网络链接地址："
                                             style="width:270px; height:60px; resize:none;"></textarea>
                               </td>
                           </tr> --> <tr>
                                <td>商品简介：</td>
                                <td>
                                                     <?php echo $v['goods_introduce']; ?></td>
                                <td>
                                    <textarea id="intro" name="intro" 
                                             ></textarea>
                                </td>
                            </tr>
                    <input type="hidden" name="id" value="<?php echo $v['id']; ?>"/>
                    <input type="hidden" name="change" value="1"/>
                            <tr>
                                <td>上架时间：</td>
                                <td><?php echo date("Y-m-d", $v['goods_create']); ?></td>
                                <td><input  name="button" type="button" onclick="check_goods()" value="确认修改并提交"/></td>
                            </tr>
                        <?php } ?>
                    </table>
                </form>
            </div>
        </div>
        <!--END right_frist content_box-->
    </div>
    </div>
    <!--END main-->
<?php require "foot.php"; ?>