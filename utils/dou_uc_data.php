<?php
/*
  导出交易数据表文件
 */

require "pdo.php";
$result = $pdo->query("select * from dou_uc where user_type=".$_GET['type'],PDO::FETCH_ASSOC)->fetchAll();
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
	xlsWriteLabel(0, 1, iconv("UTF-8","GBK","会员账号"));
	xlsWriteLabel(0, 2, iconv("UTF-8","GBK","交易账号"));
	xlsWriteLabel(0, 3, iconv("UTF-8","GBK","会员姓名"));
	xlsWriteLabel(0, 4, iconv("UTF-8","GBK","身份证号"));
	xlsWriteLabel(0, 5, iconv("UTF-8","GBK","用户密码"));
	xlsWriteLabel(0, 6, iconv("UTF-8","GBK","手机号码"));
	xlsWriteLabel(0, 7, iconv("UTF-8","GBK","电子邮箱"));
	xlsWriteLabel(0, 8, iconv("UTF-8","GBK","联系地址"));
	xlsWriteLabel(0, 9, iconv("UTF-8","GBK","用户积分"));
	xlsWriteLabel(0, 10, iconv("UTF-8","GBK","用户类别"));
	xlsWriteLabel(0, 11, iconv("UTF-8","GBK","加入时间"));
	xlsWriteLabel(0, 12, iconv("UTF-8","GBK","是否显示：0否1是"));

//将表中的数据写入
for($i=0;$i<count($result);$i++){
    $j=0;
	xlsWriteNumber($i+1, $j++, $result[$i]['id']);
	xlsWriteLabel($i+1, $j++, $result[$i]['user_account']);
	xlsWriteLabel($i+1, $j++, $result[$i]['trading_account']);
	//转码成gbk写入
	$result[$i]['user_name']=iconv("UTF-8","GBK",$result[$i]['user_name']);
	xlsWriteLabel($i+1, $j++, $result[$i]['user_name']);
	xlsWriteLabel($i+1, $j++, $result[$i]['user_idcard']);
	$result[$i]['user_pwd']=iconv("UTF-8","GBK","保密");
	xlsWriteLabel($i+1, $j++, $result[$i]['user_pwd']);
	//$result[$i]['goods_type']=iconv("UTF-8","GBK",$result[$i]['goods_type']);
	xlsWriteLabel($i+1, $j++, $result[$i]['user_phone']);
	xlsWriteLabel($i+1, $j++, $result[$i]['user_email']);
	$result[$i]['user_address']=iconv("UTF-8","GBK",$result[$i]['user_address']);
	xlsWriteLabel($i+1, $j++, $result[$i]['user_address']);
	xlsWriteLabel($i+1, $j++, $result[$i]['user_pointer']);
	xlsWriteLabel($i+1, $j++, $result[$i]['user_type']);
	xlsWriteLabel($i+1, $j++, !empty($result[$i]['user_create']) ? date("Y-m-d",$result[$i]['user_create']) : "");
	xlsWriteLabel($i+1, $j++, $result[$i]['user_show']);
	
	
}
// end exporting
xlsEOF();