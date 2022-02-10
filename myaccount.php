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
	<script src="js/myaccount.js"></script>
</head>
<body>
	<? include "navbar.php" ?>

	<div class="container">
		<h1 id="section_home" class="text-center mb-2">Profile</h1>
		<?
		include "connect_db.php";
		$sql = "SELECT * FROM `t_user` WHERE `c_name`='".$_SESSION["user"]."'";
		$result = $conn->query($sql);
		if ($result->num_rows > 0) {
			while($row = $result->fetch_assoc()) {
				$c_name = $row["c_name"];
				$c_access = $row["c_access"];
				$c_id = $row["c_id"];
				$c_workday = $row["c_workday"];
			}
		}else{
			echo "Data error!";
			die;
		}
		$conn->close();
		?>
		<div class="row mt-3">
		<div class="input-group mb-3">
			<span class="input-group-text">Name</span>
		  <input type="text" class="form-control" id="iptName" value="<?echo $c_name?>" disabled>
		</div> <!--name-->
		<div class="input-group mb-3">
			<span class="input-group-text">ID</span>
		  <input type="text" class="form-control" id="iptID" value="<?echo $c_id?>" disabled>
		</div> <!--initial-->
		<div class="input-group mb-3">
			<span class="input-group-text">password</span>
		  <input type="password" placeholder="key in new password" class="form-control" id="iptPwd">
		</div> <!--pwd-->
		<div class="row">
			<span><button type="button" id="btn_toConfirm" class="btn btn-primary col-3 me-5" onclick="f_toConfirm()">OK</button>
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
