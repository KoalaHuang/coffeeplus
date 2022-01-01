<?php
$servername = "localhost:3307";
$username = "coffeedb";
$password = "koala5@FR11";
$dbname = "coffeedb";


// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
} 
$sql = "SELECT * FROM `t_cat`";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
  // output data of each row
  while($row = $result->fetch_assoc()) {
    echo $result;
  }
} else {
  echo "";
}
$conn->close();
?>