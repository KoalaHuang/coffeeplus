<!doctype html>
<html lang="en">
  <head>

    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/styles.css">
    <script src="../js/bootstrap.min.js"></script>
    <script src="test.js"></script>
  </head>

  <body>

<?
  include "../connect_db.php";

  $sql = "SELECT * FROM `t_request` WHERE `c_qty` > 0;";
  $stmt = $conn->prepare("SELECT `c_storage`, `c_qty` FROM `t_stock` WHERE `c_item`=?");
  $stmt->bind_param("s", $c_item );
  $result = $conn->query($sql);
  if ($result->num_rows > 0) {
    $rownum = 0;
    while($row = $result->fetch_assoc()) {
      $rownum = $rownum + 1;
      $cardID = "itemcard".$rownum;
      $radioID = "reqQty".$rownum;
      $c_item = $row["c_item"];
      $c_qty_req = $row["c_qty"];
?>
  <div class="card" id="<? echo $cardID ?>" data-stocking-item="<? echo $c_item ?>" data-stocking-cat="<? echo $row["c_cat"] ?>" data-stocking-store="<? echo $row["c_store"] ?>">
    <div class="card-body">
      <span class="card-title fs-5"><? echo $c_item ?></span>&nbsp<span class="card-subtitle fs-6 mb-2 text-muted"><? echo "open request: ".$c_qty_req; ?></span>
      <div>
        <?
          $stockRowNum = 0;
          if ($stmt->execute()) {
            $stmt_result = $stmt->get_result();
            $stock=array(array());
            while($stk=$stmt_result->fetch_assoc())
            {
             $stock[$stockRowNum][0] = $stk['c_storage'];
             $stock[$stockRowNum][1] = $stk['c_qty'];
             $stockRowNum++;
            } //loop stock data
            echo print_r($stock, true);
        ?>
            </div>
        <?
          }else{
            echo "Error in getting stock data!";
            die;
          } //if_stock data
        ?>
        </div> <!--card body-->
        <?
        } // loop request data
        ?>
        </div> <!--card-->
        <?
      } //if_request data
      $stmt->close();
      $conn->close();
    ?>
</body>
</html>
