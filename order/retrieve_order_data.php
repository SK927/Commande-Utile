<?php

  /* WARNING: always include before including mysql_connect.php */

  include("mysql/mysql_connect.php");
  include("includes/hash_functions.php");

  $results = $conn->query("SELECT ID, Order_Data, Comment FROM #PREFIX_".$_SESSION['Comp_ID']." WHERE ID = '".hashUserID($_SESSION['User_ID'], $_SESSION['Comp_ID'])."';");    
  $orderData = $results->fetch_assoc();
  $orderJson = json_decode($orderData['Order_Data'], true);
  
  $conn->close();

?>