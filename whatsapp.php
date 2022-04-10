<?
  function send_mailNote($to,$subject,$msg){
    // Always set content-type when sending HTML email
    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
    mail($to,$subject,$msg,$headers);
  }

  function send_whatsapp($phone, $apikey, $message){
    $url='https://api.callmebot.com/whatsapp.php?source=php&phone='.$phone.'&text='.urlencode($message).'&apikey='.$apikey;
    $html=file_get_contents($url);
  }

  //send notice via maill or whatsapp. 
  //$type = "R", send notice for stock request
  function send_notice($type,$msg){
    /*
    $servername = "localhost:3307";
    $username = "coffeedb";
    $password = "koala5@FR11";
    $dbname = "coffeedb";
    $conn = new mysqli($servername, $username, $password, $dbname);
    */
    include "connect_db.php";
    if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
    }     
    switch ($type) {
    case "R":
      //send mail notice
      $sqlNotice = "SELECT `c_value` FROM `t_config` WHERE `c_setup`='notice_request' AND `c_subsetup`='mail'";
      $result = $conn->query($sqlNotice);
      if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $to = $row["c_value"];
        while($row = $result->fetch_assoc()) {
          $to = ",".$row["c_value"];
        }
        $subject = "CoffeePlus Stocking - New Request";
        $message = "
        <html>
        <head>
        <title>CoffeePlus Stocking - New Request</title>
        </head>
        <body>
        <h3>$msg</h3>
        <p>Go to <a href=\"http://coffeeplus.sg/bo\">CoffeePlus BackOffice</a> for detail.</p>
        </body>
        </html>
        ";
        send_mailNote($to,$subject,$message);
      }
      //send WhatsApp notice
      $sqlNotice = "SELECT `c_value` FROM `t_config` WHERE `c_setup`='notice_request' AND `c_subsetup`='WA'";
      $result = $conn->query($sqlNotice);
      if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
          $token = strtok($row["c_value"],".");
          $phone = $token;
          $token = strtok(".");
          $apikey = $token;
          $message = $msg."\nGo to http://coffeeplus.sg/bo for detail.";
          send_whatsapp($phone,$apikey,$message);
        }
      }
      break;
    }
    $conn->close();
  }

?>