<!doctype html>
<html lang="en">
  <head>

    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/styles.css">
    <script src="../js/bootstrap.min.js"></script>
  </head>

  <body>
    <h1 class="text-center">TEST</h1>

<?
$n = 1;
$s = "1234";
if (strstr($s,(string)$n)) {
  echo "OK";
}else{
  echo "not OK";
}
?>

    <div class="container-fluid">
      <select class="form-select" id="mySelect">
        <option selected>Open this select menu</option>
        <option id="option1" value="1" >One</option>
        <option value="2">Two</option>
        <option value="3">Three</option>
      </select>
    </div>
    <input type="text" class="form-control" id="iptItem">

    <button type="button" class="btn btn-primary" onclick="f_hide()">Primary</button>
    <button id="btn_sec" type="button" class="btn btn-primary">Secondary</button>
  </body>
<script>
function f_hide(){
  document.getElementById("btn_sec").innerHTML = "changed";
}
</script>
</html>
