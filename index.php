<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Stocking</title>
	<link rel="stylesheet" href="css/bootstrap.min.css">
  <link rel="stylesheet" href="css/styles.css">
	<script src="js/bootstrap.min.js"></script>
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

		<div class="row mb-2">
			<div class="col-2 text-left align-text-bottom mt-2"><strong>Store:&nbsp</strong></div>
			<div class="btn-group col-10" role="group">
				<?
					include 'connect_db.php';
			        $sql = "SELECT * FROM `t_store`";
        			$result = $conn->query($sql);
        			if ($result->num_rows > 0) {
		            while($row = $result->fetch_assoc()) {
				?>
              <input type="radio" class="btn-check" name="bt_store" id="<? echo $row["c_name"] ?>" autocomplete="off">
							<label class="btn btn-outline-primary" for="<? echo $row["c_name"] ?>"><? echo $row["c_name"] ?></label>
				<?
					    	}
			        } else {
			            	echo "ERROR! No requesting store found.";
          		}
				?>
			</div> <!-- btn group -->
		</div> <!-- row -->
		<div class="row mb-4">
			<div class="col-2 text-left align-text-bottom mt-2"><strong>CAT:&nbsp</strong></div>
			<div class="btn-group col-10" role="group">
				<?
			        $sql = "SELECT * FROM `t_cat`";
        			$result = $conn->query($sql);
        			if ($result->num_rows > 0) {
		            while($row = $result->fetch_assoc()) {
				?>
              <input type="radio" class="btn-check" name="bt_cat" id="<? echo $row["c_cat"] ?>" autocomplete="off">
							<label class="btn btn-outline-primary" for="<? echo $row["c_cat"] ?>"><? echo $row["c_cat"] ?></label>
				<?
					    	}
			        } else {
			            echo "ERROR! No category found.";
          		}
				?>
			</div> <!-- btn group -->
		</div> <!-- row. selection area -->

		<div class="row col">
			<?
				$sql = "SELECT `t_item`.`c_item`, `t_item`.`c_cat`, `t_request`.`c_store`,`t_request`.`c_qty` FROM `t_item` LEFT JOIN `t_request` ON `t_item`.`c_item` = `t_request`.`c_item`;";
				$result = $conn->query($sql);
				if ($result->num_rows > 0) {
					$rownum = 0;
					while($row = $result->fetch_assoc()) {
						$rownum = $rownum + 1;
						$cardID = "itemcard".$rownum;
						$radioID = "reqQty".$rownum;
			?>
				<div class="card" id="<? echo $cardID ?>" data-stocking-item="<? echo $row["c_item"] ?>" data-stocking-cat="<? echo $row["c_cat"] ?>" data-stocking-store="<? echo $row["c_store"] ?>">
				  <div class="card-body">
				    <span class="card-title fs-5"><? echo $row["c_item"] ?></span>&nbsp<span class="card-subtitle fs-6 mb-2 text-muted"><? echo "open request: ".$row["c_qty"] ?></span>
						<div class="btn-group col-12" role="group">
						  <input type="radio" class="btn-check" name="<? echo $radioID ?>" id="<? echo $radioID ?>1" autocomplete="off">
						  <label class="btn btn-outline-primary" for="<? echo $radioID ?>1">1</label>
						  <input type="radio" class="btn-check" name="<? echo $radioID ?>" id="<? echo $radioID ?>2" autocomplete="off">
						  <label class="btn btn-outline-primary" for="<? echo $radioID ?>2">2</label>
						  <input type="radio" class="btn-check" name="<? echo $radioID ?>" id="<? echo $radioID ?>3" autocomplete="off">
						  <label class="btn btn-outline-primary" for="<? echo $radioID ?>3">3</label>
							<input type="radio" class="btn-check" name="<? echo $radioID ?>" id="<? echo $radioID ?>4" autocomplete="off">
						  <label class="btn btn-outline-primary" for="<? echo $radioID ?>4">10</label>
							<input type="radio" class="btn-check" name="<? echo $radioID ?>" id="<? echo $radioID ?>5" autocomplete="off">
						  <label class="btn btn-outline-primary" for="<? echo $radioID ?>5">50</label>
						</div> <!-- qty button -->
				  </div> <!-- card body-->
				</div> <!-- card -->
			<?
						}
					} else {
								echo "ERROR! No category found.";
					}
					$conn->close();
			?>
		</div> <!-- item list -->

	 </div> <!-- container -->
</body>
</html>
