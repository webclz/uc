<?php
	require "../utils/pdo.php";
  /*
  相应ajax事件      经济用户添加的动作
   */
  if(isset($_GET['terminal'])){
 	 $user = $_POST['user_data'];
     $user_name = trim($user[0]);
     $user_account = trim($user[1]);
     $trading_account = trim($user[2]);
     $user_idcard = $user[3];
     $user_pwd = md5('777777');
    //终端会员 type=1
     $user_type = 1;
     $time = time();
     $stmt = $pdo->prepare("INSERT INTO dou_uc (user_name,user_pwd,user_account,trading_account,user_idcard,user_create,user_type) VALUES (:user_name,:user_pwd,:user_account,:trading_account,:user_idcard,:user_create,:user_type)");
     $stmt->bindParam(':user_name', $user_name);
     $stmt->bindParam(':user_pwd', $user_pwd);
     $stmt->bindParam(':user_account', $user_account);
     $stmt->bindParam(':trading_account', $trading_account);
     $stmt->bindParam(':user_idcard', $user_idcard);
     $stmt->bindParam(':user_type', $user_type);
     $stmt->bindParam(':user_create',$time);
    if($stmt->execute()){
        $add = array();
        $add['yes'] = 1;
        $id = $pdo->lastInsertId();
        $add['id'] = $id;
        echo json_encode($add);
    }else{echo "no";}

  }
  /*
  终端用户的添加   ajax
   */
  if(isset($_GET['brokerage'])){
     $user = $_POST['user_data'];
     $user_name = trim($user[0]);
     $user_account = trim($user[1]);
     //$trading_account = trim($user[2]);
     $user_idcard = $user[2];
     $user_pwd = md5('777777');
    //终端会员 type=1
     $user_type = 0;
     $time = time();
     $stmt = $pdo->prepare("INSERT INTO dou_uc (user_name,user_pwd,user_account,user_idcard,user_create,user_type) VALUES (:user_name,:user_pwd,:user_account,:user_idcard,:user_create,:user_type)");
     $stmt->bindParam(':user_name', $user_name);
     $stmt->bindParam(':user_pwd', $user_pwd);
     $stmt->bindParam(':user_account', $user_account);
     $stmt->bindParam(':user_idcard', $user_idcard);
     $stmt->bindParam(':user_type', $user_type);
     $stmt->bindParam(':user_create',$time);
    if($stmt->execute()){
        //echo "yes";
        $add = array();
        $add['yes'] = 1;
        $id = $pdo->lastInsertId();
        $add['id'] = $id;
        echo json_encode($add);
    }else{echo "no";}

  }
  /*
  用户的删除  ajax
   */
  if(isset($_GET['del'])){
   $uid = $_POST['del_id'];
    $sql = 'update dou_uc set user_show=0 where id=:uid';
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':uid', $uid);
    if ($stmt->execute()) {
        echo "del_yes";
    }else{echo "del_no";}
  }


  /*
     商品删除  ajax
   */
  if(isset($_GET['goods_del'])){
     $id = $_POST['del_id'];
    $sql = 'update dou_goods set goods_statue=0 where id=:id';
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id', $id);
    if($stmt->execute()){
      echo "del_yes";
    }
  }


  /*
  将中奖信息状态设置为已经处理
 */
if(isset($_GET['statue'])){
     $id = $_POST['myData'];
   //  $statue = $myData[1];
    // $id = $myData[0];
     //根据id进行更新
     $statue = $pdo->query("select statue from dou_rotate where id=".$id,PDO::FETCH_ASSOC)->fetchColumn();
     if($statue==1){
      $sql = "update dou_rotate set statue=2 where id=".$id;
     }else if($statue==2){
      $sql = "update dou_rotate set statue=1 where id=".$id;
     }
     if($pdo->exec($sql)){
        if($statue==1){
          echo 2;
        }else if($statue==2){
          echo 1;
        }
     }
}

/*
  动态添加商品的在种类
 */
if(isset($_GET['type_add'])){
  $type_name = $_POST['type_name'];
   $stmt = $pdo->prepare("INSERT INTO dou_goods_type(goods_typename) VALUES (:goods_typename)");
    $stmt->bindParam(':goods_typename', $_POST['type_name']);
    if ($stmt->execute()) {
       /* $add = array();
        $add['yes'] = 1;
        $id = $pdo->lastInsertId();
        $add['id'] = $id;
        echo json_encode($add);*/
        $add_yes =1;
        echo $add_yes;
    }
}
