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

<h1>My first PHP page</h1>

<?
include 'connect_db.php';

          $sql = "SELECT * FROM `t_location`";
          $result = $conn->query($sql);

          if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {

?>
              <input type="radio" class="btn-check" name="<? echo $row["c_location"] ?>" id="<? echo $row["c_location"] ?>" autocomplete="off"><label class="btn btn-outline-primary" for="<? echo $row["c_location"] ?>"><? echo $row["c_location"] ?></label>
<?          }
          } else {
            echo "ERROR! No item found.";
          }
          $conn->close();
?>

</body>
</html>