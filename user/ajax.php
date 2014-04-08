<?php
session_start();
require "../utils/pdo.php";
function exchange_id()
{
    $exchange_id = "DH" . date("YmdHi") . rand(0, 9) . rand(0, 9) . rand(0, 9);
    return $exchange_id;
}
if(isset($_GET['goods'])){
   // $sql = "select user_email from dou_uc where id=".$_SESSION['uid'];
  //  $user_result = $pdo->query($sql,PDO::FETCH_ASSOC)->fetch();
   /* if(empty($user_result['user_email'])){
        //echo "<script>test9('uc_index.php','请先完善个人信息','uc_integration_mall.php')</script>";
        $email= 0;
        echo $email;}
    else{*/
    $goods_id = $_POST['exchange'][4];
    //$goods_id = $_POST['id'];
    //判断用户积分是否可以兑换  根据商品id查询商品的积分
    $goods_sql = "select goods_pointer from dou_goods where id=" . $goods_id;
    $tmp_result1 = $pdo->query($goods_sql);
    $goods_pointer = $tmp_result1->fetchColumn();
    //查询用户剩余积分
    $user_sql = "select user_pointer from dou_uc where id=" . $_SESSION['uid'];
    $tmp_result2 = $pdo->query($user_sql);
    $user_pointer = $tmp_result2->fetchColumn();
    /*if ($user_pointer < $goods_pointer) {
       	  $return_param = array();
          $return_param['success'] = 0;
          echo $return_param;}else{*/
        	$stmt = $pdo->prepare("INSERT INTO dou_exchange(exchange_id,goods_id,exchange_time,uid,express_to_name,express_to_address,express_to_phone,express_to_email,express_remark) VALUES (:exchange_id,:goods_id,:exchange_time,:uid,:express_to_name,:express_to_address,:express_to_phone,:express_to_email,:express_remark)");
        	$uid = $_SESSION['uid'];
          $time = time();
        	$exchange_id = exchange_id();
          $express_to_name = $_POST['exchange'][0];
          $express_to_address = $_POST['exchange'][3];
          $express_to_phone = $_POST['exchange'][1];
          $express_to_email = $_POST['exchange'][2];
          $express_remark = $_POST['exchange'][5];
        	$stmt->bindParam(':exchange_id', $exchange_id);
        	$stmt->bindParam(':goods_id', $goods_id);
        	$stmt->bindParam(':exchange_time', $time);
          $stmt->bindParam(':express_to_name', $express_to_name);
          $stmt->bindParam(':express_to_address', $express_to_address);
          $stmt->bindParam(':express_to_phone', $express_to_phone);
          $stmt->bindParam(':express_to_email', $express_to_email);
          $stmt->bindParam(':express_remark', $express_remark);
        	$stmt->bindParam(':uid', $uid);
        	$sql_update = "update dou_uc set user_pointer=" . ($user_pointer - $goods_pointer) ." where id=".$_SESSION['uid'];
        	if($pdo->exec($sql_update)&&$stmt->execute()){
        		$return_param = array();
            $return_param['success'] = 1;
            $return_param['id'] = $pdo->lastInsertId();
            echo json_encode($return_param);
        	}
      //  }
   // } 
}
/*
    响应抽奖转盘 ajax
 */
