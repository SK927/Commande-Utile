<?php

  include("#BASEFTPmysql/mysql_connect.php");
  
  $past = time() - 1800;

  $conn->query("DELETE FROM #PREFIX_Sessions WHERE created < $past;");
  $conn->close();  
  
?>