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
	<script src="js/admin_shift_report.js"></script>
</head>
<body>
	<?
	include "navbar.php";
	include "mylog.php";
	myLOG(__FILE__);

	$hideResult = true;
	$inputError = false;
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		$fromDate = date_create_from_format("Y/n/j",$_POST["iptFromDate"]);
	  $toDate = date_create_from_format("Y/n/j",$_POST["iptToDate"]);
	  if ((is_null($fromDate)) || is_null($toDate)) {
			$inputError = true;
		}else{
			$hideResult = false;
		}
		myLOG("from: ".date_format($fromDate,"Y/n/j")." to: ".date_format($toDate,"Y/n/j")." hide: ".var_export($hideResult,true)." inputerror:".var_export($inputError,true));
	}
	?>

	<div class="container">
		<h1 id="section_home" class="text-center mb-3">Shift Report</h1>
		<!--date form-->
		<div class="row mb-3">
			<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
				<?
				if ($inputError) {
					echo "<div class=\"text-danger fst-italic fs-6 mb-1\">Date error! Use yyyy/m/d ie 2022/2/4 :</div>";
				}else{
					echo "<div class=\"text-muted fst-italic fs-6 mb-1\">Report date range (yyyy/m/d ie 2022/2/4):</div>";
				}
				?>
				<div class="input-group mb-1">
				  <input type="text" class="form-control" name="iptFromDate" placeholder="From date" value="<?if (!($hideResult)) echo date_format($fromDate,"Y/n/j")?>">
				  <span class="input-group-text">&rarr;</span>
				  <input type="text" class="form-control" name="iptToDate" placeholder="To date" value="<?if (!($hideResult)) echo date_format($toDate,"Y/n/j")?>">
					<button type="submit" class="btn btn-primary">Submit</button>
				</div>
			</form>
		</div> <!-- row -->

		<!--Report type selection-->
		<div class="row mb-2 <?if ($hideResult) echo "d-none"?>">
				<div class="text-muted">Report by </div>
				<div class="btn-group" role="group">
	        <input type="radio" class="btn-check" name="btn_reporttype" id="btn_people" onclick="f_whichType()">
					<label class="btn btn-outline-primary" for="btn_people">People</label>
					<input type="radio" class="btn-check" name="btn_reporttype" id="btn_store" onclick="f_whichType()">
					<label class="btn btn-outline-primary" for="btn_store">Store</label>
				</div> <!-- btn group -->
		</div> <!-- row. selection area -->

		<?
		//retrive date into Arrays
		if (!($inputError || $hideResult)){
			$arrayUserName = array();
			$arrayUserID = array();
			$arrayStore = array();
			$arrayWorkType = ["WW","OW","HW"];
			$arrayPeople = array(array(),array(),array());

			include "connect_db.php";
			$sql = "SELECT `c_name`,`c_id` FROM `t_user` WHERE (NOT `c_store`='NONE')";
			$result = $conn->query($sql);
			$idx = 0;
			while($row = $result->fetch_assoc()) {
				$arrayUserID[$idx] = $row["c_id"];
				$arrayUserName[$arrayUserID[$idx]] = $row["c_name"];
				$idx++;
			}
			$sql = "SELECT `c_name` FROM `t_store`";
			$result = $conn->query($sql);
			$idx = 0;
			while($row = $result->fetch_assoc()) {
				$arrayStore[$idx] = $row["c_name"];
				$idx++;
			}

			$sql = "SELECT count(`c_date`),`c_id`,`c_store`,`c_type` FROM `t_calendar` WHERE `c_date`>='".date_format($fromDate,"Y-m-d")."' AND `c_date`<='".date_format($toDate,"Y-m-d")."' GROUP BY `c_id`,`c_store`, `c_type`;";
			myLOG($sql);
			$result = $conn->query($sql);
			$idx = 0;
			while($row = $result->fetch_assoc()) {
				$c_id = $row['c_id'];
				$c_name = $arrayUserName[$c_id];
				$c_count = $row['count(`c_date`)'];
				$c_store = $row['c_store'];
				$c_type = $row['c_type'];
				$arrayPeople[$c_id][$c_store][$c_type] = $c_count;
				$idx++;
			}
			$conn->close();
		}
		myLOG($arrayPeople);
		?>

		<!--Result Row-->
		<div class="row px-3 col mb-2 <?if ($hideResult) echo "d-none"?>">
		<?
		for ($idxPpl = 0; $idxPpl<count($arrayUserID); $idxPpl++) {
			$c_id = $arrayUserID[$idxPpl];
			$c_name = $arrayUserName[$c_id];

			echo "<a class=\"btn btn-outline-dark mb-1\" data-bs-toggle=\"collapse\" href=\"#rpt".$c_name."\" role=\"button\">".$c_name."</a>";
			echo "<div class=\"collapse\" id=\"rpt".$c_name."\">";
			echo "<div class=\"card card-body\"><table class=\"table\"><thead>";
			echo "<tr>";
			echo "<th scope=\"col\">Type</th>";
			$ySum = array(); //store sum of working days for each store
			for ($idxStore = 0; $idxStore<count($arrayStore); $idxStore++) {
				echo "<th scope=\"col\">".$arrayStore[$idxStore]."</th>";
				$ySum[$idxStore] = 0;
			}
			echo "<th class=\"table-secondary\" scope=\"col\">SUM</th>"; //work type sum
			echo "</tr></thead><tbody>";
			for ($idxType = 0; $idxType<count($arrayWorkType); $idxType++) {
				$c_type = $arrayWorkType[$idxType];
				echo "<tr>";
				echo "<th scope=\"col\">".$c_type."</th>";
				for ($idxStore = 0, $xSum = 0; $idxStore<count($arrayStore); $idxStore++) {
					$c_store = $arrayStore[$idxStore];
					if (is_null($arrayPeople[$c_id][$c_store][$c_type])) {
						$c_count = 0;
					}else{
						$c_count = $arrayPeople[$c_id][$c_store][$c_type];
					} //if count is null
					echo "<td scope=\"col\">".$c_count."</th>";
					$xSum = $xSum + $c_count;
					$ySum[$idxStore] = $ySum[$idxStore] + $c_count;
				} //for loop store
				echo "<td class=\"table-secondary\" scope=\"col\">".$xSum."</th>"; //sum of this work type from all stores.
				echo "</tr>";
			} // for loop type
			echo "<tr>";
			echo "<th class=\"table-secondary\" scope=\"col\">SUM</th>"; //store sum
			for ($idxStore = 0, $totalWork=0; $idxStore<count($arrayStore); $idxStore++) {
				$totalWork = $totalWork + $ySum[$idxStore];
				echo "<td class=\"table-secondary\" scope=\"col\">".$ySum[$idxStore]."</th>";
			}
			echo "<td class=\"table-dark text-white\" scope=\"col\">".$totalWork."</th>"; //store sum
			echo "</tr></tbody></table>";
			echo "</div>";
			echo "</div>";
		} // for loop ppl
		?>
		</div> <!-- result row-->

	<?
	include "footer.php";
	?>
</body>
</html>