<!doctype html>
<html lang="en">
  <head>

    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/styles.css">
    <script src="../js/bootstrap.min.js"></script>
  </head>

  <body>
    <h1 class="text-center">TEST</h1>
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
  </body>
<script>
function f_hide(){
  const objItems = [];

  var obj ={
    "c": "Ice Cream", //category of item
    "i": "Mango", //item name
    "s": "FR Storage" //storage
  }
  objItems.push(obj);
  console.log(objItems);
  document.getElementById("iptItem").value = objItems[0].c;
}
</script>
</html>
