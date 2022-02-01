<nav class="navbar navbar-expand-sm navbar-light bg-white">
  <div class="container-fluid">
    <a class="navbar-brand" href="index.php"><img class="img-fluid align-top" src="img/CoffeePlus_wordlogo.jpeg"><span>&nbspBackOffice</span></a>
    <button class="navbar-toggler bg-light" type="button" data-bs-toggle="collapse" data-bs-target="#navbarToggler" id="btn-nav">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarToggler">
        <ul class="navbar-nav text-center me-2 mb-auto mb-lg-0">
          <?
          if (strstr($_SESSION["access"],"R")) {
          echo "<li class=\"nav-item\">";
          echo "<a class=\"nav-link\" href=\"request.php\">Request</a>";
          echo "</li>";
          }
          if (strstr($_SESSION["access"],"F")) {
          echo "<li class=\"nav-item\">";
          echo "<a class=\"nav-link\" href=\"fulfil.php\">Fulfill</a>";
          echo "</li>";
          }
          if (strstr($_SESSION["access"],"S")) {
          echo "<li class=\"nav-item\">";
          echo "<a class=\"nav-link\" href=\"stock.php\">Stock</a>";
          echo "</li>";
          }
          if (strstr($_SESSION["access"],"R")) {
          echo "<li class=\"nav-item\">";
          echo "<a class=\"nav-link\" href=\"report.php\">Report</a>";
          echo "</li>";
          }
          if (strstr($_SESSION["access"],"C")) {
          echo "<li class=\"nav-item\">";
          echo "<a class=\"nav-link\" href=\"shift.php\">Shift</a>";
          echo "</li>";
          }
          if (strstr($_SESSION["access"],"A")) {
          echo "<li class=\"nav-item dropdown\">";
          echo "<a class=\"nav-link dropdown-toggle\" href=\"#\" id=\"admindropdown\" role=\"button\" data-bs-toggle=\"dropdown\">Admin</a>";
          echo "<ul class=\"dropdown-menu\" aria-labelledby=\"admindropdown\">";
          echo "<li><a class=\"dropdown-item\" href=\"admin_item.php\">Stock Item</a></li>";
          echo "<li><a class=\"dropdown-item\" href=\"admin_cat.php\">Stock Category</a></li>";
          echo "<li><a class=\"dropdown-item\" href=\"admin_user.php\">User</a></li>";
          echo "</ul>";
          echo "</li>";
          }
          ?>
          <li class="nav-item">
            <a class="nav-link" href="logout.php">Logout</a>
          </li>
      </ul>
    </div> <!-- navbar-collapse -->
  </div>  <!-- container fluid -->
</nav>
