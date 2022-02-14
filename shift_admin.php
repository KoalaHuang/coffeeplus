<?
/*
Shift changed by admin
Called from shift screen when user is admin
*/ 
include_once "sessioncheck.php";
if (f_shouldDie("A")) {
	header("Location:login.php");
	exit();
  }
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>BackOffice</title>
	<link rel="stylesheet" href="css/bootstrap.min.css">
  <link rel="stylesheet" href="css/styles.css">
	<script src="js/bootstrap.min.js"></script>
	<script src="js/nav.js"></script>
	<script src="js/shift_admin.js"></script>
</head>
<body>
	<? include "navbar.php";
		 include "mylog.php";
	?>

	<h1 id="section_home" class="text-center mb-4">Shift</h1>
	<?
	$arrayUserName = array();
	$arrayUserID = array();
	$arrayUserWorkday = array();
	$arrayStore = array();
	$arrayUserStore = array();
    $arrayAssigned = array();

	include "connect_db.php";
	$sql = "SELECT `c_name`,`c_id`,`c_workday`,`c_store` FROM `t_user` WHERE (NOT `c_store`='NONE')";
	$result = $conn->query($sql);
	$idx = 0;
	while($row = $result->fetch_assoc()) {
		$arrayUserID[$idx] = $row["c_id"];
		$arrayUserName[$arrayUserID[$idx]] = $row["c_name"];
		$arrayUserWorkday[$arrayUserID[$idx]] = $row["c_workday"];
		$arrayUserStore[$arrayUserID[$idx]] = $row["c_store"];
		$idx++;
	}
	$sql = "SELECT `c_name` FROM `t_store`";
	$result = $conn->query($sql);
	$idx = 0;
	while($row = $result->fetch_assoc()) {
		$arrayStore[$idx] = $row["c_name"];
		$idx++;
	}
    $thisYear = $_GET['year'];
    $thisMon = $_GET['mon'];
    $thisDay = $_GET['day'];
    $thisStore = $_GET['store'];
	$calendarMon = $_GET['cmon'];  //return to month of calendar displayed
    $objDay = date_create_from_format("Y/n/j",$thisYear."/".$thisMon."/".$thisDay);
    $thisWeekDay = date('w', date_timestamp_get($objDay));
    if ($thisWeekDay == 0) $thisWeekDay = 7;
	$thisDate = date_format($objDay,'Y-m-d');
	$sql = "SELECT `c_holiday` FROM `t_holiday` WHERE `c_date`='".$thisDate."'";
	$holidayResult = $conn->query($sql);
	$holiday = $holidayResult->fetch_assoc();
    ?>

	<div class="container">
    <label class="text-primary mb-1">Change below shift:</label>
    <div class="mb-3" id="thisCell" data-stocking-year="<?echo $thisYear?>" data-stocking-mon="<?echo $thisMon?>" data-stocking-day="<?echo $thisDay?>" data-stocking-store="<?echo $thisStore?>" data-stocking-weekday="<?echo $thisWeekDay?>" data-stocking-isholiday="<?if (is_null($holiday)) {echo "0";}else{echo "1";}?>" data-stocking-calendarmon="<?echo $calendarMon?>">
		<span class="bg-light" >Date:&nbsp;</span>
		<span class="bg-white fw-bold"><?echo date_format($objDay,"M j Y  D")?></span>
		<span class="bg-light ms-3" >Store:&nbsp;</span>
		<span class="bg-white fw-bold"><?echo $thisStore?></span>
    </div>
    <?
    $sql = "SELECT `c_id` FROM `t_calendar` WHERE `c_store`='".$thisStore."' AND `c_date`='".$thisDate."'";
    $result = $conn->query($sql);
	$idx = 0;
    $sqlMinPpl = "SELECT `c_ppl` FROM `t_minppl` WHERE `c_store`='".$thisStore."' AND `c_weekday`=".$thisWeekDay;
    $resultMinPpl = $conn->query($sqlMinPpl);
    $MinPpl = $resultMinPpl->fetch_assoc(); //min ppl required in this weekday for this store
    echo "<div class=\"card mb-3\">";
    echo "<div class=\"card body\">";
	echo "<h5 class=\"card-title\">Shift arrangement:</h5>";
    echo "<div class=\"row mb-1\">";
    echo "<div class=\"col\">";
    for ($idxPpl = 1; $idxPpl < 4; $idxPpl++) { //MAX ppl/store set at 3.  PHASE 2 FEATURE
        $row = $result->fetch_assoc();
        $strDivClass = "<div class=\"text-center fs-6";
        $strDivData = "\" data-stocking-minppl=\"".$MinPpl['c_ppl']."\" id=\"".$thisStore.$thisWeekDay.$idxPpl."\">";
        if ($row){
    		$arrayAssigned[$idx] = $row["c_id"];
	    	$idx++;
			if (is_null($holiday)) {
				if (strstr($arrayUserWorkday[$row['c_id']],(string)$thisWeekDay)) {
					echo $strDivClass.$strDivData.$row['c_id']."</div>";
				}else{
					echo $strDivClass." text-warning".$strDivData.$row['c_id']."</div>";
				}//if is off day working
			}else{
				echo $strDivClass." text-danger".$strDivData.$row['c_id']."</div>";
			}	
        }else{
            if ($idxPpl <= $MinPpl['c_ppl']) {
                echo $strDivClass." text-danger".$strDivData."*</div>";
            }else{
                echo $strDivClass.$strDivData."&nbsp;</div>";
            } //if min. ppl required is not reached
        } //if $row is not null
    }//for loop ppl in the week day
    echo "</div>"; //col
    echo "</div>"; //row
    echo "</div>"; //card body
    echo "</div>"; //card
    ?>

		<label class="text-primary mb-1">Select people:</label>
        <select class="form-select mb-4" id="sltUser" onchange="f_sltUserChanged()" multiple>
            <?
            for ($idxUser = 0; $idxUser < count($arrayUserID); $idxUser++) {
                $userID = $arrayUserID[$idxUser];
                if (($arrayUserStore[$userID] == $thisStore) || ($arrayUserStore[$userID] == "ALL")) {
                    $strChecked = "";
                    for ($idx=0;$idx < count($arrayAssigned); $idx++) {
                        if ($arrayAssigned[$idx] == $userID) {
                            $strChecked = "selected";
                            break;
                        }
                    }
                    echo "<option value=\"".$userID."\" data-stocking-workday=\"".$arrayUserWorkday[$userID]."\" ".$strChecked.">".$arrayUserName[$userID]."&nbsp;(".$arrayUserWorkday[$userID].")"."</option>";
                }
            }
            ?>
        </select>    

		<div class="row mb-4">
			<span><button type="button" class="btn btn-primary col-3 me-5" onclick="f_toConfirm()" id="btnSave" disabled>Save</button>
			<button type="button" class="btn btn-secondary col-3" onclick="f_return()">Return</button></span>
		</div>
    </div> <!-- container -->

	<!-- Modal Submit-->
	<div class="modal fade" id="modal_box" tabindex="-1">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="lbl_modal"></h5>
				</div>
				<div class="modal-body fs-6" id="body_modal">
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" id="btn_cancel" data-bs-dismiss="modal">Cancel</button>
					<button type="button" class="btn btn-primary" id="btn_ok" onclick="f_submit()">OK</button>
				</div>
			</div>
		</div>
	</div>

	<?
	$conn->close();
	include "footer.php"
	?>
</body>
</html>
