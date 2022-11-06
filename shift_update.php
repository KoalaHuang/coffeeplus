<?
  //update shift for individual in t_calendar
  session_start();

  header("Content-Type: application/json; charset=UTF-8");

  $str = file_get_contents('php://input');
  $obj = json_decode($str, false);

  if ($obj == null){
    echo json_encode("NULL JSON result from:".$str);
    die;
  }

  switch ($obj->status) {
    case 0:
      echo json_encode ("remove:".$obj->status);
      break;
    case 1:
      echo json_encode ("add:".$obj->status);
      break;
    case 2:
        echo json_encode ("update:".$obj->status);
        break;
    default:
      echo json_encode("Error status".$obj->status);
  }

  /*
  include "connect_db.php";
  $strPostedDate = $obj->year."/".$obj->mon."/".$obj->mday;
  $currentDate = date_create_from_format("Y/n/j",$strPostedDate);

  if (($currentDate) && (date_format($currentDate,"Y/n/j") == $strPostedDate)) {
    if ($obj->istoadd) {
      //get user workday
      $sql = "SELECT `c_workday` FROM `t_user` WHERE (`c_id`='".$obj->id."')";
    	$wdResult = $conn->query($sql);
      if ($row = $wdResult->fetch_assoc()) {
        $userWD = $row['c_workday'];
      }else{
        echo "weekday data error!";
        die;
      }
      //check if it's holiday
      $sql = "SELECT `c_holiday` FROM `t_holiday` WHERE `c_date`='".date_format($currentDate,'Y-m-d')."'";
      $holidayResult = $conn->query($sql);
      $holiday = $holidayResult->fetch_assoc();
      $isHoliday = (!(is_null($holiday)));
      if ($isHoliday) {
        $c_type = "HW";
      }else{
        if (strstr($userWD,(string)$obj->wd)) {
          $c_type = "WW";
        }else{
          $c_type = "OW";
        }
      }// if HW
      $stmt = $conn->prepare("INSERT INTO `t_calendar`(`c_date`, `c_id`, `c_store`, `c_type`) VALUES (?,?,?,?)");
      $stmt->bind_param("ssss",$c_date,$c_id,$c_store,$c_type);
      $result = true;
      $c_date = date_format($currentDate,'Y-m-d');
      $c_id = $obj->id;
      $c_store = $obj->store;
      $result = $stmt->execute();
      $stmt->close();
    }else{
      $sql = "DELETE FROM `t_calendar` WHERE `c_date`='".date_format($currentDate,'Y-m-d')."' AND `c_id`='".$obj->id."' AND `c_store`='".$obj->store."'";
      $result = $conn->query($sql);
    }
    $conn->close();
    echo json_encode($result);
  }else{
    echo json_encode("Dates Error!");
  }
  */
?>
