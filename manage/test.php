<!doctype html>
<html lang="en">
 <head>
  <meta charset="UTF-8">
  <meta name="Generator" content="EditPlus®">
  <meta name="Author" content="">
  <meta name="Keywords" content="">
  <meta name="Description" content="">
  <script type="text/javascript" src="../js/jquery-1.7.2.min.js"></script>
  <title>测验页面</title>
 </head>
 <body>
<?php
  require "../utils/pdo.php";
  $num1 = 1313;
  $num2 = 4444;
  $str = "eeeee";
  $sql = "insert into dou_rotate(uid,pointer,lottery) values(".$num1.",".$num2.",'".$str."')";
  if($pdo->exec($sql)){
  echo "yes";
  }

?>
<a href="./login.php?name=sfasfas&age=2142">这是跳转链接</a>
 </body>
</html>
