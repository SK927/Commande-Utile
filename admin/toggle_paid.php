<?php

  include("../layout/header.php");
  
  if($_SESSION['Is_Admin'] AND !empty($_POST))
  {    
    include("mysql/mysql_connect.php");
    
    $compId = $_SESSION['Comp_ID'];
    $orderId = $_POST['ID'];
    
    /* Set Paid to opposite state */
    $sql = "UPDATE #PREFIX_$compId SET Paid = NOT Paid WHERE ID = '$orderId';";
    
    if($conn->query($sql))
    {
      $status = true;
      $displayText = "Statut de paiement mis à jour avec succès !";
    }
    else{
      $status = true;
      $displayText = "&Eacute;chec de la mise à jour du statut de paiement...";
      $error = mysqli_error($conn);
    }
    $conn->close();
  }
  else
  {
    header("Location: $baseUrl");    
    exit();
  }
  
?>
      <form action="<?php echo $baseUrl; ?>/admin/#<?php echo $orderId; ?>" method="POST" id="PaidForm">  
        <input type="hidden" value="<?php echo $compId; ?>" name="Comp_ID" />
        <input type="hidden" value="<?php echo $status; ?>" name="Status" />
        <input type="hidden" value="<?php echo $displayText; ?>" name="Display_Text" />
        <input type="hidden" value="<?php echo $error; ?>" name="Error" />
      </form>
<?php

  include("layout/footer.php");
  
?>
<script>
  $('#PaidForm').submit();
</script>
