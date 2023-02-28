<?php

  include("../layout/header.php");

  if($_SESSION['Is_SuperAdmin'] AND !empty($_POST))    
  {
    include("mysql/mysql_connect.php");
    include("manage/functions.php");
    
    $compId = $_POST['Comp_ID'];
        
    if(isset($_POST['Destroy'])) /* If super admin wants to delete a competition */
    {
      $results = $conn->query("SELECT Contact_Email FROM #PREFIX_Main WHERE ID_Comp = '$compId';"); /* Get selected competition contact email */  
      $contact = ($results->fetch_assoc())['Contact_Email']; /* Store in variable */
      
      [$status, $error] = drop_table($compId, $conn); /* Drop competition specific table */
        
      if($status)
      {
        [$status, $error] = delete_competition($compId, $conn); /* Delete competition entry from main table */
        
        if($status)
        {
          $status = send_deletion($compId, $contact); /* Send deletion confirmation to contact email */
        }
      }
      
      if($status) $displayText = "Compétition supprimée à jour avec succès !"; 
      else $displayText = "&Eacute;chec de la suppression de la compétition...";
    }
    
    if(isset($_POST['Create'])) /* If super admin wants to create a new a competition */
    {
      if(!empty($compId))
      {        
        $compContact = $_POST['Contact'];
        
        [$status, $error] = create_competition_table($compId, $conn); /* Create competition specific table */
        
        if($status)
        {
          [$status, $error] = add_primary($compId, $conn); /* Add primary key to newly created table */
          
          if($status)
          {
            [$status, $error] = insert_competition_db($compId, $compContact, $conn); /* Create competition entry in main table */
            
            if($status)
            {              
              [$status, $error] = generate_password($compId, $compContact, false, $conn); /* Generate credentials for new competition and send to admins */
            }
          }
        }
      }
      else{
        $status = false;
        $error = "ID de la compétition non défini";
      }
      
      if($status) $displayText = "Compétition créée à jour avec succès !"; 
      else $displayText = "&Eacute;chec de la création de la compétition...";
    }   
    
    if(isset($_POST['Regenerate'])) /* If super admin wants to regenerate a competition credentials  */
    {
      $results = $conn->query("SELECT Contact_Email FROM #PREFIX_Main WHERE ID_Comp = '$compId';");    
      $contact = ($results->fetch_assoc())['Contact_Email'];
      
      [$status, $error] = generate_password($compId, $contact, true, $conn); /* Generate credentials for selected competition and send to admins */
      
      if($status) $displayText = "Identifiants mis à jour avec succès !"; 
      else $displayText = "&Eacute;chec de la mise à jour des identifiants...";
    }
    $conn->close();
  }
  else
  {
    header("Location: $baseUrl");    
    exit();  
  }
  
?>
      <form action="<?php echo $baseUrl; ?>/manage/" method="POST" id="ManageForm">  
        <input type="hidden" value="<?php echo $status; ?>" name="Status" />
        <input type="hidden" value="<?php echo $displayText; ?>" name="Display_Text" />
        <input type="hidden" value="<?php echo $error; ?>" name="Error" />
      </form>
<?php

  include('layout/footer.php');
  
?>
<script>
  $('#ManageForm').submit();
</script>