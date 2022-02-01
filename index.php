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
	<script src="js/bootstrap.min.js"></script>
  <script src="js/nav.js"></script>
</head>
<body>
	<? include "navbar.php" ?>

	<div class="container">
		<h1 class="text-center text-secondary mb-2">Welcome</h1>
    <h1 class="text-center mb-3 fs-10"><?echo $user;?></h1>

    <?
    echo "<div class=\"d-grid gap-2 col-6 mx-auto\">";
    echo "<a href=\"request.php\" class=\"btn btn-primary mb-3 ";
    if (!strstr($access,"R")) {echo "disabled\"";}
    echo " role=\"button\">Stock - Request</a>";
    echo "<a href=\"fufil.php\" class=\"btn btn-primary mb-3 ";
    if (!strstr($access,"F")) {echo "disabled\"";}
    echo " role=\"button\">Stock - Fufill</a>";
    echo "<a href=\"stock.php\" class=\"btn btn-primary mb-3 ";
    if (!strstr($access,"S")) {echo "disabled\"";}
    echo " role=\"button\">Stock - Stock</a>";
    echo "<a href=\"report.php\" class=\"btn btn-primary mb-3 ";
    if (!strstr($access,"T")) {echo "disabled\"";}
    echo " role=\"button\">Stock - Report</a>";
    echo "<a href=\"admin.php\" class=\"btn btn-primary mb-3 ";
    if (!strstr($access,"A")) {echo "disabled\"";}
    echo " role=\"button\">Stock - Admin</a>";
    echo "<a href=\"calendar.php\" class=\"btn btn-primary mb-3 ";
    if (!strstr($access,"C")) {echo "disabled\"";}
    echo " role=\"button\">Schedule - Calendar</a>";
    echo "</div>";
  ?>

 	</div> <!-- container -->

	<? include "footer.php" ?>
</body>
</html>
