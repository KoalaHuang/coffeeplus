<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Stocking</title>
	<link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>

	<nav class="navbar navbar-expand-sm navbar-light bg-white">
	  <div class="container-fluid">
	    <a class="navbar-brand" href="#"><img class="img-fluid align-top" src="/img/CoffeePlus_wordlogo.jpeg"><span class="align-text-bottom">&nbspStocking</span></a>
	    <button class="navbar-toggler bg-danger" type="button" data-bs-toggle="collapse" data-bs-target="#navbarToggler">
	      <span class="navbar-toggler-icon"></span>
	    </button>
	    <div class="collapse navbar-collapse" id="navbarToggler">
	      	<ul class="navbar-nav text-center me-2 mb-auto mb-lg-0">
		        <li class="nav-item">
		          <a class="nav-link" href="#section_chicken">Request</a>
		        </li>
		        <li class="nav-item">
		          <a class="nav-link" href="#section_beef">Transfer</a>
		        </li>
		        <li class="nav-item">
		          <a class="nav-link" href="#section_sushi">TopUp</a>
		        </li>
		        <li class="nav-item">
		          <a class="nav-link" href="#section_sushi">Inventory</a>
		        </li>
		        <li class="nav-item">
		          <a class="nav-link" href="#section_sushi">Admin</a>
		        </li>
		    </ul>
	    </div> <!-- navbar-collapse -->
	  </div>  <!-- container fluid -->
	</nav>

	<div class="container">
		<h1 id="section_home" class="text-center mb-2">Request</h1>

		<div class="row">
			<div class="col-1 text-center align-text-bottom mt-2"><strong>Store:&nbsp</strong></div>
			<div class="btn-group col-11" role="group">
				<?
					include 'connect_db.php';
			        $sql = "SELECT * FROM `t_location` WHERE `c_to`";
          			$result = $conn->query($sql);
          			if ($result->num_rows > 0) {
			            while($row = $result->fetch_assoc()) {
				?>
              <input type="radio" class="btn-check" name="bt_location" id="<? echo $row["c_location"] ?>" autocomplete="off">
							<label class="btn btn-outline-primary" for="<? echo $row["c_location"] ?>"><? echo $row["c_location"] ?></label>
				<?
					    }
			        } else {
			            echo "ERROR! No item found.";
          			}
			        $conn->close();
				?>
			</div> <!-- btn group -->
		</div> <!-- row -->
	 </div> <!-- container -->

	<!-- jQuery (Bootstrap JS plugins depend on it) -->
	<script src="js/bootstrap.min.js"></script>
</body>
</html>
