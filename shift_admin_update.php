<?
  /*update shift changed by admin into t_calendar
  Parameter:
    Array of object {store, weekday, id, year, mon, day}
  */
  session_start();

  header("Content-Type: application/json; charset=UTF-8");
  include "mylog.php";

  $str = file_get_contents('php://input');
  $obj = json_decode($str, false);

  if ($obj == null){
    echo "NULL JSON result from:".$str;
    die;
  }
  include "connect_db.php";
  $strPostedDate = $obj[0]->year."/".$obj[0]->mon."/".$obj[0]->day;
  $currentDate = date_create_from_format("Y/n/j",$strPostedDate);
  if (($currentDate) && (date_format($currentDate,"Y/n/j") == $strPostedDate)) {

    //remove current shift arrangement
    $sql = "DELETE FROM `t_calendar` WHERE `c_date`='".date_format($currentDate,'Y-m-d')."' AND `c_store`='".$obj[0]->store."'";
    $result = $conn->query($sql);

    for ($idx = 0; $idx < count($obj); $idx++) {
      $c_id = $obj[$idx]->id;
      if ($c_id == "") break; //if id is "", it means remove all assignmens
      $c_store= $obj[$idx]->store;
      $c_weekday = $obj[$idx]->weekday;
      //get user workday
      $sql = "SELECT `c_workday` FROM `t_user` WHERE (`c_id`='".$c_id."')";
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
        if (strstr($userWD,$c_weekday)) {
          $c_type = "WW";
        }else{
          $c_type = "OW";
        }
      }// if HW
      $stmt = $conn->prepare("INSERT INTO `t_calendar`(`c_date`, `c_id`, `c_store`, `c_type`) VALUES (?,?,?,?)");
      $stmt->bind_param("ssss",$c_date,$c_id,$c_store,$c_type);
      $c_date = date_format($currentDate,'Y-m-d');
      $result = $stmt->execute();
      $stmt->close();
    }
    $conn->close();
    echo json_encode($result);
  }else{
    echo json_encode("Dates Error!");
  }
?>
