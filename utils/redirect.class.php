<?php
/*
   页面跳转的方法
 */
class utils{
	//跳转函数
	public function redirect($url){
			 echo "<script language='javascript' type='text/javascript'>";
                    echo "window.location.href='$url'";
                    echo "</script>";
	}


	public static function urlManage($p){

       $param=array();
       if(isset($_GET['pointer'])){
           $param['pointer']=$_GET['pointer'];
       }
       if(isset($_GET['class'])){
           $param['class']=$_GET['class'];
       }
       $param=array_merge($param,$p);
       unset($param[array_search("all", $param)]);
       unset($param['page']);
       //  [yid] => 7 [sid] => 2 [hid] => 4 [city] => 0
       $url_param='';
       foreach($param as $k =>$v){
           $url_param.=$k.'='.$v.'&';
       }
       $url_param=rtrim($url_param,'&');
      echo  $url_param;
   }


}

function url($a){
	$str = substr($a,0,5);
	echo $str;
}