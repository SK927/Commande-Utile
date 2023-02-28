<?php

  include("../layout/header.php");

  if($_SESSION['Request_Admin'])
  {    
    $pageTitle = "Connexion à un compte administrateur";
    include("layout/title_bar.php");    
    
    if(isset($_POST['Login']) AND isset($_POST['Password']))
    { 
      include("mysql/mysql_connect.php"); 
      include("includes/encrypt_functions.php"); 
  
      $login = $_POST['Login'];
      $password = $_POST['Password'];
      
      $results = $conn->query("SELECT Password FROM #PREFIX_AdminCredentials WHERE Login = '$login';");
      $storedPassword = ($results->fetch_assoc())['Password'];
      
      $conn->close();

      if($password === decrypt_data($storedPassword))
      { 
        $_SESSION['Is_Admin'] = true;
        unset($_SESSION['Request_Admin']);
        
        if($login === "SuperAdmin") $_SESSION['Is_SuperAdmin'] = true;
        
        header("Location: $baseUrl/oauth/");    
        exit();
      }
      else
      {
        $error = true;
      }
    }   
        
?>
      <form action="" method="POST">  
        <div class="row content rounded-bottom rounded-lg my-3 p-5 text-center">
<?php

      if($error)
      {
      
?>
          <div class="col-12 alert alert-danger mb-4 text-center"><strong>La combinaison identifiant/mot de passe est incorrecte !</strong></div>
<?php

      }

?>
          <div class="col-md-6 mx-auto">          
            <div class="col-12"><label>Identifiant</label></div>
            <div class="col-12 mb-4"><input type="text" class="form-control text-center" name="Login" /></div>
            <div class="col-12"><label>Mot de passe</label></div>
            <div class="col-12 mb-4"><input type="password" class="form-control text-center" name="Password" /></div>
          </div>
        </div> 
        <div class="row submit-buttons">
          <button class="btn btn-success mx-2" name="Confirm">Confirmer</button>
        </div>
      </form> 
<?php   
    
  }
  else
  {
    header("Location: $baseUrl");    
    exit();  
  }  

  include("layout/footer.php"); 
  
?>