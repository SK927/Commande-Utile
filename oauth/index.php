<?php

  include("../layout/header.php");
  include("layout/footer.php");

  require("oauth/oauth_credentials.php");

  $applicationId = APP_ID; 
  $redirectUri = 'https://'.$_SERVER['SERVER_NAME'].'/oauth/sign_in.php';
  $targetUrl = "https://www.worldcubeassociation.org/oauth/authorize?response_type=code&client_id=$applicationId&scope=public%20email&redirect_uri=$redirectUri";
  
  if($_POST['Is_Admin'] == "on")
  {
    $_SESSION['Request_Admin'] = true;
    
    header("Location: $baseUrl/oauth/request_credentials.php");    
    exit();
  }
  else
  {
    header("Location: $targetUrl");    
    exit();
  }
    
?>