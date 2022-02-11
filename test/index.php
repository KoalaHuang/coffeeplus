<!doctype html>
<html lang="en">
  <head>

    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/styles.css">
    <script src="../js/bootstrap.min.js"></script>
  </head>

  <body>
    <h1 class="" id="title">TEST</h1>

    <div class="mb-1"><!--month switch-->
  		<?
      $date = date_create_from_format("Y/n/j","2022/2/31");
      $arrayStore[0] = date_format($date,"Y/n/j");
      $arrayStore[1] = ["VP"];
  		$totalStore = count($arrayStore);
  		for ($idxStore=0; $idxStore<$totalStore; $idxStore++){
  		?>
      <div class="form-check form-switch form-check-inline">
    		<input checked class="form-check-input" type="checkbox" id="<? echo "btnST".$idxStore ?>" onclick="f_storeSelected(<?echo $idxStore?>)">
    		<label class="form-check-label fw-bold" for="<? echo "btnST".$idxStore ?>"><? echo $arrayStore[$idxStore] ?></label>
      </div>
  		<?
  		}
  		?>
    </div>
    <div> </div>
    <div class="form-check form-switch form-check-inline">
      <input class="form-check-input" type="checkbox" id="inlineCheckbox1" value="option1">
      <label class="form-check-label" for="inlineCheckbox1">1</label>
    </div>
    <div class="form-check form-switch form-check-inline">
      <input class="form-check-input" type="checkbox" id="inlineCheckbox2" value="option2">
      <label class="form-check-label" for="inlineCheckbox2">2</label>
    </div>
    <div class="form-check form-switch form-check-inline">
      <input class="form-check-input" type="checkbox" id="inlineCheckbox3" value="option3" disabled>
      <label class="form-check-label" for="inlineCheckbox3">3 (disabled)</label>
    </div>

<script>
</script>
<?
  include "../mylog.php";

?>
<button type="button" class="btn btn-secondary mt-5" id="btn_cancel" onclick="f_test()">TEST</button>
</body>
</html>
