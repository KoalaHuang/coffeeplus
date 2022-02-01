<?
/*
  header("Content-Type: application/json; charset=UTF-8");
  include "mylog.php";

  $str = file_get_contents('php://input');
  $obj = json_decode($str, false);
  // myLOG(__FILE__."\n"."str: ".print_r($str,true)." obj: ".print_r($obj,true)."  input: ".file_get_contents('php://input')." $_POST:".print_r($_POST,true));

  if ($obj == null){
    echo "NULL JSON result from:".$str;
    die;
  }
*/
  include "connect_db.php";
  $errDB = "";
  $result = true;
  $c_date = date('Y-m-d');
  $c_user = 'default';
  $stmt = $conn->prepare("INSERT INTO `t_user`(`c_name`, `c_pwd`, `c_color`, `c_workday`, `c_access`) VALUES (?,?,?,?,?)");
  $stmt->bind_param("sssss", $c_name,$c_pwd,$c_color,$c_workday,$c_access);
  $c_name = 'XinMiao';
  $c_pwd = password_hash('1234',PASSWORD_DEFAULT);
  $c_color = 'Teal';
  $c_workday = '34567';
  $c_access = 'RTC';
  $result = ($result && $stmt->execute());
  if ((!$result) || ($stmt->affected_rows == 0)) {
    echo ($stmt->error);
  }else{
    echo ("User created.");
  }
  $stmt->close();
  $conn->close();
?>
