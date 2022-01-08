<?
  //receive request data and update t_request table
  //receive data in JSON format
  //return true if sucess otherwise return false

  header("Content-Type: application/json; charset=UTF-8");
  include "mylog.php";

  $str = file_get_contents('php://input');
  $obj = json_decode($str, false);
  myLOG(__FILE__."\n"."str: ".print_r($str,true)." obj: ".print_r($obj,true)."  input: ".file_get_contents('php://input')." $_POST:".print_r($_POST,true));

  if ($obj == null){
    echo "NULL JSON result from:".$str;
    die;
  }

  include "connect_db.php";
  $errDB = "";
  $result = true;
  $stmt = $conn->prepare("UPDATE `t_request` SET `c_qty`=`c_qty`+? WHERE `c_store`=? AND `c_item`=?");
  $stmt->bind_param("iss", $c_qty,$c_store,$c_item);
  $numRow = (int)($obj->r);
  myLOG("obj: ".print_r($obj,TRUE)." numRow: ".$numRow);
  if (!$numRow) {
    $errDB = "JSON Para error".$obj->r;
    die;
  }else{
    $c_store = $obj->s;
    for ($i = 1; $i <= $numRow; $i++) {
      $nameItem = "i".$i;
      $nameQty = "q".$i;
      $c_item = $obj->$nameItem;
      $c_qty = $obj->$nameQty;
      myLOG("store: ".$c_store." item: ".$c_item." qty: ".$c_qty);
      $result = ($result && $stmt->execute());
      myLOG("stmt after ".print_r($stmt,TRUE));
    } // for
    myLOG("result: ".print_r($result,TRUE));
    echo json_encode($result);
  } //if $numRow correct
  $stmt->close();
  $conn->close();
?>
