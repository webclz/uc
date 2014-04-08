
<?php
      $title = "积分设定录入管理";
      require "head.php";
      include('../utils/upload.php');
      ?>
        <script type="text/javascript">
         //导入数据和计算积分的确认提示框
          function pointer_confirm(){
             scscms_alert("确定要计算积分吗","confirm",function(){
                document.getElementById("form").submit();
                },function(){
             });
          }
       
        function check(){
            var filename = document.getElementById("file1").value;
            //safsafsf
            var strtype=filename.substring(filename.length-3,filename.length);
            strtype=strtype.toLowerCase();
            if(filename==null||filename==""){
            warn('请选择上传的文件');
            return false;
            }else if(strtype != 'xls'){
                warn('上传的文件格式不对，必须为.xls格式');
            return false;
            }else{
               scscms_alert("确定要导入数据吗","confirm",function(){
                document.form1.submit();
                },function(){
             });
            }
            }
        </script>
      <?php
      require "../utils/pdo.php";
      /*
      计算积分
       */
      if(isset($_POST['pointer'])){
        //根据月份查询出交易的信息
        $result = $pdo->query("select * from dou_trade where trade_statue = 0 and hold_benefit=0 and month(trade_time)=".$_POST['mon'])->fetchAll(PDO::FETCH_ASSOC);
        //将账号遍历出一个数组，并删除掉重复的
        $trade_arr = array();
        foreach($result as $v){
            $trade_arr[] = $v['trade_account'];
        }
        $trade_unique = array_unique($trade_arr);
        //将账号作为下标数组  存放此账号的积分
        $trade_account = array();
        foreach($trade_unique as $unique_v){
            $trade_account[$unique_v] = 0;
        }
       
        foreach ($trade_unique as $v_trade) {
            $count=0;
            foreach($result as $val_result){
                if(trim($v_trade)==trim($val_result['trade_account'])){
					if(trim($val_result['goods_type'])=="新华银50千克"){
						$count = $val_result['trade_pay'] * 0.03;
					}else if (trim($val_result['goods_type'])=="新华银15千克") {
						$count = $val_result['trade_pay'] * 0.05;
					}else if (trim($val_result['goods_type'])=="新华银5千克") {
						$count = $val_result['trade_pay'] * 0.2;
					}else if(trim($val_result['goods_type'])=="新华银1克"){
						$count = $val_result['trade_pay'];
					}
                    $trade_account[$v_trade] += $count;

            	}
            }
        }
        $sql = "insert into dou_month_pointer(trade_account,month,pointer,time) values(:trade_account,:month,:pointer,:time)";    
        $stmt = $pdo->prepare($sql);
        foreach($trade_account as $k => $v){
        $time = date("Y-m-d",time());
        $stmt->bindParam(':trade_account', $k);    
        $stmt->bindParam(':month', $_POST['mon']);    
        $stmt->bindParam(':pointer', $v);    
        $stmt->bindParam(':time', $time); 
        $stmt->execute();        
    }
        //将计算过的数据状态设置为1
        $sql_status = "update dou_trade set trade_statue=1 where trade_statue = 0 and hold_benefit=0 and month(trade_time)=" . $_POST['mon'];
        $pdo->exec($sql_status);
           
        //更新用户表的积分数
        foreach($trade_account as $key => $value){
        $sql_pointer = "select user_pointer from dou_uc where trading_account='" . $key . "'";
        $tmp_pointer = $pdo->query($sql_pointer);
        $user_pointer = $tmp_pointer->fetchColumn();
        $sql_update = "update dou_uc set user_pointer=" . ($user_pointer + $value) ." where trading_account='" . $key . "'";
        $pdo->exec($sql_update);
    }
        echo "<script>test2('','计算完毕');</script>";
              }
      /*
      导入数据
       */

     if(isset($_POST['get_data'])){
        //file是上传input的名称 uploads为上传的路径
        $upfos = new ieb_upload('file', 'uploads');
        $upfos->upload($upfos->newName());
        //获得上传文件的路径如uploads/1.jpg
        $img_url = $upfos->filePath();
        $Import_TmpFile = $img_url;  
        require_once '../utils/reader.php'; 
        $data = new Spreadsheet_Excel_Reader(); 
        $data->setOutputEncoding('UTF-8'); 
        $data->read($Import_TmpFile); 
        //$data是对象数据，将其遍历成数组
        $array =array(); 
        for ($i = 1; $i <= $data->sheets[0]['numRows']; $i++) { 
            for ($j = 1; $j <= $data->sheets[0]['numCols']; $j++) { 
                 $array[$i][$j] = $data->sheets[0]['cells'][$i][$j]; 
                    } 
            } 
        //将数据写入trade交易数据表中   
        $sql = "insert into dou_trade(trade_time,institution,mediacy,trade_account,user_name,goods_type,trade_number,trade_pay,level_benefit,hold_benefit,benefit_total,exchange_poundage,membership_poundage,user_poundage) values(:trade_time,:institution,:mediacy,:trade_account,:user_name,:goods_type,:trade_number,:trade_pay,:level_benefit,:hold_benefit,:benefit_total,:exchange_poundage,:membership_poundage,:user_poundage)"; 
        $stmt = $pdo->prepare($sql);
        for($i=1;$i<=count($array);$i++){
                    $stmt->bindParam(':trade_time', $array[$i]['2']); 
                    $stmt->bindParam(':institution', $array[$i]['3']); 
                    $stmt->bindParam(':mediacy', $array[$i]['4']); 
                   // $array[$i]['5'] = trim($array[$i]['5']);
                    $stmt->bindParam(':trade_account', $array[$i]['5']); 
                    $stmt->bindParam(':user_name', $array[$i]['6']); 
                    $stmt->bindParam(':goods_type', $array[$i]['7']); 
                    $stmt->bindParam(':trade_number', $array[$i]['8']); 
                    $stmt->bindParam(':trade_pay', $array[$i]['9']); 
                    $stmt->bindParam(':level_benefit', $array[$i]['10']); 
                    $stmt->bindParam(':hold_benefit', $array[$i]['11']); 
                    $stmt->bindParam(':benefit_total', $array[$i]['12']); 
                    $stmt->bindParam(':exchange_poundage', $array[$i]['13']); 
                    $stmt->bindParam(':membership_poundage', $array[$i]['14']); 
                    $stmt->bindParam(':user_poundage', $array[$i]['15']); 
                    $tag = $stmt->execute();   
         }
         if($tag){
            echo "<script>test2('','导入成功');</script>";
         }      
          }
     
 ?>
    <div class="right">
        <div class="content_box boxshadow">
            <div class="content_title">
                <h5 class="pdl10">积分设定</h5>
            </div>
            <div class="content">
            <form action="" id="form1" name="form1" method="POST" enctype="multipart/form-data">
                <table class="lh30" cellspacing="0">
                    <tr>
                        <td>请选择要导入的数据：</td>
                        <td><input name="file" name="filename" id="file1" type="file"/></td>
                        <input type="hidden" name="get_data" value="1" />
                        <td><input type="button" name="up" value="导入数据" onclick="javascript:check();" /><span style="color:red;">.xls格式</span></td>
                        <td><button value="导出数据" class="change" type="button" onclick="test8('../utils/dou_trade_data.php','确定要导出数据吗')">导出交易信息数据</button> </td>
                    </tr>
                    </form>

                    <form action="" id="form" method="POST" >
                    <tr>
                        <td>选择进行积分操作的月份：</td>
                        <td>
                            <select name="mon">
                                <option value="1">1月</option>
                                <option value="2">2月</option>
                                <option value="3">3月</option>
                                <option value="4">4月</option>
                                <option value="5">5月</option>
                                <option value="6">6月</option>
                                <option value="7">7月</option>
                                <option value="8">8月</option>
                                <option value="9">9月</option>
                                <option value="10">10月</option>
                                <option value="11">11月</option>
                                <option value="12">12月</option>
                            </select>
                            <input type="hidden" name="pointer" value="1">
                            <input type="button"  onclick="pointer_confirm()" class="ml10" value="计算积分">
                        </td>
                        <td></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
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