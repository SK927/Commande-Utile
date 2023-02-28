<?php

  include("../layout/header.php");

  if($_SESSION['Is_SuperAdmin'])
  {    
    include("mysql/mysql_connect.php"); 
  
    $pageTitle = "Gestion des compétitions";
    include("layout/title_bar.php");    
?>
      <form action="<?php echo $baseUrl; ?>/manage/send.php" method="POST">    
        <div class="row content rounded-bottom rounded-lg mb-4">
          <div class="col-12 block-header px-3 text-center">       
            <h4 class="py-3">OUTILS</h4>
          </div>
          <div class="col-12 block-data rounded-bottom rounded-lg mb-4 py-3 px-4">
<?php

      include("layout/status_bar.php");
      
?>
            <div class="row">
              <div class="col-md-6 mx-auto">
                <div class="col-12"><label>ID compétition</label></div>
                <div class="col-12 mb-4"><input type="text" class="form-control mb-1 text-center" name="Comp_ID" /></div>
                <div class="col-12"><label>Emails de contact</label></div>
                <div class="col-12 mb-4"><input type="text" class="form-control mb-1 text-center" name="Contact" /></div>
              </div>
            </div>
          </div>  
        </div>  
        <div class="row submit-buttons">
          <button class="btn btn-success mx-2" name="Create">Créer</button> 
          <button class="btn btn-light mx-2" name="Regenerate">Régénérer les identifiants</button>
          <button class="btn btn-danger mx-2" name="Destroy" onclick="clicked(event)">Supprimer</button>
        </div>
      </form>
      <script>          
        function clicked(e){if(!confirm('Confirmer la suppression?')) e.preventDefault();}
      </script>
<?php   
       
    $conn->close();
  }
  else
  {
   header("Location: $baseUrl");    
    exit();  
  }  

  include("layout/footer.php"); 
  
?>