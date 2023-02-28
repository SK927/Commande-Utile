<?php
  set_include_path("#BASEFTP");

  require("sessions/mysql_session_handler.php");
  
  session_unset();
  session_destroy();
  
  header("Location: https://".$_SERVER['SERVER_NAME']);    
  exit();  
  
?>