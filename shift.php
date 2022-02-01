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
		$day = 1;
	?>

	<h1 id="section_home" class="text-center mb-2">Shift</h1>

	<div class="container">
	  <div class="row row-cols-7 g-0 mb-1">
			<div class="col">
	      <div class="border bg-light text-center">M</div>
	    </div>
	    <div class="col">
	      <div class="border bg-light text-center">T</div>
	    </div>
	    <div class="col">
	      <div class=" border bg-light text-center">W</div>
	    </div>
	    <div class="col">
	      <div class="border bg-light text-center">T</div>
	    </div>
	    <div class="col">
	      <div class="border bg-light text-center">F</div>
	    </div>
	    <div class="col">
	      <div class="border bg-light text-center">S</div>
	    </div>
	    <div class="col">
	      <div class="border bg-light text-center">S</div>
	    </div>
	  </div> <!-- row -->
		<div class="row row-cols-7 g-0 mb-1">
			<div class="col">
				<div class="text-center bg-light fs-8"><a href="#"><?echo $day++?></a></div>
				<div class="text-center fs-6">YL</div>
				<div class="text-center fs-6">XM</div>
				<div class="text-center fs-6 text-warning"></div>
			</div>
			<div class="col">
				<div class="text-center bg-light fs-8"><a class="text-danger" href="#"><?echo $day++;?></a></div>
				<div class="text-center fs-6">YL</div>
				<div class="text-center fs-6">XM</div>
				<div class="text-center fs-6 text-warning"></div>
			</div>
			<div class="col">
				<div class="text-center bg-light fs-8"><a class="text-danger" href="#"><?echo $day++;?></a></div>
				<div class="text-center fs-6">YL</div>
				<div class="text-center fs-6">XM</div>
				<div class="text-center fs-6 text-warning"></div>
			</div>
			<div class="col">
				<div class="text-center bg-light fs-8"><a href="#"><?echo $day++;?></a></div>
				<div class="text-center fs-6">YL</div>
				<div class="text-center fs-6">XM</div>
				<div class="text-center fs-6 text-warning"></div>
			</div>
			<div class="col">
				<div class="text-center bg-light fs-8"><a href="#"><?echo $day++;?></a></div>
				<div class="text-center fs-6">YL</div>
				<div class="text-center fs-6">XM</div>
				<div class="text-center fs-6 text-warning"></div>
			</div>
			<div class="col">
				<div class="text-center bg-light fs-8"><a href="#"><?echo $day++;?></a></div>
				<div class="text-center fs-6">YL</div>
				<div class="text-center fs-6">XM</div>
				<div class="text-center fs-6 text-warning">AM</div>
			</div>
			<div class="col">
				<div class="text-center bg-light fs-8"><a href="#"><?echo $day++;?></a></div>
				<div class="text-center fs-6">YL</div>
				<div class="text-center fs-6">XM</div>
				<div class="text-center fs-6 text-warning">AM</div>
			</div>
	  </div> <!-- row -->
		<div class="row row-cols-7 g-0 mb-1">
			<div class="col">
				<div class="text-center bg-light fs-8"><a href="#"><?echo $day++?></a></div>
				<div class="text-center fs-6">YL</div>
				<div class="text-center fs-6">XM</div>
				<div class="text-center fs-6 text-warning"></div>
			</div>
			<div class="col">
				<div class="text-center bg-light fs-8"><a href="#"><?echo $day++;?></a></div>
				<div class="text-center fs-6">YL</div>
				<div class="text-center fs-6">XM</div>
				<div class="text-center fs-6 text-warning"></div>
			</div>
			<div class="col">
				<div class="text-center bg-light fs-8"><a href="#"><?echo $day++;?></a></div>
				<div class="text-center fs-6">YL</div>
				<div class="text-center fs-6">XM</div>
				<div class="text-center fs-6 text-warning"></div>
			</div>
			<div class="col">
				<div class="text-center bg-light fs-8"><a href="#"><?echo $day++;?></a></div>
				<div class="text-center fs-6">YL</div>
				<div class="text-center fs-6">XM</div>
				<div class="text-center fs-6 text-warning"></div>
			</div>
			<div class="col">
				<div class="text-center bg-light fs-8"><a href="#"><?echo $day++;?></a></div>
				<div class="text-center fs-6">YL</div>
				<div class="text-center fs-6">XM</div>
				<div class="text-center fs-6 text-warning"></div>
			</div>
			<div class="col">
				<div class="text-center bg-light fs-8"><a href="#"><?echo $day++;?></a></div>
				<div class="text-center fs-6">YL</div>
				<div class="text-center fs-6">XM</div>
				<div class="text-center fs-6 text-warning">AM</div>
			</div>
			<div class="col">
				<div class="text-center bg-light fs-8"><a href="#"><?echo $day++;?></a></div>
				<div class="text-center fs-6">YL</div>
				<div class="text-center fs-6">XM</div>
				<div class="text-center fs-6 text-warning">AM</div>
			</div>
	  </div> <!-- row -->
		<div class="row row-cols-7 g-0 mb-1">
			<div class="col">
				<div class="text-center bg-light fs-8"><a href="#"><?echo $day++?></a></div>
				<div class="text-center fs-6">YL</div>
				<div class="text-center fs-6">XM</div>
				<div class="text-center fs-6 text-warning"></div>
			</div>
			<div class="col">
				<div class="text-center bg-light fs-8"><a href="#"><?echo $day++;?></a></div>
				<div class="text-center fs-6">YL</div>
				<div class="text-center fs-6">XM</div>
				<div class="text-center fs-6 text-warning"></div>
			</div>
			<div class="col">
				<div class="text-center bg-light fs-8"><a href="#"><?echo $day++;?></a></div>
				<div class="text-center fs-6">YL</div>
				<div class="text-center fs-6">XM</div>
				<div class="text-center fs-6 text-warning"></div>
			</div>
			<div class="col">
				<div class="text-center bg-light fs-8"><a href="#"><?echo $day++;?></a></div>
				<div class="text-center fs-6">YL</div>
				<div class="text-center fs-6">XM</div>
				<div class="text-center fs-6 text-warning"></div>
			</div>
			<div class="col">
				<div class="text-center bg-light fs-8"><a href="#"><?echo $day++;?></a></div>
				<div class="text-center fs-6">YL</div>
				<div class="text-center fs-6">XM</div>
				<div class="text-center fs-6 text-warning"></div>
			</div>
			<div class="col">
				<div class="text-center bg-light fs-8"><a href="#"><?echo $day++;?></a></div>
				<div class="text-center fs-6">YL</div>
				<div class="text-center fs-6">XM</div>
				<div class="text-center fs-6 text-warning">AM</div>
			</div>
			<div class="col">
				<div class="text-center bg-light fs-8"><a href="#"><?echo $day++;?></a></div>
				<div class="text-center fs-6">YL</div>
				<div class="text-center fs-6">XM</div>
				<div class="text-center fs-6 text-warning">AM</div>
			</div>
	  </div> <!-- row -->
		<div class="row row-cols-7 g-0 mb-1">
			<div class="col">
				<div class="text-center bg-light fs-8"><a href="#"><?echo $day++?></a></div>
				<div class="text-center fs-6">YL</div>
				<div class="text-center fs-6">XM</div>
				<div class="text-center fs-6 text-warning"></div>
			</div>
			<div class="col">
				<div class="text-center bg-light fs-8"><a href="#"><?echo $day++;?></a></div>
				<div class="text-center fs-6">YL</div>
				<div class="text-center fs-6">XM</div>
				<div class="text-center fs-6 text-warning"></div>
			</div>
			<div class="col">
				<div class="text-center bg-light fs-8"><a href="#"><?echo $day++;?></a></div>
				<div class="text-center fs-6">YL</div>
				<div class="text-center fs-6">XM</div>
				<div class="text-center fs-6 text-warning"></div>
			</div>
			<div class="col">
				<div class="text-center bg-light fs-8"><a href="#"><?echo $day++;?></a></div>
				<div class="text-center fs-6">YL</div>
				<div class="text-center fs-6">XM</div>
				<div class="text-center fs-6 text-warning"></div>
			</div>
			<div class="col">
				<div class="text-center bg-light fs-8"><a href="#"><?echo $day++;?></a></div>
				<div class="text-center fs-6">YL</div>
				<div class="text-center fs-6">XM</div>
				<div class="text-center fs-6 text-warning"></div>
			</div>
			<div class="col">
				<div class="text-center bg-light fs-8"><a href="#"><?echo $day++;?></a></div>
				<div class="text-center fs-6">YL</div>
				<div class="text-center fs-6">XM</div>
				<div class="text-center fs-6 text-warning">AM</div>
			</div>
			<div class="col">
				<div class="text-center bg-light fs-8"><a href="#"><?echo $day++;?></a></div>
				<div class="text-center fs-6">YL</div>
				<div class="text-center fs-6">XM</div>
				<div class="text-center fs-6 text-warning">AM</div>
			</div>
	  </div> <!-- row -->

	</div> <!-- container -->

	<? include "footer.php" ?>
</body>
</html>