if(isset($_GET['cj'])){
    //根据click_yes  判断用户是否可以参加抽奖  当param：click_yes==1时候可以抽奖  click_yes==0时候不可以抽奖
    $sql = "select user_pointer from dou_uc where id=".$_SESSION['uid'];
    $pointer_count = $pdo->query($sql)->fetchColumn();
    $pointer_count>=100 ? $click_yes=1 : $click_yes=0;
    if($click_yes == 1){
      // 随机产生得将字符
      $code = mt_rand(101,200);
      //  将抽奖的积分写入数据表中
      $uid = $_SESSION['uid'];
      $pointer = 100;
      $time = time();
      $project = "转盘抽奖";
      if($code>=136 && $code<=150){
               $sql_user = "update dou_uc set user_pointer=" . ($pointer_count + 150) ." where id=".$_SESSION['uid'];
               $lottery = "获得200积分";
               $sql = "insert into dou_rotate(uid,pointer,lottery,created,project) values(".$uid.",".$pointer.",'".$lottery."',".$time.",'".$project."')";
               if($pdo->exec($sql_user) &&  $pdo->exec($sql)){   
                     echo $code; 
               }
      }else if($code ==3){
              $sql_user = "update dou_uc set user_pointer=" . ($pointer_count - 100) ." where id=".$_SESSION['uid'];
              $lottery = "获得三等奖";
              $statue =1;
              $sql = "insert into dou_rotate(uid,pointer,lottery,created,project,statue) values(".$uid.",".$pointer.",'".$lottery."',".$time.",'".$project."',".$statue.")";
              if($pdo->exec($sql_user) &&  $pdo->exec($sql)){   
                   echo $code; 
              }
      }else if($code>=151 && $code<=175){
           // $sql_user = "update dou_uc set user_pointer=" . ($pointer_count - 100) ." where id=".$_SESSION['uid'];
              $lottery = "获得100积分";
              $sql = "insert into dou_rotate(uid,pointer,lottery,created,project) values(".$uid.",".$pointer.",'".$lottery."',".$time.",'".$project."')";
              if($pdo->exec($sql)){   
                   echo $code; }
      }else if($code>=101 && $code<=120){
              $sql_user = "update dou_uc set user_pointer=" . ($pointer_count - 50) ." where id=".$_SESSION['uid'];
              $lottery = "获得50积分";
              $sql = "insert into dou_rotate(uid,pointer,lottery,created,project) values(".$uid.",".$pointer.",'".$lottery."',".$time.",'".$project."')";
              if($pdo->exec($sql_user) &&  $pdo->exec($sql)){   
                   echo $code; }
      }else if($code ==1){
              $sql_user = "update dou_uc set user_pointer=" . ($pointer_count - 100) ." where id=".$_SESSION['uid'];
              $lottery = "获得一等奖";
              $statue =1;
              $sql = "insert into dou_rotate(uid,pointer,lottery,created,project,statue) values(".$uid.",".$pointer.",'".$lottery."',".$time.",'".$project."',".$statue.")";
              if($pdo->exec($sql_user) &&  $pdo->exec($sql)){   
                   echo $code; }
      }else if($code>=121 && $code<=135){
              $sql_user = "update dou_uc set user_pointer=" . ($pointer_count - 100) ." where id=".$_SESSION['uid'];
              $lottery = "再接再厉";
              $sql = "insert into dou_rotate(uid,pointer,lottery,created,project) values(".$uid.",".$pointer.",'".$lottery."',".$time.",'".$project."')";
              if($pdo->exec($sql_user) &&  $pdo->exec($sql)){   
                   echo $code; }
      }else if($code ==2){
              $sql_user = "update dou_uc set user_pointer=" . ($pointer_count - 100) ." where id=".$_SESSION['uid'];
              $lottery = "获得二等奖";
              $statue=1;
              $sql = "insert into dou_rotate(uid,pointer,lottery,created,project,statue) values(".$uid.",".$pointer.",'".$lottery."',".$time.",'".$project."',".$statue.")";
              if($pdo->exec($sql_user) &&  $pdo->exec($sql)){   
                   echo $code; }
      }else if($code>=176 && $code<=200){
            $lottery = "获得100积分";
            $sql = "insert into dou_rotate(uid,pointer,lottery,created,project) values(".$uid.",".$pointer.",'".$lottery."',".$time.",'".$project."')";
              if($pdo->exec($sql)){   
                   echo $code; }
    }
    
  }
  else{
        $code = 'no';
        echo $code;
    }
}

/*
   查询用户的积分  与商品积分进行比较判定
 */
if(isset($_GET['pointer'])){
  $id = $_POST['id'];
  $goods_sql = "select goods_pointer from dou_goods where id=" . $id;
  $tmp_result1 = $pdo->query($goods_sql);
  $goods_pointer = $tmp_result1->fetchColumn();
    //查询用户剩余积分
    $user_sql = "select user_pointer from dou_uc where id=" . $_SESSION['uid'];
    $tmp_result2 = $pdo->query($user_sql);
    $user_pointer = $tmp_result2->fetchColumn();
    if($goods_pointer<=$user_pointer){
      echo 1;
    }else{
      echo 2;
    }
}

