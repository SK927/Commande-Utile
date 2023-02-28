<?php

  include("../layout/header.php");

  if($_SESSION['Logged_In'] AND !empty($_POST))
  {  
    include("order/functions.php");
    include("includes/hash_functions.php");
    include("includes/get_competition_data.php");
    
    $pageTitle = "Commande ".$competitionData['Name'];
    include("layout/title_bar.php"); 
      
    include("mysql/mysql_connect.php");

    $isEdit = !empty($_POST['ID']);
    if(!$isEdit) $_POST['ID'] = hashUserID($_SESSION['User_ID'], $_SESSION['Comp_ID']);
    $sql = GetConfirmationSQL($competitionJson, $_POST, $conn);

?>
      <div class="row rounded rounded-lg content my-3 p-5">     
        <div class="col-12">          
<?php

    if($conn->query($sql))
    {
      if(isset($_POST['Cancel']))
      {

?>
          <p>La commande n° <b><?php echo $_POST['ID']; ?></b> au nom de <b><?php echo $_SESSION['Name']; ?></b> a bien été supprimée.</p>
          <p>Un e-mail de confirmation a &eacute;t&eacute; envoy&eacute; à l'adresse <b><?php echo $_SESSION['Email']; ?></b>.</p>  
          <p>Si vous ne recevez pas cet e-mail dans les prochaines heures, merci de nous contacter rapidement.</p>  
<?php

        sendCancellation($competitionData, $_POST);
      }
      else
      {
  
?>
          <p>La commande n° <b><?php echo $_POST['ID']; ?></b><?php if(!$isEdit) echo " a bien été enregistrée"; ?> au nom de <b><?php echo $_SESSION['Name']; ?></b><?php if($isEdit) echo " a bien été modifiée"; ?>.</p>
          <p>Un e-mail de confirmation a &eacute;t&eacute; envoy&eacute; à l'adresse <b><?php echo $_SESSION['Email']; ?></b>.</p>  
          <p>Si vous ne recevez pas cet e-mail dans les prochaines heures, merci de nous contacter rapidement.</p>  
<?php

        sendConfirmation($competitionData, $_POST, $isEdit);
      }
    }
    else
    {
      echo("err: " . mysqli_error($conn));
    }
   $conn->close();
  
?>
          <form action="<?php echo $baseUrl; ?>" method="POST">
            <button class="btn btn-danger mt-4">Retour à l'accueil</button>
          </form>
        </div>
      </div>   
<?php
    
  }
  else
  {
    header("Location: $baseUrl");    
    exit();
  }    
  
  include("layout/footer.php");
  
?>

      
