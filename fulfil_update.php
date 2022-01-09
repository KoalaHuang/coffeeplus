<?
  //receive fulfill data and update t_request and t_stock table
  //receive data in JSON format
  //return true if sucess otherwise return false

  header("Content-Type: application/json; charset=UTF-8");
  include "mylog.php";

  $str = file_get_contents('php://input');
  $obj = json_decode($str, false);
  myLOG(__FILE__."\n"."str: ".print_r($str,true)." obj: ".print_r($obj,true)."  input: ".file_get_contents('php://input')." _POST:".print_r($_POST,true));

  if ($obj == null){
    echo "NULL JSON result from:".$str;
    die;
  }

  include "connect_db.php";
  $errDB = "";
  $result = true;
  $stmt_req = $conn->prepare("UPDATE `t_request` SET `c_qty`=`c_qty`-? WHERE `c_store`=? AND `c_item`=?");
  $stmt_stk = $conn->prepare("UPDATE `t_stock` SET `c_qty`=`c_qty`-? WHERE `c_storage`=? AND `c_item`=?");
  $stmt_req->bind_param("iss", $c_qty,$c_store,$c_item);
  $stmt_stk->bind_param("iss", $c_qty,$c_storage,$c_item);
  $numRow = (int)($obj->r);
  if (!$numRow) {
    $errDB = "JSON Para error".$obj->r;
    die;
  }else{
    $c_store = $obj->s;
    for ($i = 1; $i <= $numRow; $i++) {
      $nameItem = "i".$i;
      $nameQty = "q".$i;
      $nameStorage = "l".$i;
      $c_item = $obj->$nameItem;
      $c_qty = $obj->$nameQty;
      $c_storage = $obj->$nameStorage;
      myLOG("store: ".$c_store." item: ".$c_item." storage: ".$c_storage." qty: ".$c_qty);
      $result = ($result && $stmt_req->execute());
      $result = ($result && $stmt_stk->execute());
      myLOG("stmt_req after ".print_r($stmt_req,TRUE)."stmt_stk after ".print_r($stmt_stk,TRUE));
    } // for
    echo json_encode($result);
  } //if $numRow correct
  $stmt_req->close();
  $stmt_stk->close();
  $conn->close();
?>
