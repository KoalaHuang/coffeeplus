
<?php
// Start the session
session_start();
// remove all session variables
session_unset();
// destroy the session
session_destroy();
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
	<? include "navbar.php"; ?>

	<h1 class="text-center mb-2">Logout</h1>
	<div class="text-center mb-3 text-muted col-12 fst-italic fs-12">See you...</div>

	<div class="container">
 	</div> <!-- container -->

	<? include "footer.php" ?>
</body>
</html>
