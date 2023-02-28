<?php
  
  include("../layout/header.php");

  if($_SESSION['Is_Admin'] AND !empty($_POST))
  {    
    include("mysql/mysql_connect.php");
    include("includes/wcif_functions.php");
        
    [$status, $error] = update_from_public_wcif($_SESSION['Comp_ID'], $conn);
    
    if($status) $displayText = "WCIF mis à jour avec succès !"; 
    else $displayText = "&Eacute;chec de la mise à jour du WCIF...";
    
    $conn->close();
  }
  else
  {
    header("Location: $baseUrl");    
    exit();  
  }      
  
?>
      <form action="<?php echo $baseUrl; ?>/admin/" method="POST" id="WCIFForm">  
        <input type="hidden" value="<?php echo $_SESSION['Comp_ID']; ?>" name="Comp_ID" />
        <input type="hidden" value="<?php echo $status; ?>" name="Status" />
        <input type="hidden" value="<?php echo $displayText; ?>" name="Display_Text" />
        <input type="hidden" value="<?php echo $error; ?>" name="Error" />
      </form>
<?php

  include("layout/footer.php");
  
?>
<script>
  $('#WCIFForm').submit();
</script>
