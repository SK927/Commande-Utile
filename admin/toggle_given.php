<?php

  include("../layout/header.php");

  if($_SESSION['Is_Admin'] AND !empty($_POST))
  {    
    include("mysql/mysql_connect.php");
    
    $compId = $_SESSION['Comp_ID'];
    $block = $_POST['Block'];
    $orderId = $_POST['ID'];
    
    /* Get selected order data*/
    $results = $conn->query("SELECT Order_Data FROM #PREFIX_$compId WHERE ID = '$orderId';"); 
    
    if($results)
    {
      $row = $results->fetch_assoc();
      $orderArray = json_decode($row['Order_Data'], true);
      $orderArray[$block]['Given'] = (int)!$orderArray[$block]['Given']; /* Change given status for selected block to opposite*/
      
      $json = mysqli_real_escape_string($conn, json_encode($orderArray));
      
      /* Set new order data for selected order */
      $sql = "UPDATE #PREFIX_$compId SET Order_Data = '$json' WHERE ID = '$orderId';";
      
      if($conn->query($sql))
      {
        $status = true;
        $displayText = "Statut de distribution mis à jour avec succès !";
      }
      else{
        $status = false;
        $displayText = "&Eacute;chec de la mise à jour du statut de distribution...";
        $error = mysqli_error($conn);
      }
    }
    $conn->close();
  }
  else
  {
    header("Location: $baseUrl");    
    exit();
  }
  
?>
      <form action="<?php echo $baseUrl; ?>/admin/#<?php echo $orderId; ?>" method="POST" id="GivenForm">  
        <input type="hidden" value="<?php echo $compId; ?>" name="Comp_ID" />
        <input type="hidden" value="<?php echo $status; ?>" name="Status" />
        <input type="hidden" value="<?php echo $displayText; ?>" name="Display_Text" />
        <input type="hidden" value="<?php echo $error; ?>" name="Error" />
      </form>
<?php

  include("layout/footer.php");
  
?>
<script>
  $('#GivenForm').submit();
</script>
