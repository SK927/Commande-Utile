<?php
  
  include("#BASEFTPmysql/mysql_connect.php");
  include("#BASEFTPincludes/wcif_functions.php");

  $results = $conn->query("SELECT ID_Comp FROM #PREFIX_Main");
   
  while($row = $results->fetch_assoc())
  {   
    $error = update_from_public_wcif($row['ID_Comp'], $conn);
  }
  $conn->close();
  
?>
  
  
