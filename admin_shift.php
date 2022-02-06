<? include_once "sessioncheck.php"?>
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
	<script src="js/admin_shift.js"></script>
</head>
<body>
	<? include "navbar.php";
		 include "mylog.php";
	?>

	<h1 id="section_home" class="text-center mb-4">Admin - Shift</h1>
	<?
	$arrayUserName = array();
	$arrayUserID = array();
	$arrayUserWorkday = array();
	$arrayStore = array();
	$arrayUserStore = array();

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
	?>

	<div class="container">
		<div class="row row-cols-7 g-0 mb-1">
			<div class="col text-center bg-light border-top border-start border-bottom">M</div>
			<div class="col text-center bg-light border-top border-start border-bottom">T</div>
			<div class="col text-center bg-light border-top border-start border-bottom">W</div>
			<div class="col text-center bg-light border-top border-start border-bottom">T</div>
			<div class="col text-center bg-light border-top border-start border-bottom">F</div>
			<div class="col text-center bg-light border-top border-start border-bottom">S</div>
			<div class="col text-center border bg-light">S</div>
		</div> <!-- row -->
		<?
		$rowStore = "";
		$totalStore = count($arrayStore);
		for ($idxStore = 0; $idxStore < $totalStore; $idxStore++) {
			$rowStore = $arrayStore[$idxStore];
			echo "<div class=\"row bg-light\" mb-1\"><span class=\"text-muted text-center\" name=\"divStores\">".$rowStore."</span></div>";
			echo "<div class=\"row row-cols-7 g-0 mb-1\">";
			for ($idxWD = 1; $idxWD < 8; $idxWD++) {
				echo "<div class=\"col\" onclick=\"f_cellSelected('".$rowStore."',".$idxWD.")\" id=\"".$rowStore.$idxWD."\">";
				$sql = "SELECT `c_id` FROM `t_shifttemp` WHERE `c_store`='".$rowStore."' AND `c_weekday`=".$idxWD;
				$result = $conn->query($sql);
				$sqlMinPpl = "SELECT `c_ppl` FROM `t_minppl` WHERE `c_store`='".$rowStore."' AND `c_weekday`=".$idxWD;
				$resultMinPpl = $conn->query($sqlMinPpl);
				$MinPpl = $resultMinPpl->fetch_assoc(); //min ppl required in this weekday for this store
				for ($idxPpl = 1; $idxPpl < 4; $idxPpl++) { //MAX ppl/store set at 3.  PHASE 2 FEATURE
					$row = $result->fetch_assoc();
					$strDivClass = "<div class=\"text-center fs-6";
					$strDivData = "\" data-stocking-minppl=\"".$MinPpl['c_ppl']."\" id=\"".$rowStore.$idxWD.$idxPpl."\">";
					if ($row){
						if (strstr($arrayUserWorkday[$row['c_id']],(string)$idxWD)) {
							echo $strDivClass.$strDivData.$row['c_id']."</div>";
						}else{
							echo $strDivClass." text-warning".$strDivData.$row['c_id']."</div>";
						}//if is off day working
					}else{
						if ($idxPpl <= $MinPpl['c_ppl']) {
							echo $strDivClass." text-danger".$strDivData."*</div>";
						}else{
							echo $strDivClass.$strDivData."&nbsp;</div>";
						} //if min. ppl required is not reached
					} //if $row is not null
				}//for loop ppl in the week day
				echo "</div>";
			}//for loop weekday
			echo "</div>";
		}//for loop store
		?>

		<div class="row mb-1">
			<div class="text-muted fst-italic fs-6 mb-1" id="txtSelection">Click on calendar to select and change...</div>
		</div>

		<select class="form-select mb-4" id="sltUser" onchange="f_sltUserChanged()" multiple>
			<?
			for ($idxUser = 0; $idxUser < count($arrayUserID); $idxUser++) {
				$userID = $arrayUserID[$idxUser];
				echo "<option value=\"".$userID."\" data-stocking-workday=\"".$arrayUserWorkday[$userID]."\" data-stocking-userstore=\"".$arrayUserStore[$userID]."\">".$arrayUserName[$userID]."&nbsp;(".$arrayUserWorkday[$userID].")"."</option>";
			}
			?>
		</select>

		<div class="row mb-4">
			<span><button type="button" class="btn btn-primary col-3 me-5" onclick="f_toConfirm()" id="btnSave" disabled>Save</button>
			<button type="button" class="btn btn-secondary col-3" onclick="f_refresh()">Cancel</button></span>
		</div>

		<div class="row mb-3">
			<div class="text-muted fst-italic fs-6 mb-1">Apply Shift to dates(yyyy/m/d ie 2022/2/4):</div>
			<div class="input-group mb-1">
			  <input type="text" class="form-control" id="iptFromDate" placeholder="From date">
			  <span class="input-group-text">&rarr;</span>
			  <input type="text" class="form-control" id="iptToDate" placeholder="To date">
				<button type="button" class="btn btn-primary" onclick="f_applyShift()">Apply</button>
			</div>
		</div> <!-- row -->
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
