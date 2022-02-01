<nav class="navbar navbar-expand-sm navbar-light bg-white">
  <div class="container-fluid">
    <a class="navbar-brand" href="index.php"><img class="img-fluid align-top" src="img/CoffeePlus_wordlogo.jpeg"><span>&nbspBackOffice</span></a>
    <button class="navbar-toggler bg-light" type="button" data-bs-toggle="collapse" data-bs-target="#navbarToggler" id="btn-nav">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarToggler">
        <ul class="navbar-nav text-center me-2 mb-auto mb-lg-0">
          <li class="nav-item">
            <a class="nav-link <?if (!strstr($_SESSION["access"],"R")) {echo "disabled\"";}?>" href="request.php">Request</a>
          </li>
          <li class="nav-item">
            <a class="nav-link <?if (!strstr($_SESSION["access"],"F")) {echo "disabled\"";}?>" href="fulfil.php">Fulfill</a>
          </li>
          <li class="nav-item">
            <a class="nav-link <?if (!strstr($_SESSION["access"],"S")) {echo "disabled\"";}?>" href="stock.php">Stock</a>
          </li>
          <li class="nav-item">
            <a class="nav-link <?if (!strstr($_SESSION["access"],"T")) {echo "disabled\"";}?>" href="report.php">Report</a>
          </li>
          <li class="nav-item">
            <a class="nav-link <?if (!strstr($_SESSION["access"],"A")) {echo "disabled\"";}?>" href="admin.php">Admin</a>
          </li>
      </ul>
    </div> <!-- navbar-collapse -->
  </div>  <!-- container fluid -->
</nav>
