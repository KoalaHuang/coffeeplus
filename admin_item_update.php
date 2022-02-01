<?
  //receive request data and update t_request table
  //receive data in JSON format
  //return true if sucess otherwise return false

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

  if ($obj->i == 'addNewItem'){
    $sql_stock = "INSERT INTO `t_stock`(`c_storage`, `c_item`, `c_cat`, `c_qty`) VALUES (\"".$obj->ns."\",\"".$obj->ni."\",\"".$obj->c."\",0);";
  }else{
    $sql_stock = "UPDATE `t_stock` SET `c_item`=\"".$obj->ni."\",`c_storage`=\"".$obj->ns."\" WHERE `c_storage`=\"".$obj->s."\" AND `c_item`=\"".$obj->i."\";";
  }
  myLOG(__FILE__."\n"."sql: ".$sql_stock);
  $result = $conn->query($sql_stock);
  $conn->close();
  echo json_encode($result);
?>
