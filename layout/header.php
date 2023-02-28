<?php
  
  set_include_path("#BASEFTP");
  
  require("sessions/mysql_session_handler.php");

  $baseUrl = "https://".$_SERVER['SERVER_NAME'];

  /* Require https */
  if ($_SERVER['HTTPS'] != "on") 
  {
    header("Location: $baseUrl".$_SERVER['REQUEST_URI']);
    exit;
  }
  
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr">
  <head>
    <title>Commande Utile</title>
    <meta name="author" content="ML" />
    <meta name="Description" content="Site de commande pour les compétitions WCA en France" />
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <link rel="icon" type="image/png" href="<?php echo $baseUrl; ?>/img/favicon.png" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <!-- Bootstrap Core CSS -->
    <link href="<?php echo $baseUrl; ?>/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="<?php echo $baseUrl; ?>/css/custom.css" rel="stylesheet">
    
    <!-- Add jQuery support -->
    <script src="<?php echo $baseUrl; ?>/js/jquery-3.6.3.min.js"></script>
  </head>

  <body>
    <div class="container text-center">
