<!doctype html>
<html lang="en">
  <head>

    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/styles.css">
    <script src="../js/bootstrap.min.js"></script>
  </head>

  <body>
    <h1 class="text-center" id="title">TEST</h1>
    <div class="row mb-1">
      <div class="input-group mb-3">
        <select class="form-select">
          <option selected>yyyy</option>
          <option value="1" disabled>One</option>
          <option value="2">Two</option>
          <option value="3">Three</option>
        </select>
      </div>
		</div> <!-- row -->


<script>
</script>
<?
  include "../mylog.php";
  $jd = date_create_from_format("Y/n/j","2022/42/32");
  myLOG($jd);
  if ($jd  == FALSE) {
   echo "NULL";
  }else
  {
      echo print_r($jd);
  }

?>
<button type="button" class="btn btn-secondary" id="btn_cancel" onclick="f_test()">TEST</button>
</html>
