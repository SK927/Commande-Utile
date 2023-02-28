<?php

  include("../layout/header.php");

  if($_SESSION['Is_Admin'] AND !empty($_POST))
  {    
    include("order/functions.php");
    include("includes/get_competition_data.php");
    include("mysql/mysql_connect.php");

    $compId = $_SESSION['Comp_ID'];
    $orderId = $_POST['ID'];
        
    /* Delete selected order */
    $sql = "DELETE FROM #PREFIX_$compId WHERE ID = '$orderId';";
    
    if($conn->query($sql))
    {
      $status = true;
      $displayText = "Suppression de la commande effectuée avec succès !";
    }
    else{
      $status = false;
      $displayText = "&Eacute;chec de la suppression de la commande...";
      $error = mysqli_error($conn);
    }
    
    if(!sendCancellation($competitionData, $_POST)) 
    {
      $status = false;
      $displayText = "L'e-mail de confirmation de la suppression n'a pas pu être envoyé..."; /* */
    }    
    $conn->close();
  }

?>
      <form action="<?php echo $baseUrl; ?>/admin/" method="POST" id="DeleteForm">  
        <input type="hidden" value="<?php echo $compId; ?>" name="Comp_ID" />
        <input type="hidden" value="<?php echo $status; ?>" name="Status" />
        <input type="hidden" value="<?php echo $displayText; ?>" name="Display_Text" />
        <input type="hidden" value="<?php echo $error; ?>" name="Error" />
      </form>
<?php

  include("layout/footer.php");
  
?>
<script>
  $('#DeleteForm').submit();
</script>
