<?php

  /* WARNING: always include before including mysql_connect.php */

  include("mysql/mysql_connect.php");  

  $results = $conn->query("SELECT * FROM #PREFIX_Main WHERE ID_Comp = '".$_SESSION['Comp_ID']."';");    
  $competitionData = $results->fetch_assoc();
  $competitionJson = json_decode($competitionData['Data_Json'], true);

  $conn->close();
  
?>