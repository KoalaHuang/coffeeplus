<? 
/*
Shift Calendar
* normal user can add/remove his/her assignmet
* admin can change all assignment
*/
include_once "sessioncheck.php";
if (f_shouldDie("C")) {
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
	<script src="js/shift.js"></script>
</head>
<body>
	<? include "navbar.php";
		 include "mylog.php";
	?>

	<h1 id="section_home" class="text-center mb-3">Shift</h1>

	<?
	$UserName = $_SESSION["user"];
	$UserID = "";
	$UserWorkday = "";
	$UserStore = "";
	$UserIsAdmin = false;
	$arrayStore = array();
	
	include "connect_db.php";
	$sql = "SELECT `c_name`,`c_id`,`c_workday`,`c_store`, `c_access` FROM `t_user` WHERE `c_name`='".$UserName."'";
	$result = $conn->query($sql);
	if ($row = $result->fetch_assoc()) {
		$UserID = $row["c_id"];
		$UserName = $row["c_name"];
		$UserWorkday = $row["c_workday"];
		$UserStore = $row["c_store"];
		$UserIsAdmin = strstr($row["c_access"],"A");
		$idx++;
	}else{
		echo "User data error!";
		die;
	}
	$sql = "SELECT `c_name` FROM `t_store`";
	$result = $conn->query($sql);
	$idx = 0;
	while($row = $result->fetch_assoc()) {
		$rowStore = $row['c_name'];
		if (($UserStore == "ALL") || ($rowStore == $UserStore) || ($UserIsAdmin)) {
			$arrayStore[$idx] = $rowStore;
			$idx++;
		} //skip not working store. for admin, display all
	}
	//get starting date for calendar
	function f_getStartDay($theYear, $theMonth) {
		$objStartDay = date_create_from_format("Y/n/j",$theYear."/".$theMonth."/1");
		$theWeekDay = date('w', date_timestamp_get($objStartDay));
		$diffDay = $theWeekDay - 1;
		if ($diffDay < 0) $diffDay = 6;
		date_sub($objStartDay,date_interval_create_from_date_string($diffDay." days"));
		return $objStartDay;
	}

	if (($_GET['year'] != NULL) && ($_GET['mon'] != NULL)) {
			$theYear = (int)$_GET['year'];
			$theMonth = (int)$_GET['mon'];
			$objTempDay = date_create_from_format("Y/n/j",$theYear."/".$theMonth."/"."1");
			$theMonthName = date("F",date_timestamp_get($objTempDay));
	}else{
		$arrDefaultDay = getdate(); //default date in array
		$theYear = $arrDefaultDay['year'];
		$theMonth = $arrDefaultDay['mon'];
		$theMonthName = $arrDefaultDay['month'];
	}
	$objStartDay = f_getStartDay($theYear,$theMonth);
	$objStartDay->setTime(0,0,0);
	$today = new DateTime("today");
	?>

	<div id="txtUserName" class="text-center mb-2 text-secondary col-12 fw-bold fs-6" data-stocking-userid="<?echo $UserID?>" data-stocking-userstore="<?echo $UserStore?>" data-stocking-userworkday="<?echo $UserWorkday?>" data-stocking-change="<?echo $UserIsAdmin?>"><?echo $UserName?></div>

	<div class="container">
		<div class="mb-2"><!--month switch-->
				<?
				$totalStore = count($arrayStore);
				for ($idxStore=0; $idxStore<$totalStore; $idxStore++){
				?>
				<div class="form-check form-switch form-check-inline me-5">
					<input checked type="checkbox" class="form-check-input" name="btnStores" id="<? echo "btnST".$idxStore ?>" onclick="f_storeSelected(<?echo $idxStore?>)">
					<label class="form-check-label fw-bold" for="<? echo "btnST".$idxStore ?>"><? echo $arrayStore[$idxStore] ?></label>
				</div>
				<?
				}
				?>
		</div>
		<div class="row g-0 mb-1"><!--month switch-->
			<div class="input-group mb-1">
			  <button class="btn btn-primary" type="button" id="btnPre" onclick="f_lastMon()">&#8678;</button>
			  <input type="text" id="iptDate" data-stocking-year="<?echo $theYear?>" data-stocking-mon="<?echo $theMonth?>" class="form-control text-center fw-bold" value="<?echo $theMonthName." - ".$theYear ?>" disabled> <!--holds year and month of title. Note individual day may have diff year/mon value-->
				<button class="btn btn-primary" type="button" id="btnNext" onclick="f_nextMon()">&#8680;</button>
			</div>
		</div>
		<?
		$objDay = clone $objStartDay;//create new date object for loop
		for ($idxWeek = 1; $idxWeek < 6; $idxWeek++) { //display 5 weeks for current month
			$objWeek1stDay = clone $objDay; //create new date to store starting day of current week row
			echo "<div class=\"row row-cols-7 g-0 mb-1\">"; // row of days in the week
			for ($idxWD = 1; $idxWD < 8; $idxWD++){
				//check if it's holiday
				$sql = "SELECT `c_holiday` FROM `t_holiday` WHERE `c_date`='".date_format($objDay,'Y-m-d')."'";
				$holidayResult = $conn->query($sql);
				$holiday = $holidayResult->fetch_assoc();
				$mday = date('j',date_timestamp_get($objDay));
				myLOG("today".date_format($today,"y/m/j H:i:u"));
				myLOG("objDay".date_format($objDay,"y/m/j H:i:u"));
				myLOG("diff: ".(integer)($today->diff($objDay)->format("%R%a")));
				if (((integer)($today->diff($objDay)->format("%R%a"))) == 0) {
					$bgToday = "bg-warning";
				}else{
					$bgToday = "bg-light";
				}
				if (is_null($holiday)) {
						$strClassHol = $mday;
					}else{
						$strClassHol = "<span class=\"text-danger\">".$mday."</span>";
				}
				$strDiv3B = "<div class=\"col ".$bgToday." text-center border-top border-start border-bottom border-dark fs-8\">".$strClassHol."<span class=\"text-muted\">";
				$strDivEnd = "</span></div>";
				switch ($idxWD) {
					case 1:
						echo $strDiv3B." M".$strDivEnd;
						break;
					case 2:
						echo $strDiv3B." T".$strDivEnd;
						break;
					case 3:
						echo $strDiv3B." W".$strDivEnd;
						break;
					case 4:
						echo $strDiv3B." T".$strDivEnd;
						break;
					case 5:
						echo $strDiv3B." F".$strDivEnd;
						break;
					case 6:
						echo $strDiv3B." S".$strDivEnd;
						break;
					case 7:
						echo "<div class=\"col ".$bgToday." text-center border border-dark fs-8\">".$strClassHol."<span class=\"text-muted\"> S".$strDivEnd;
				}
				date_add($objDay,date_interval_create_from_date_string("1 day"));
			}
			echo "</div>"; //row of days
			//display ppl for each store in each week day
			$rowStore = "";
			for ($idxStore = 0; $idxStore < $totalStore; $idxStore++) {
				$rowStore = $arrayStore[$idxStore];
				echo "<div class=\"row mb-1\"><span class=\"bg-light text-muted text-center\" name=\"divStore".$idxStore."\">".$rowStore."</span></div>";
				echo "<div class=\"row row-cols-7 mb-1\" name=\"divStore".$idxStore."\">";
				$objDay = clone $objWeek1stDay; //counting day for store/ppl rows
				for ($idxWD = 1; $idxWD < 8; $idxWD++) {
					$mday = date('j',date_timestamp_get($objDay));
					$cellYear = date("Y",date_timestamp_get($objDay));
					$cellMon = date("n",date_timestamp_get($objDay));
					$cellID = $rowStore.$cellMon."_".$mday;
					if ((((integer)($today->diff($objDay)->format("%R%a"))) > 0) || ($UserIsAdmin)) { //future dates or user is admin (admin can edit past days)
						echo "<div class=\"col\" onclick=\"f_cellSelected('".$rowStore."',".$idxWD.",".$cellYear.",".$cellMon.",".$mday.")\" id=\"".$cellID."\">";
					}else{
						echo "<div class=\"col\" id=\"".$cellID."\">"; //no clicable if date is not greater than today
					}
					$sql = "SELECT `c_id`, `c_type` FROM `t_calendar` WHERE `c_store`='".$rowStore."' AND `c_date`='".$cellYear."-".$cellMon."-".$mday."'";
					$result = $conn->query($sql);
					$sqlMinPpl = "SELECT `c_ppl` FROM `t_minppl` WHERE `c_store`='".$rowStore."' AND `c_weekday`=".$idxWD;
					$resultMinPpl = $conn->query($sqlMinPpl);
					$MinPpl = $resultMinPpl->fetch_assoc(); //min ppl required in this weekday for this store
					for ($idxPpl = 1; $idxPpl < 4; $idxPpl++) { //MAX ppl/store set at 3.  PHASE 2 FEATURE
						$row = $result->fetch_assoc();
						$c_type = $row['c_type'];
						$strDivClass = "<div class=\"text-center fs-6";
						$strDivData = "\" data-stocking-minppl=\"".$MinPpl['c_ppl']."\" id=\"".$cellID."_".$idxPpl."\">";
						if ($row){
							switch ($c_type) {
								case "WW":
									echo $strDivClass.$strDivData.$row['c_id']."</div>";
									break;
								case "OW":
									echo $strDivClass." text-warning".$strDivData.$row['c_id']."</div>";
									break;
								case "HW":
									echo $strDivClass." text-danger".$strDivData.$row['c_id']."</div>";
									break;
							}
						}else{
							if ($idxPpl <= $MinPpl['c_ppl']) {
								echo $strDivClass." text-danger".$strDivData."*</div>";
							}else{
								echo $strDivClass.$strDivData."&nbsp;</div>";
							} //if min. ppl required is not reached
						} //if $row is not null
					}//for loop ppl in the week day
					echo "</div>";
					date_add($objDay,date_interval_create_from_date_string("1 day"));
				}//for loop weekday
				echo "</div>";
			}//for loop store
		}//for loop Weeks
		?>
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
