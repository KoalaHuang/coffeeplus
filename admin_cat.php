<?
/*
Item Admin page.  Add/change item name, storage location
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
	<title>Stocking</title>
	<link rel="stylesheet" href="css/bootstrap.min.css">
  <link rel="stylesheet" href="css/styles.css">
	<script src="js/bootstrap.min.js"></script>
	<script src="js/nav.js"></script>
	<script src="js/admin_item.js"></script>
</head>
<body>
	<? include "navbar.php" ?>

	<div class="container">
		<h1 id="section_home" class="text-center mb-2">Admin - Category</h1>

		<div id="reminding" class="text-center mb-3 col-12 fst-italic fs-6">coming...</div>
 	</div> <!-- container -->

	<!-- Modal Submit-->
	<div class="modal fade" id="modal_box" tabindex="-1">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="lbl_modal">Confirm to submit below request?</h5>
				</div>
				<div class="modal-body fs-6" id="body_modal">
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" id="btn_cancel" onclick="f_refresh()">Cancel</button>
					<button type="button" class="btn btn-primary" id="btn_ok" onclick="f_submit()">OK</button>
				</div>
			</div>
		</div>
	</div>

	<? include "footer.php" ?>
</body>
</html>
