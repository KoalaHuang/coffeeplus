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
</head>
<body>
	<? include "navbar.php";
		 include "mylog.php";
	?>

	<h1 id="section_home" class="text-center mb-1">Admin - Shift</h1>
	<div id="reminding" class="text-center mb-3 text-danger col-12 fst-italic fs-6">Danger zone. Know what you are doing...</div>
	<?
	$arrayUserName = array();
	$arrayUserID = array();
	$arrayUserWorkday = array();
	$arrayStore = array();

	include "connect_db.php";
	$sql = "SELECT `c_name`,`c_id`,`c_workday` FROM `t_user`";
	$result = $conn->query($sql);
	$idx = 0;
	while($row = $result->fetch_assoc()) {
		$arrayUserID[$idx] = $row["c_id"];
		$arrayUserName[$arrayUserID[$idx]] = $row["c_name"];
		$arrayUserWorkday[$arrayUserID[$idx]] = $row["c_workday"];
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
			<div class="btn-group" role="group">
			  <input type="radio" class="btn-check" name="btnWDS" id="btnWD1">
			  <label class="btn btn-outline-primary" for="btnWD1">M</label>
			  <input type="radio" class="btn-check" name="btnWDS" id="btnWD2">
			  <label class="btn btn-outline-primary" for="btnWD2">T</label>
			  <input type="radio" class="btn-check" name="btnWDS" id="btnWD3">
			  <label class="btn btn-outline-primary" for="btnWD3">W</label>
				<input type="radio" class="btn-check" name="btnWDS" id="btnWD4">
			  <label class="btn btn-outline-primary" for="btnWD4">T</label>
				<input type="radio" class="btn-check" name="btnWDS" id="btnWD5">
			  <label class="btn btn-outline-primary" for="btnWD5">F</label>
				<input type="radio" class="btn-check" name="btnWDS" id="btnWD6">
			  <label class="btn btn-outline-primary" for="btnWD6">S</label>
				<input type="radio" class="btn-check" name="btnWDS" id="btnWD7">
			  <label class="btn btn-outline-primary" for="btnWD7">S</label>
			</div>
		</div> <!-- row -->
		<?
		$rowStore = "";
		$totalStore = count($arrayStore);
		for ($idxStore = 0; $idxStore < $totalStore; $idxStore++) {
			$rowStore = $arrayStore[$idxStore];
			echo "<div class=\"row row-cols-7 g-0 mb-1\">";
			for ($idxWD = 1; $idxWD < 8; $idxWD++) {
				echo "<div class=\"col\">";
				$sql = "SELECT `c_id` FROM `t_shifttemp` WHERE `c_store`='".$rowStore."' AND `c_weekday`=".$idxWD;
				$result = $conn->query($sql);
				$sqlMinPpl = "SELECT `c_ppl` FROM `t_minppl` WHERE `c_store`='".$rowStore."' AND `c_weekday`=".$idxWD;
				myLOG($sqlMinPpl);
				$resultMinPpl = $conn->query($sqlMinPpl);
				$MinPpl = $resultMinPpl->fetch_assoc(); //min ppl required in this weekday for this store
				for ($idxPpl = 1; $idxPpl < 4; $idxPpl++) { //MAX ppl/store set at 3.  PHASE 2 FEATURE
					$row = $result->fetch_assoc();
					if ($row){
						if (strstr($arrayUserWorkday[$row['c_id']],(string)$idxWD)) {
							echo "<div class=\"text-center fs-6\">".$row['c_id']."</div>";
						}else{
							echo "<div class=\"text-center fs-6 text-warning\">".$row['c_id']."</div>";
						}//if is off day working
					}else{
						if ($idxPpl <= $MinPpl) {
							echo "<div class=\"text-center fs-6\"><span class=\"text-danger\">*</span></div>";
						}else{
							echo "<div class=\"text-center fs-6\"></div>";
						} //if min. ppl required is not reached
					} //if $row is not null
				}//for loop ppl in the week day
				echo "</div>";
			}//for loop weekday
			echo "</div>";
		}//for loop store
		?>

		<div class="row mb-3">
			<div class="btn-group" role="group">
			  <input type="radio" class="btn-check" name="btnStores" id="btnST1">
			  <label class="btn btn-outline-primary" for="btnST1">FR</label>
			  <input type="radio" class="btn-check" name="btnStores" id="btnST2">
			  <label class="btn btn-outline-primary btn-light" for="btnST2">VP</label>
			</div>
		</div> <!-- row -->

		<select class="form-select mb-3" multiple>
		  <option value="1">One</option>
		  <option value="2">Two</option>
		  <option value="3">Three</option>
		</select>

		<div class="row mb-3">
			<div class="input-group mb-3">
			  <input type="text" class="form-control" placeholder="date range">
			  <span class="input-group-text">&rarr;</span>
			  <input type="text" class="form-control" placeholder="ie 2022/2/20">
				<button type="button" class="btn btn-primary">Apply</button>
			</div>
		</div> <!-- row -->


	</div> <!-- container -->

	<?
	$conn->close();
	include "footer.php"
	?>
</body>
</html>
