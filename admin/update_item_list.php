<?php

  include("../layout/header.php");

  if($_SESSION['Is_Admin'] AND !empty($_POST))
  { 
    include("mysql/mysql_connect.php");   
    
    $compId = $_SESSION['Comp_ID'];
    
    if(isset($_POST['Update'])) /* If item list is updated manually, through the update button */
    {   
      unset($_POST['Update']); /* Unset to make sure it it not taken into account when retrieving items data */

      $array = array_reverse($_POST); /* Item ends are detected with Item-Id, reverse to force order */
          
      $jsonArray = array();
      $itemArray = array();
      $blockArray = array();
      
      foreach($array as $key=>$value)
      {
        if(substr($key,0,10) != "Block-Name") /* If parameter doesn't belong to a block */
        { 
          $itemParameter = explode("_", $key); /* Remove random int at the end of each parameters */

          if($itemParameter[0] == "Item-Id") /* If end of the item data is reached */ 
          {
            $blockArray[$value] = array_reverse($itemArray); /* Store item in block array with original order */
            $itemArray = array();
          }
          else /* While parameter belongs to current item */
          { 
            $itemArray[$itemParameter[0]] = $value; /* Store parameter value in item array */ 
          }
        }
        else /* If parameter is the current block name */
        {
          $jsonArray[strtoupper($value)] = array_reverse($blockArray); /* Store block in objects array */
          $blockArray = array();
        }
      }
      
      $jsonArray = array_reverse($jsonArray); /* Reverse the object array to retrieve original order*/
      $json = mysqli_real_escape_string($conn, json_encode($jsonArray)); 

      $sql = "UPDATE #PREFIX_Main SET Data_Json = '$json' WHERE ID_Comp = '$compId';";      
      
      if($conn->query($sql))
      {      
        $status = true;
        $displayText = "Produits mis à jour avec succès !";    
      }    
      else    
      {      
        $status = false;
        $displayText = "&Eacute;chec de la mise à jour de la liste des produits...";
        $error = mysqli_error($conn); 
      }
    }
    
    elseif(isset($_FILES['CSVupload'])) /* If item list is updated by loading a CSV file */
    {
      $csvArray = array();
      $errors = array();
      $allowedExt = array('.csv');

      $fileName = $_FILES['CSVupload']['name'];
      $fileExt = strtolower(end(explode('.', $fileName)));
      $fileSize = $_FILES['CSVupload']['size'];
      $fileTEmp = $_FILES['CSVupload']['tmp_name'];

      if(in_array($allowedExt) === false) /* If the provided file is not a CSV */
      {
        $errors[] = 'Extension de fichier non valide !';
      }
      if ($fileSize > 10485760) /* If file size is greater than 10 Mo */
      {
        $errors[] = 'Taille du fichier supérieure à 10 Mo !';
      }
      if(empty($errors)) /* If no error occured */
      {
        $handle = fopen($fileTEmp, "r"); /* Open file */

        while(!feof($handle)) 
        {
          array_push($csvArray, (fgetcsv($handle, 0, ';'))); /* Read each line */
        }
      }

      fclose($handle); /* Close file */ 
      
      $csvArray = array_reverse($csvArray); /* Block are detected with by name, reverse to force order */
      $blockArray = array();

      foreach($csvArray as $line)
      {
        if($line[0] != '') /* If line is not empty */
        { 
          if($line[1] != '') /* If line corresponds to an item */
          {
            $item = array();
            $item['Item-Name'] = $line[0];
            $item['Item-Price'] = str_replace(',', '.', $line[1]); /* Force decimal point to be used */
            $item['Item-Image'] = $line[2]; 
            $item['Item-Descr'] = $line[3];
            $blockArray['_'.rand(0,1000000000000)] = $item; /* Generate random integer to identify item */
          }
          else
          {
            $jsonArray[$line[0]] = array_reverse($blockArray); /* Store item in block array with original order */
            $blockArray = array();
          }
        }
      }
      
      $jsonArray = array_reverse($jsonArray); /* Reverse the object array to retrieve original order*/
      $json = mysqli_real_escape_string($conn, json_encode($jsonArray));
            
      $sql = "UPDATE #PREFIX_Main SET Data_Json = '$json' WHERE ID_Comp = '$compId';";  
      
      if($conn->query($sql))    
      {      
        $status = true;
        $displayText = "Fichier chargé avec succès !";    
      }    
      else    
      {      
        $status = false;
        $displayText = "&Eacute;chec du chargement du fichier...";
        $error = mysqli_error($conn); 
      }
    }
    
    /* Retrieve all orders already registered in DB */
    $results = $conn->query("SELECT * FROM #PREFIX_$compId ORDER BY Name ASC;");    
    
    /* For each order in DB */
    while($row = $results->fetch_assoc())
    {
      $order = json_decode($row['Order_Data'], true);
      
      $blockArray = array();
      $amount = 0;
      
      foreach($jsonArray as $blockKey=>$blockValue)
      {
        $itemArray = array();
        $quantity = 0;
        
        foreach($blockValue as $itemKey=>$itemValue)
        {
          $itemName = $itemValue['Item-Name'];
          if(!is_numeric($order[$blockKey][$itemName])) $order[$blockKey][$itemName] = 0; /* Check if item exists in order, set to 0 if not */
          $itemArray[$itemName] = $order[$blockKey][$itemName]; /* Set quantity for current item in order */
          $amount += $itemValue['Item-Price'] * $order[$blockKey][$itemName]; /* Calculate total amount for order */
          $quantity += $order[$blockKey][$itemName]; /* Calculate quantity ordered for current block */
        }    
        $itemArray['Given'] = (int)($quantity == 0); /* Set block as Given if no item is selected in said block */
        $blockArray[$blockKey] = $itemArray; /* Add item to block */
      }
      $json = mysqli_real_escape_string($conn, json_encode($blockArray));

      $sql = "UPDATE #PREFIX_$compId SET Order_Data = '$json', Order_Total = $amount WHERE ID = '".$row['ID']."';";

      if($conn->query($sql))    
      {      
        $status = true;   
      }    
      else    
      {      
        $status = false;
        $displayText = "&Eacute;chec du de la mise à jour des commandes déjà enregistrées...";
        $error = mysqli_error($conn); 
      }
    }
    $conn->close();
  }
  
  
?>
      <form action="<?php echo $baseUrl; ?>/admin/handle_items.php" method="POST" id="ItemForm">  
        <input type="hidden" value="<?php echo $status; ?>" name="Status" />
        <input type="hidden" value="<?php echo $displayText; ?>" name="Display_Text" />
        <input type="hidden" value="<?php echo $error; ?>" name="Error" />
      </form>
<?php

  include("layout/footer.php");

?>
<script>
  $('#ItemForm').submit();
</script>
