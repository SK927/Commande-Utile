<?php

  include("../layout/header.php");

  if($_SESSION['Is_Admin'] AND !empty($_POST))
  {    
    include("mysql/mysql_connect.php");
    
    $compId = $_SESSION['Comp_ID'];
    $email = mysqli_real_escape_string($conn, $_POST['Email']);
    
    /* Set new email addresses for current competition */ 
    $sql = "UPDATE #PREFIX_Main SET Contact_Email = '$email' WHERE ID_Comp = '$compId';";
    
    if($conn->query($sql))
    {
      $status = true;
      $displayText = "E-mails de contact mis à jour avec succès !";
    }
    else{
      $status = false;
      $displayText = "&Eacute;chec de la mise à jour des e-mails de contact des commandes...";
      $error = mysqli_error($conn);
    }
    $conn->close();
  }

?>
      <form action="<?php echo $baseUrl; ?>/admin/" method="POST" id="DateForm">  
        <input type="hidden" value="<?php echo $compId; ?>" name="Comp_ID" />
        <input type="hidden" value="<?php echo $status; ?>" name="Status" />
        <input type="hidden" value="<?php echo $displayText; ?>" name="Display_Text" />
        <input type="hidden" value="<?php echo $error; ?>" name="Error" />
      </form>
<?php

  include("layout/footer.php");

?>
<script>
  $('#DateForm').submit();
</script>
