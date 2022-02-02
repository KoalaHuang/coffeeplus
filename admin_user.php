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
	<script src="js/admin_user.js"></script>
</head>
<body>
	<? include "navbar.php" ?>

	<div class="container">
		<h1 id="section_home" class="text-center mb-2">Admin - User</h1>

		<div id="reminding" class="text-center mb-3 text-danger col-12 fst-italic fs-6">Danger zone. Know what you are doing...</div>
		<div class="row mt-3">
			<span>
				<select class="form-select mb-3" id="sltUser" onchange="f_userSelected()">
				  <option selected>Select User</option>
					<option value="addNewUser" data-stocking-access="" data-stocking-id="" data-stocking-workday="">&#9830;&nbsp;Add New User&nbsp;&#9830;</option>
					<?
					include "connect_db.php";
					$sql = "SELECT * FROM `t_user`";
    			$result = $conn->query($sql);
    			if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
							$c_name = $row["c_name"];
							$c_access = $row["c_access"];
							$c_id = $row["c_id"];
							$c_workday = $row["c_workday"];
					?>
				  <option value="<?echo $c_name?>" data-stocking-access="<?echo $c_access?>" data-stocking-id="<?echo $c_id?>" data-stocking-workday="<?echo $c_workday?>" data-stocking-name="<?echo $c_name?>"><?echo $c_name?></option>
					<?
						}
					}
					$conn->close();
					?>
				</select>
			</span>
		</div> <!-- name selection-->
		<div class="input-group mb-3">
			<span class="input-group-text">Name</span>
		  <input type="text" class="form-control" placeholder="user name" id="iptName" disabled></span>
		</div> <!--name-->
		<div class="input-group mb-3">
			<span class="input-group-text">ID</span>
		  <input type="text" class="form-control" placeholder="2 characters ID used in calendar" id="iptID" disabled>
		</div> <!--initial-->
		<div class="input-group mb-3">
			<span class="input-group-text">password</span>
		  <input type="password" placeholder="leave blank if no change" class="form-control" id="iptPwd" disabled>
		</div> <!--pwd-->
		<div class="col-12 text-center mb-1"><strong>Working Day</strong></div>
		<div class="row mb-5">
			<div class="btn-group" role="group">
        <input type="checkbox" class="btn-check" name="btn_workday" id="wd1" value="1" autocomplete="off" disabled>
				<label class="btn btn-outline-primary" for="wd1">1</label>
				<input type="checkbox" class="btn-check" name="btn_workday" id="wd2" value="2" autocomplete="off" disabled>
				<label class="btn btn-outline-primary" for="wd2">2</label>
				<input type="checkbox" class="btn-check" name="btn_workday" id="wd3" value="3" autocomplete="off" disabled>
				<label class="btn btn-outline-primary" for="wd3">3</label>
				<input type="checkbox" class="btn-check" name="btn_workday" id="wd4" value="4" autocomplete="off" disabled>
				<label class="btn btn-outline-primary" for="wd4">4</label>
				<input type="checkbox" class="btn-check" name="btn_workday" id="wd5" value="5" autocomplete="off" disabled>
				<label class="btn btn-outline-primary" for="wd5">5</label>
				<input type="checkbox" class="btn-check" name="btn_workday" id="wd6" value="6" autocomplete="off" disabled>
				<label class="btn btn-outline-primary" for="wd6">6</label>
				<input type="checkbox" class="btn-check" name="btn_workday" id="wd7" value="7" autocomplete="off" disabled>
				<label class="btn btn-outline-primary" for="wd7">7</label>
			</div> <!-- workday btn group -->
		</div> <!-- workday row -->
		<div class="col-12 text-center mb-1"><strong>Access</strong></div>
		<div class="row mb-5">
			<div class="btn-group col-12" role="group">
        <input type="checkbox" class="btn-check" name="btn_access" id="as1" value="R" autocomplete="off" disabled>
				<label class="btn btn-outline-primary" for="as1">Request</label>
				<input type="checkbox" class="btn-check" name="btn_access" id="as2" value="F" autocomplete="off" disabled>
				<label class="btn btn-outline-primary" for="as2">Fulfil</label>
				<input type="checkbox" class="btn-check" name="btn_access" id="as3" value="S" autocomplete="off" disabled>
				<label class="btn btn-outline-primary" for="as3">Stock</label>
				<input type="checkbox" class="btn-check" name="btn_access" id="as4" value="T" autocomplete="off" disabled>
				<label class="btn btn-outline-primary" for="as4">Report</label>
				<input type="checkbox" class="btn-check" name="btn_access" id="as5" value="C" autocomplete="off" disabled>
				<label class="btn btn-outline-primary" for="as5">Shift</label>
				<input type="checkbox" class="btn-check" name="btn_access" id="as6" value="A" autocomplete="off" disabled>
				<label class="btn btn-outline-primary" for="as6">Admin</label>
			</div> <!-- access btn group -->
		</div> <!-- access row -->
		<div class="row">
			<span><button type="button" id="btn_toConfirm" class="btn btn-primary col-3 me-5" onclick="f_toConfirm()" disabled>OK</button>
			<button type="button" class="btn btn-secondary col-3" onclick="f_refresh()">Cancel</button></span>
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

	<? include "footer.php" ?>
</body>
</html>
