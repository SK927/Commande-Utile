<?php
  
  include("../layout/header.php");
   
  if($_SESSION['Is_Admin'] AND !empty($_POST))
  {     
    include("includes/get_competition_data.php");

    $pageTitle = "Gestion produits ".$competitionData['Name'];
    include("layout/title_bar.php");
    
    include("admin/handle_items_template.php");
  
?>    
      <script src="<?php echo $baseUrl; ?>/js/handle_items.js"></script>  

      <div class="row content rounded rounded-lg mt-4 p-4 text-center">
<?php 

    include("layout/status_bar.php");

?>
        <div class="col-12 mb-4 p-3 align-items-center">
          <form action="update_item_list.php" method="POST" enctype="multipart/form-data">
            <input id="file-input" type="file" name="CSVupload" required />
            <button id="load-file" class="btn btn-classic" name="Upload">Charger le fichier</button>
          </form>
          <sub>
            <a href="<?php echo $baseUrl; ?>/Example_Items.csv">(Télécharger le fichier d'exemple)</a>
          </sub>
        </div>
        <div class="col-12 add-block rounded alert alert-success mb-4 p-2">AJOUTER UN BLOC</div>

        <form id="itemForm" class="col-12" action="update_item_list.php" method="POST" onsubmit="submitted=1;">
          <div id="item-list">
            
          </div>
          <div class="row submit-buttons">
            <button class="btn btn-success" name="Update">Mettre à jour la liste</button>
          </div>
        </form>
      </div>
      <script>          
<?php
  
    foreach($competitionJson as $blockKey=>$blockValue)
    {
    
?>
        createBlock(<?php echo "'".htmlspecialchars(addslashes($blockKey))."', '".htmlspecialchars(addslashes($blockKey))."'"; ?>);
    
<?php

      foreach($blockValue as $itemKey=>$itemValue)
      {

?>
        createItem(<?php echo "'block".htmlspecialchars(addslashes($blockKey))."', '".$itemKey."', '".htmlspecialchars(addslashes($itemValue['Item-Name']))."', '".$itemValue['Item-Price']."', '".$itemValue['Item-Image']."', '".htmlspecialchars(addslashes($itemValue['Item-Descr']))."'"; ?>);  
<?php    

      }
    }

?>

        var submitted = 0;
        var form = $('#itemForm').serialize();
                
        window.addEventListener('beforeunload', (event) => {
          if(form != $('#itemForm').serialize() && !submitted) event.preventDefault();
        });
        
      </script>
<?php

  }
  else
  {
    header("Location: $baseUrl");    
    exit();
  }
  include("layout/footer.php");
  
?>
  