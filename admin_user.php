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
					<option value="addNewUser" data-stocking-access="O" data-stocking-id="" data-stocking-workday="" data-stocking-userstore="NONE">&#9830;&nbsp;Add New User&nbsp;&#9830;</option>
					<?
					include "connect_db.php";
					$sql = "SELECT `c_name`,`c_id`,`c_access`,`c_workday`,`c_store` FROM `t_user`";
    			$result = $conn->query($sql);
    			if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
							$c_name = $row["c_name"];
							$c_access = $row["c_access"];
							$c_id = $row["c_id"];
							$c_workday = $row["c_workday"];
							$c_store = $row["c_store"];
					?>
				  <option value="<?echo $c_name?>" data-stocking-access="<?echo $c_access?>" data-stocking-id="<?echo $c_id?>" data-stocking-workday="<?echo $c_workday?>" data-stocking-name="<?echo $c_name?>" data-stocking-userstore="<?echo $c_store?>"><?echo $c_name?></option>
					<?
						}
					}
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
		<div class="col-12 bg-light text-center mb-1"><strong>Working Day</strong></div>
		<div class="row mx-auto">
      <div class="col"><div class="form-check">
				      <input disabled type="checkbox" class="form-check-input" name="btn_workday" id="wd1" value="1">
      </div></div>
      <div class="col"><div class="form-check">
				      <input disabled type="checkbox" class="form-check-input" name="btn_workday" id="wd2" value="2">
      </div></div>
      <div class="col"><div class="form-check">
				      <input disabled type="checkbox" class="form-check-input" name="btn_workday" id="wd3" value="3">
      </div></div>
      <div class="col"><div class="form-check">
				      <input disabled type="checkbox" class="form-check-input" name="btn_workday" id="wd4" value="4">
      </div></div>
      <div class="col"><div class="form-check">
				      <input disabled type="checkbox" class="form-check-input" name="btn_workday" id="wd5" value="5">
      </div></div>
      <div class="col"><div class="form-check">
				      <input disabled type="checkbox" class="form-check-input" name="btn_workday" id="wd6" value="6">
      </div></div>
      <div class="col"><div class="form-check">
				      <input disabled type="checkbox" class="form-check-input" name="btn_workday" id="wd7" value="7">
      </div></div>
    </div>
    <div class="row mx-auto mb-3">
      <span class="col  text-primary">Mon</span>
      <span class="col  text-primary">Tue</span>
      <span class="col  text-primary">Wed</span>
      <span class="col  text-primary">Thu</span>
      <span class="col  text-primary">Fri</span>
      <span class="col  text-primary">Sat</span>
      <span class="col  text-primary">Sun</span>
    </div>
		<div class="col-12 bg-light text-center mb-1"><strong>Access</strong></div>
		<div class="row mx-auto mb-1">
      <div class="col"><div class="form-check">
				      <input disabled type="checkbox" class="form-check-input" name="btn_access" id="as1" value="R">
      </div></div>
      <div class="col"><div class="form-check">
				      <input disabled type="checkbox" class="form-check-input" name="btn_access" id="as2" value="F">
      </div></div>
      <div class="col"><div class="form-check">
				      <input disabled type="checkbox" class="form-check-input" name="btn_access" id="as3" value="S">
        </div></div>
      <div class="col"><div class="form-check">
				      <input disabled type="checkbox" class="form-check-input" name="btn_access" id="as4" value="T">
      </div></div>
		</div>
		<div class="row mx-auto mb-1">
      <span class="col text-primary">Request</span>
      <span class="col text-primary">Fufill</span>
      <span class="col text-primary">Stock</span>
      <span class="col text-primary">Report</span>
		</div>
		<div class="row mx-auto mb-1">
      <div class="col"><div class="form-check">
				      <input disabled type="checkbox" class="form-check-input" name="btn_access" id="as5" value="C">
      </div></div>
      <div class="col"><div class="form-check">
				      <input disabled type="checkbox" class="form-check-input" name="btn_access" id="as6" value="O">
      </div></div>
			<div class="col"><div class="form-check">
				      <input disabled type="checkbox" class="form-check-input" name="btn_access" id="as7" value="A">
      </div></div>
			<div class="col">
			</div>
    </div>
    <div class="row mx-auto mb-3">
      <span class="col text-primary">Shift</span>
			<span class="col text-primary">MyAccount</span>
      <span class="col text-primary">Admin</span>
			<span class="col text-primary">&nbsp;</span>
    </div>
		<div class="col-12 bg-light text-center mb-1"><strong>Store</strong></div>
		<div class="row mx-auto">
		<?
		$sql = "SELECT `c_name` FROM `t_store`";
		$result = $conn->query($sql);
		$idx = 0;
		while($row = $result->fetch_assoc()) {
			$arrayStore[$idx] = $row["c_name"];
		?>
		<div class="col"><div class="form-check">
						<input type="radio" class="form-check-input" name="btn_store" id="st<?echo $idx?>" value="<?echo $arrayStore[$idx]?>" disabled>
		</div></div>
		<?
		$idx++;
		}
		$conn->close();
		?>
			<div class="col"><div class="form-check">
							<input type="radio" class="form-check-input" name="btn_store" id="st<?echo $idx++?>" value="ALL" disabled>
			</div></div>
			<div class="col"><div class="form-check">
							<input type="radio" class="form-check-input" name="btn_store" id="as<?echo $idx?>" value="NONE" disabled>
			</div></div>
		</div>
		<div class="row mx-auto mb-3">
		<?
		for ($idx=0;$idx<count($arrayStore);$idx++) {
				echo "<span class=\"col text-primary\">".$arrayStore[$idx]."</span>";
		}
		?>
			<span class="col text-primary">ALL</span>
			<span class="col text-primary">NONE</span>
		</div>
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
