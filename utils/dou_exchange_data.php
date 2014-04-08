<?php
/*
  导出交易数据表文件
 */
//"type"]=> string(1) "1" ["mon"]=> string(1) "1" ["submit"]=> string(12) "导出数据"
require "pdo.php";
if(isset($_POST['statue'])){
	if($_POST['statue'] == 5){
		$sql = "select * from dou_exchange where (exchange_status=2 or exchange_status=0 or exchange_status=1)";}
	else if($_POST['statue'] == 1){
		$sql = "select * from dou_exchange where (exchange_status=2 or exchange_status=1)";
	}else if($_POST['statue'] == 0){
		$sql = "select * from dou_exchange where exchange_status=0";
	}
}
if(isset($_POST['mon'])){
	$sql .= " and month(FROM_UNIXTIME(exchange_time,'%Y%m%d'))=".$_POST['mon'];
}

$result = $pdo->query($sql,PDO::FETCH_ASSOC)->fetchAll();
function xlsBOF() {
	echo pack("ssssss", 0x809, 0x8, 0x0, 0x10, 0x0, 0x0);
}
function xlsEOF() {
	echo pack("ss", 0x0A, 0x00);
}
function xlsWriteNumber($Row, $Col, $Value) {
	echo pack("sssss", 0x203, 14, $Row, $Col, 0x0);
	echo pack("d", $Value);
}
function xlsWriteLabel($Row, $Col, $Value) {
	$L = strlen($Value);
	echo pack("ssssss", 0x204, 8 + $L, $Row, $Col, 0x0, $L);
	echo $Value;
} 
// prepare headers information
header("Content-Type: application/force-download");
header("Content-Type: application/octet-stream");
header("Content-Type: application/download");
header("Content-Disposition: attachment; filename=\"export_".date("Y-m-d").".xls\"");
header("Content-Transfer-Encoding: binary");
header("Pragma: no-cache");
header("Expires: 0");
xlsBOF();
//第一行将数据表的字段写入
	xlsWriteLabel(0, 0, iconv("UTF-8","GBK","ID号"));
	xlsWriteLabel(0, 1, iconv("UTF-8","GBK","兑换订单号"));
	xlsWriteLabel(0, 2, iconv("UTF-8","GBK","兑换物品ID号"));
	xlsWriteLabel(0, 3, iconv("UTF-8","GBK","兑换时间"));
	xlsWriteLabel(0, 4, iconv("UTF-8","GBK","兑换状态：0未处理1成功2失败"));
	xlsWriteLabel(0, 5, iconv("UTF-8","GBK","商城订单号"));
	xlsWriteLabel(0, 6, iconv("UTF-8","GBK","快递订单号"));
	xlsWriteLabel(0, 7, iconv("UTF-8","GBK","快递公司"));
	xlsWriteLabel(0, 8, iconv("UTF-8","GBK","用户ID号"));
	xlsWriteLabel(0, 9, iconv("UTF-8","GBK","兑换失败内容"));
	xlsWriteLabel(0, 10, iconv("UTF-8","GBK","备添加项"));
	

//将表中的数据写入
for($i=0;$i<count($result);$i++){
    $j=0;
	xlsWriteNumber($i+1, $j++, $result[$i]['id']);
	xlsWriteLabel($i+1, $j++, $result[$i]['exchange_id']);
	xlsWriteLabel($i+1, $j++, $result[$i]['goods_id']);
	//转码成gbk写入
	//$result[$i]['user_name']=iconv("UTF-8","GBK",$result[$i]['user_name']);
	//xlsWriteLabel($i+1, $j++, $result[$i]['user_name']);
	xlsWriteLabel($i+1, $j++, date('Y-m-d H:i:s',$result[$i]['exchange_time']));
	//$result[$i]['user_pwd']=iconv("UTF-8","GBK","保密");
	//xlsWriteLabel($i+1, $j++, $result[$i]['user_pwd']);
	//$result[$i]['goods_type']=iconv("UTF-8","GBK",$result[$i]['goods_type']);
	xlsWriteLabel($i+1, $j++, $result[$i]['exchange_status']);
	xlsWriteLabel($i+1, $j++, $result[$i]['order_number']);
	//$result[$i]['user_address']=iconv("UTF-8","GBK",$result[$i]['user_address']);
	//xlsWriteLabel($i+1, $j++, $result[$i]['user_address']);
	xlsWriteLabel($i+1, $j++, $result[$i]['express_number']);
	$result[$i]['express_company']=iconv("UTF-8","GBK",$result[$i]['express_company']);
	xlsWriteLabel($i+1, $j++, $result[$i]['express_company']);
	xlsWriteLabel($i+1, $j++, $result[$i]['uid']);
	$result[$i]['fail_content']=iconv("UTF-8","GBK",$result[$i]['fail_content']);
	xlsWriteLabel($i+1, $j++, $result[$i]['fail_content']);
	//xlsWriteLabel($i+1, $j++, !empty($result[$i]['user_create']) ? date("Y-m-d",$result[$i]['user_create']) : "");
	xlsWriteLabel($i+1, $j++, $result[$i]['express_add1']);
}
// end exporting
xlsEOF();