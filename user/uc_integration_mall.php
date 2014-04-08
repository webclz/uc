<?php
$title = "积分商城";
require "head.php";
require "../utils/pdo.php";
require "../utils/page.class.php";
require "../utils/redirect.class.php";
?>
<!--END left-->
<div class="right">
    <div class="content_box boxshadow">
        <div class="content_title">
            <h5 class="pdl10">积分商城</h5>
        </div>
        <div class="content">
           <div class="mall_bread"><span class="pdl5 pdr10"><a href="uc_integration_mall.php"><strong>商城首页></strong></a></span><?php if(isset($_GET['pointer'])){echo $_GET['pointer']."&nbsp";}else{echo "全部积分";}?></span>,<span>&nbsp;<?php if(isset($_GET['class'])){echo $_GET['class'];}else{echo "全部分类";}?></span></div>
            <div class="mall_chose">
                <ul id="mall_chose_list">
                    <li><a <?php if(empty($_GET['pointer'])){echo "style='background:#09c;color:#FEFFFF;'";}?> href="?<?php utils::urlManage(array('pointer'=>'all'))?>">全部</a></li>
                    <li><a <?php if($_GET['pointer'] == '1~100'){echo "style='background:#09c;color:#FEFFFF;'";}?> href="?<?php utils::urlManage(array('pointer'=>'1~100'))?>">1~100积分</a></li>
                    <li><a <?php if($_GET['pointer'] == '101~500'){echo "style='background:#09c;color:#FEFFFF;'";}?> href="?<?php utils::urlManage(array('pointer'=>'101~500'))?>">101~500积分</a></li>
                    <li><a <?php if($_GET['pointer'] == '501~1000'){echo "style='background:#09c;color:#FEFFFF;'";}?> href="?<?php utils::urlManage(array('pointer'=>'501~1000'))?>">501~1000积分</a></li>
                    <li><a <?php if($_GET['pointer'] == '1001~1500'){echo "style='background:#09c;color:#FEFFFF;'";}?> href="?<?php utils::urlManage(array('pointer'=>'1001~1500'))?>">1001~1500积分</a></li>
                    <li><a <?php if($_GET['pointer'] == '1501~2000'){echo "style='background:#09c;color:#FEFFFF;'";}?> href="?<?php utils::urlManage(array('pointer'=>'1501~2000'))?>">1501~2000积分</a></li>
                </ul>
                <script type="text/javascript">
                	$(document).ready(function(e) {
                        var text = $("#pointer_chose").text();
						var length = $("#mall_chose_list").children("li").length;
						for(var i=0;i<length;i++){
							var tag=null;
							tag=$("#mall_chose_list li:eq("+i+")");
							if(tag.children("a").text()==text){
								tag.addClass("mall_chose_active");
							}
						}
					})
                </script>
                <div class="heng10"></div>
                <?php
                    $type_val = $pdo->query("select goods_typename from dou_goods_type",PDO::FETCH_ASSOC)->fetchAll();
                ?>
                <ul id="mall_chose_list2">
                    <li><a <?php if(empty($_GET['class'])){echo "style='background:#09c;color:#FEFFFF;'";}?> href="?<?php utils::urlManage(array('class'=>'all'))?>">全部</a></li>
                     <?php
                    foreach($type_val as $val_name){
                    ?>
                    <li><a <?php if($_GET['class']== $val_name['goods_typename']){echo "style='background:#09c;color:#FEFFFF;'";}?> href="?<?php utils::urlManage(array('class'=>$val_name['goods_typename']))?>"><?php echo $val_name['goods_typename'];?></a></li>
                    <?php
                        }
                    ?>
                </ul>
            </div>
            <!--END mall_chose-->
            <div class="content">
                <?php
                /*商品输出  根据积分进行搜索*/
                if (isset($_GET['pointer'])) {
                    $arr = explode('~', $_GET['pointer']);
                    $sql_count = "select count(*) from dou_goods where goods_pointer>" . $arr[0] . " and goods_pointer <" . $arr[1] ." and goods_statue=1";
                } else {
                    $sql_count = "select count(*) from dou_goods where goods_statue=1";
                }
                if(isset($_GET['class'])){
                    $sql_count.=" and goods_type='".$_GET['class']."'";
                }
                $row_count = $pdo->query($sql_count);
                $num = $row_count->fetchColumn();
                $page = new Page($num, 6);
                if (isset($_GET['pointer'])) {
                    $sql_page = "select * from dou_goods where goods_pointer>" . $arr[0] . " and goods_pointer <" . $arr[1] ." and goods_statue=1";
                } else {
                    $sql_page = "select * from dou_goods where goods_statue=1";
                }
                if(isset($_GET['class'])){
                    $sql_page.=" and goods_type='".$_GET['class']."'";
                }
                $sql_page.=" order by id desc {$page->limit}";
                $stmt = $pdo->query($sql_page);

                $result = $stmt->fetchAll();
                foreach ($result as $v) {
                    ?>
                    <div class="mall_commodity">
                        <div class="mall_commodity_pic">
                            <img width="170" height="170" src="/uc/manage/<?php echo $v['goods_img']; ?>"/>
                        </div>
                        <div class="mall_commodity_info">
                            <p><?php echo $v['goods_name']; ?></p>
                            <span>积分：<?php echo $v['goods_pointer']; ?></span>
                            <!-- <button type="button" onclick="test8('uc_integration_mall.php?order=<?php echo $v["id"]; ?>','确定要兑换吗')">
                                立即兑换
                            </button> -->
                            <!-- <button type="button" onclick="get_confirm(<?php echo $v['id'];?>)">立即兑换</button> -->
                            <a href="uc_goods_detail.php?id=<?php echo $v['id'];?>&pointer=<?php if(isset($_GET['pointer'])){echo $_GET['pointer'];}else{echo '全部积分';};?>&class=<?php if(isset($_GET['class'])){echo $_GET['class'];}else{echo '全部分类';};?>"><button type="button">查看详情</button></a>
                        </div>
                    </div>
                <?php
                }
                ?>

                <!--  <div class="mall_commodity">
                    <div class="mall_commodity_pic">
                        <a href="#"><img src="images/commidity_pic.jpg" /></a>
                    </div>
                    <div class="mall_commodity_info">
                        <p><a href="#">联想电脑 Y-550</a></p>
                        <span>积分：34000</span><button>立即兑换</button>
                    </div>
                </div>
                <div class="mall_commodity">
                    <div class="mall_commodity_pic">
                        <a href="#"><img src="images/commidity_pic.jpg" /></a>
                    </div>
                    <div class="mall_commodity_info">
                        <p><a href="#">联想电脑 Y-550</a></p>
                        <span>积分：34000</span><button>立即兑换</button>
                    </div>
                </div>
                <div class="mall_commodity">
                    <div class="mall_commodity_pic">
                        <a href="#"><img src="images/commidity_pic.jpg" /></a>
                    </div>
                    <div class="mall_commodity_info">
                        <p><a href="#">联想电脑 Y-550</a></p>
                        <span>积分：34000</span><button>立即兑换</button>
                    </div>
                </div>
                <div class="mall_commodity">
                    <div class="mall_commodity_pic">
                        <a href="#"><img src="images/commidity_pic.jpg" /></a>
                    </div>
                    <div class="mall_commodity_info">
                        <p><a href="#">联想电脑 Y-550</a></p>
                        <span>积分：34000</span><button>立即兑换</button>
                    </div>
                </div>
                <div class="mall_commodity">
                    <div class="mall_commodity_pic">
                        <a href="#"><img src="images/commidity_pic.jpg" /></a>
                    </div>
                    <div class="mall_commodity_info">
                        <p><a href="#">联想电脑 Y-550</a></p>
                        <span>积分：34000</span><button>立即兑换</button>
                    </div>
                </div>
                <div class="mall_commodity">
                    <div class="mall_commodity_pic">
                        <a href="#"><img src="images/commidity_pic.jpg" /></a>
                    </div>
                    <div class="mall_commodity_info">
                        <p><a href="#">联想电脑 Y-550</a></p>
                        <span>积分：34000</span><button>立即兑换</button>
                    </div>
                </div> -->
            </div>
            <!--END mall_commodity-->
            <div style="margin-left:320px;"><?php echo $page->fpage(4, 5, 6); ?></div>
        </div>
    </div>
    <!--END right_frist content_box-->
</div>
</div>
<!--END main-->
<?php require "foot.php"; ?>
