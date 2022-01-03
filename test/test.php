<?
   include "../mylog.php";

  myLOG("called\n" . print_r($$_POST["strSQL"],TRUE));
  myLOG("test");
  echo $_POST["strSQL"];
?>
