<?
session_start();

$user = $_SESSION["user"];
if (is_null($user) || ($user == "")) {
  header("Location:login.php");
  exit();
}
$access = $_SESSION["access"];
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>BackOffice</title>
	<link rel="stylesheet" href="css/bootstrap.min.css">
  <link rel="stylesheet" href="css/styles.css">
	<script src="js/bootstrap.bundle.min.js"></script>
  <script src="js/nav.js"></script>
</head>
<body>
	<? include "navbar.php" ?>

	<div class="container">
		<h1 class="text-center text-secondary mb-2">Welcome</h1>
    <h1 class="text-center mb-3 fs-10"><?echo $user;?></h1>
    <div class="d-grid gap-2 col-6 mx-auto">
      <?
      if (strstr($access,"R")) {
        echo "<a href=\"request.php\" class=\"btn btn-primary mb-3\" role=\"button\">Stock - Request</a>";
      }
      if (strstr($access,"F")) {
        echo "<a href=\"fulfil.php\" class=\"btn btn-primary mb-3\" role=\"button\">Stock - Fulfill</a>";
      }
      if (strstr($access,"S")) {
        echo "<a href=\"stock.php\" class=\"btn btn-primary mb-3\" role=\"button\">Stock - Stock</a>";
      }
      if (strstr($access,"T")) {
        echo "<a href=\"report.php\" class=\"btn btn-primary mb-3\" role=\"button\">Stock - Report</a>";
      }
      if (strstr($access,"C")) {
        echo "<a href=\"shift.php\" class=\"btn btn-primary mb-3\" role=\"button\">Shift</a>";
      }
      if (strstr($access,"A")) {
        echo "<div class=\"btn-group\" role=\"group\">";
        echo "<button type=\"button\" id=\"btnGroupDrop1\" class=\"btn btn-primary dropdown-toggle\" data-bs-toggle=\"dropdown\">Admin</button>";
        echo "<ul class=\"dropdown-menu\"  aria-labelledby=\"btnGroupDrop1\">";
        echo "<li><a class=\"dropdown-item\" href=\"admin_item.php\">Item</a></li>";
        echo "<li><a class=\"dropdown-item\" href=\"admin_cat.php\">Category</a></li>";
        echo "<li><a class=\"dropdown-item\" href=\"admin_user.php\">User</a></li>";
        echo "</ul></div>";
      }
      if (strstr($access,"O")) {
        echo "<a href=\"myaccount.php\" class=\"btn btn-primary mb-3\" role=\"button\">My Account</a>";
      }
    ?>
    </div>
  </div> <!-- container -->

	<? include "footer.php" ?>
</body>
</html>
