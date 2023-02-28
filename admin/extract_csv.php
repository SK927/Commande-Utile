<?php
  
  set_include_path("#BASEFTP");
  require("sessions/mysql_session_handler.php");
  include("includes/get_competition_data.php");

  if($_SESSION['Is_Admin'] AND !empty($_POST))
  {    
    include("mysql/mysql_connect.php");

    $compId = $_SESSION['Comp_ID'];
    $columns = array(); /* Create file header */
    
    $results = $conn->query("SELECT * FROM #PREFIX_$compId ORDER BY Name ASC;");
    $conn->close();

    if($results->num_rows)
    { 
      while($field = $results->fetch_field())
      {
        array_push($columns, $field->name); /* Add new column name to header */
      }
      
      foreach($competitionJson as $blockKey=>$blockValue)
      {
        foreach($blockValue as $itemKey=>$itemValue)
        {
          $tempColumns[$itemKey] = $blockKey."_".$itemValue['Item-Name']; /* Add item name to temporary header */
        }
        $tempColumns[$blockKey] = $blockKey."_Given"; /* Add given status to temporary header for current block */
      }
      
      $columns = array_merge(array_slice($columns , 0, 4), $tempColumns, array_slice($columns , 5)); /* Remove Order_Data columns and insert temporary header in final header */
      
      $delimiter = ";"; 
      $filename = $compId."_Commandes_Extract--".date('Y-m-d').".csv"; 
      
      $f = fopen('php://memory', 'w');
      fputcsv($f, $columns, $delimiter); /* Write header to buffer */
    
      while($row = $results->fetch_assoc()) /* For each order placed */
      {
        $competitionJson = json_decode($row['Order_Data'], true); /* Decode order Json */
        
        foreach($competitionJson as $blockKey=>$blockValue)
        {
          foreach($blockValue as $itemKey=>$itemValue)
          {
            $tempItems[$blockKey.$itemKey] = $itemValue; /* Add current item ordered amount in temporary block */
          }
        }
        
        $row = array_merge(array_slice($row, 0, 4), $tempItems, array_slice($row, 5)); /* Remove Order_Data data and insert temporary block in final data */
        fputcsv($f, $row, $delimiter); /* Write each order to buffer */
      } 
      
      fseek($f, 0); 
       
      header('Content-Type: text/csv'); 
      header('Content-Disposition: attachment; filename="' . $filename . '";'); 
      
      fpassthru($f); 
    }  
    else
    {
      /* Placeholder */
    }
  }
  else
  {
    header("Location: $baseUrl");    
    exit();
  }
  
?>
