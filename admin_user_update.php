<?
  //receive request data and update t_user table
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

  if ($obj->n == 'addNewUser'){
    $stmt = $conn->prepare("INSERT INTO `t_user`(`c_name`, `c_pwd`, `c_id`, `c_workday`, `c_access`) VALUES (?,?,?,?,?)");
    $stmt->bind_param("sssss", $c_name,$c_pwd,$c_id,$c_workday,$c_access);
    $c_name = $obj->nn;
    $c_id = $obj->ni;
    $c_workday = $obj->nw;
    $c_access = $obj->na."O"; //by default NEW user access to my account page.
  }else{
    $c_newname = $obj->nn;
    $c_name = $obj->n;
    $c_id = $obj->ni;
    $c_workday = $obj->nw;
    $c_access = $obj->na;
    if ($obj->p == "") {
      $stmt = $conn->prepare("UPDATE `t_user` SET `c_name`=?,`c_id`=?,`c_workday`=?,`c_access`=? WHERE `c_name`=?");
      $stmt->bind_param("sssss", $c_newname,$c_id,$c_workday,$c_access,$c_name);
    }else{
      $c_pwd = password_hash($obj->p,PASSWORD_DEFAULT);
      $stmt = $conn->prepare("UPDATE `t_user` SET `c_name`=?,`c_id`=?,`c_workday`=?,`c_access`=?, `c_pwd`=? WHERE `c_name`=?");
      $stmt->bind_param("ssssss", $c_newname,$c_id,$c_workday,$c_access,$c_pwd,$c_name);
    }
  }
  $result = $stmt->execute();
  $stmt->close();
  $conn->close();
  echo json_encode($result);
?>
