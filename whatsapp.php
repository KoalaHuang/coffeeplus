<?
  function send_mailNote($msg="Test"){
    $to = "hongjian.huang@gmail.com";
    $subject = "CoffeePlus Stocking - New Request";

    $message = "
    <html>
    <head>
    <title>CoffeePlus Stocking - New Request</title>
    </head>
    <body>
    <h3>$msg</h3>
    <p>Go to <a href=\"http://coffeeplus.ml/stocking/report.php\">CoffeePlus Stocking</a> for detail.</p>
    </body>
    </html>
    ";

    // Always set content-type when sending HTML email
    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

    mail($to,$subject,$message,$headers);
  }

  function send_whatsapp($message="Test"){
      $phone="+6581186516";  // Enter your phone number here
      $apikey="638817";       // Enter your personal apikey received in step 3 above

      $url='https://api.callmebot.com/whatsapp.php?source=php&phone='.$phone.'&text='.urlencode($message).'&apikey='.$apikey;
      $html=file_get_contents($url);
  }
?>
