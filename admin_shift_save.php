<?
  //save shift template to t_shittemp

  header("Content-Type: application/json; charset=UTF-8");
  include "mylog.php";

  $str = file_get_contents('php://input');
  $obj = json_decode($str, false);
  // myLOG(__FILE__."\n"."str: ".print_r($str,true)." obj: ".print_r($obj,true)."  input: ".file_get_contents('php://input')." $_POST:".print_r($_POST,true));

  if ($obj == null){
    echo "NULL JSON result from:".$str;
    die;
  }
  include "connect_db.php";
  $result = true;
  $sql = "DELETE FROM `t_shifttemp` WHERE 1;";
  $conn->query($sql);

  $stmt = $conn->prepare("INSERT INTO `t_shifttemp`(`c_weekday`, `c_id`, `c_store`) VALUES (?,?,?)");
  $stmt->bind_param("iss",$c_weekday,$c_id,$c_store);
  $length = count($obj);
  for ($idx = 0; $idx < $length; $idx++) {
    $c_weekday = $obj[$idx]->w;
    $c_id = $obj[$idx]->p;
    $c_store = $obj[$idx]->s;
    $result = $stmt->execute();
  }

  $stmt->close();
  $conn->close();
  echo json_encode($result);
?>
