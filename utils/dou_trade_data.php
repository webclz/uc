<?php
/*
  导出交易数据表文件
 */
require "pdo.php";
$col = $pdo->query("show columns from dou_trade",PDO::FETCH_ASSOC)->fetchAll();
$result = $pdo->query("select * from dou_trade",PDO::FETCH_ASSOC)->fetchAll();
$columns_array = array();
for($i=0;$i<count($col);$i++){
		$columns_array[]=$col[$i]['Field'];
	
}
array_unshift($result,$columns_array);
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
	xlsWriteLabel(0, 1, iconv("UTF-8","GBK","结算日期"));
	xlsWriteLabel(0, 2, iconv("UTF-8","GBK","机构"));
	xlsWriteLabel(0, 3, iconv("UTF-8","GBK","居间"));
	xlsWriteLabel(0, 4, iconv("UTF-8","GBK","交易账号"));
	xlsWriteLabel(0, 5, iconv("UTF-8","GBK","客户名称"));
	xlsWriteLabel(0, 6, iconv("UTF-8","GBK","交易种类"));
	xlsWriteLabel(0, 7, iconv("UTF-8","GBK","成交量"));
	xlsWriteLabel(0, 8, iconv("UTF-8","GBK","成交金额"));
	xlsWriteLabel(0, 9, iconv("UTF-8","GBK","平仓盈亏"));
	xlsWriteLabel(0, 10, iconv("UTF-8","GBK","持仓盈亏"));
	xlsWriteLabel(0, 11, iconv("UTF-8","GBK","盈亏合计"));
	xlsWriteLabel(0, 12, iconv("UTF-8","GBK","交易所存留手续费"));
	xlsWriteLabel(0, 13, iconv("UTF-8","GBK","综合会员存留手续费"));
	xlsWriteLabel(0, 14, iconv("UTF-8","GBK","收客户手续费"));
	xlsWriteLabel(0, 15, iconv("UTF-8","GBK","1已处理0未处理"));
	xlsWriteLabel(0, 16, iconv("UTF-8","GBK","备添加项1"));
	xlsWriteLabel(0, 17, iconv("UTF-8","GBK","备添加项2"));

//将表中的数据写入
for($i=1;$i<count($result);$i++){
    $j=0;
	xlsWriteNumber($i, $j++, $result[$i]['id']);
	xlsWriteLabel($i, $j++, $result[$i]['trade_time']);
	$result[$i]['institution']=iconv("UTF-8","GBK",$result[$i]['institution']);
	xlsWriteLabel($i, $j++, $result[$i]['institution']);
	$result[$i]['medicy']=iconv("UTF-8","GBK",$result[$i]['mediacy']);
	xlsWriteLabel($i, $j++, $result[$i]['mediacy']);
	xlsWriteLabel($i, $j++, $result[$i]['trade_account']);
	//转码成gbk写入
	$result[$i]['user_name']=iconv("UTF-8","GBK",$result[$i]['user_name']);
	xlsWriteLabel($i, $j++, $result[$i]['user_name']);
	$result[$i]['goods_type']=iconv("UTF-8","GBK",$result[$i]['goods_type']);
	xlsWriteLabel($i, $j++, $result[$i]['goods_type']);
	xlsWriteLabel($i, $j++, $result[$i]['trade_number']);
	xlsWriteLabel($i, $j++, $result[$i]['trade_pay']);
	xlsWriteLabel($i, $j++, $result[$i]['level_benefit']);
	xlsWriteLabel($i, $j++, $result[$i]['hold_benefit']);
	xlsWriteLabel($i, $j++, $result[$i]['benefit_total']);
	xlsWriteLabel($i, $j++, $result[$i]['exchange_poundage']);
	xlsWriteLabel($i, $j++, $result[$i]['membership_poundage']);
	xlsWriteLabel($i, $j++, $result[$i]['user_poundage']);
	xlsWriteLabel($i, $j++, $result[$i]['trade_statue']);
	xlsWriteLabel($i, $j++, $result[$i]['add1']);
	xlsWriteLabel($i, $j++, $result[$i]['add2']);
	
}
// end exporting
xlsEOF();