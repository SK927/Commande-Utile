<?php

  include("../layout/header.php");

  if($_SESSION['Is_Admin'] AND !empty($_POST))
  {      
    $_SESSION['Comp_ID'] = $_POST['Comp_ID'];
    $compId = $_SESSION['Comp_ID'];
    
    include("includes/get_competition_data.php");
    
    $pageTitle = "Administration ".$competitionData['Name'];
    include("layout/title_bar.php");   
        
    include("mysql/mysql_connect.php");
?>  
      <div class="row content rounded-bottom rounded-lg mb-4">
        <div class="col-12 pinned block-header px-3 text-center">
          <h4 class="py-3">OUTILS</h4>
        </div>
        <div class="col-12 block-data mb-4 p-3">
<?php

      include("layout/status_bar.php");
      
?>        
          <div class="row p-3">          
            <form class="col-md-4" action="handle_items.php" method="POST">
              <button class="col-12 btn btn-classic mb-1" name="Handle_Items">Gérer les produits</button>
            </form>
            <form class="col-md-4" action="extract_csv.php" method="POST">
              <button class="col-12 btn btn-classic mb-1" name="Extract_Data">Extraire CSV</button>
            </form>
            <form class="col-md-4" action="update_wcif.php" method="POST">
              <button class="col-12 btn btn-classic mb-1" name="Update_WCIF">MAJ WCIF</button>
            </form>    
          </div>
          <div class="row px-3">
            <div class="col-md-6 pb-3">
              <form action="update_info.php" method="POST">
                <textarea class="form-control rounded mb-1" name="Info" placeholder="Mettre ici les informations sur les commandes (ex : paiement, comment les récupérer...)" ><?php echo htmlspecialchars($competitionData['Info']); ?></textarea>
                <button class="col-12 btn btn-classic" name="Update_Info">MAJ Informations</button>
              </form>
            </div>
            <div class="col-md-6">
              <form action="update_email.php" method="POST">
                <input type="text" class="form-control rounded mb-1 text-center" name="Email" value="<?php echo $competitionData['Contact_Email']; ?>" placeholder="adresse1@bvre.fr; adresse2@bvre.fr"/>
                <button class="col-12 btn btn-classic mb-3" name="Update_Email">MAJ Email</button>
              </form>
              <form action="update_close_date.php" method="POST">
                <input type="date" class="form-control rounded mb-1 text-center" name="Close_Date" value="<?php echo $competitionData['Close_Date']; ?>" />
                <button class="col-12 btn btn-classic mb-3 mb-md-0" name="Update_Date">MAJ Date</button>
              </form>
            </div>
          </div>
        </div>
      </div>
 <?php
    
    include("admin/display_orders_info.php");
    
    $conn->close();
    
?>
      <script>          
        function clicked(e){if(!confirm('Confirmer la suppression?')) e.preventDefault();}
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