<?php 

    include('layout/header.php');
    
    if(!$_SESSION['Logged_In'])
    { 

?>
      <div class="row content rounded rounded-lg my-3 p-5">
        <form class="col-md-8 mx-auto" action="<?php echo $baseUrl; ?>/oauth/" method="POST">
          <div class="col-12">
            <button class="btn btn-classic rounded">Se connecter avec la WCA</button>
          </div>
          <div class="col-12 mt-3">
            <input id="admin-checkbox" type="checkbox" class="btn-check" name="Is_Admin" />
            <label for="admin-checkbox" class="font-weight-normal">J'organise une compétition et souhaite administrer les commandes</label>
          </div>
          <div class="col-12 mt-3">
            <sub>
              En cliquant sur le bouton ci-dessus, vous acceptez l'utilisation des cookies nécessaires au fonctionnement
              du site ainsi que le traitement de vos données personnelles dans le cadre de votre commande.
              Ce site nécessite que JavaScript soit activé sur votre navigateur.<br/>
              <a href="CU_UserManual.pdf" target="_blank">Télécharger le manuel utilisateur</a>
            </sub>
          </div>
        </form> 
      </div>
<?php 
 
    }
    else
    {
      header("Location: $baseUrl/select_competition.php");
      exit();
    }
    
    include('layout/footer.php');
    
?>
    


