<?php

  function generate_password($login, $contact, $regenerate, $conn)
  {
    if(!empty($login))
    {
      include("includes/encrypt_functions.php");
      
      $password = md5(rand()); /* Generate password */
      $encrypt = encrypt_data($password); /* Encrypt password */
      
      $sql = "REPLACE INTO #PREFIX_AdminCredentials (Login, Password) VALUE ('$login', '$encrypt');";
         
      if($conn->query($sql))
      {        
        if($regenerate) $status = send_updated_credentials($login, $password, $contact); /* Send update credentials to contact email */
        else $status = send_credentials($login, $password, $contact); /* Send newly created credentials to contact email */
        if(!$status) $error = "Envoi des identifiants à l'organisateur impossible !";
      }  
      else { $status = false; $error = mysqli_error($conn); }
    }
    else
    {
      $status = false;
      $error = "ID de la compétition non défini";
    }
    
    return [$status, $error];
  }
  
  function send_deletion($login, $contact)
  {
    $to = $contact;
    $subject = $login.' - Suppression la compétition';
    $from = 'maxlefe@bvre.fr';

    /* To send HTML mail, the Content-type header must be set */
    $headers  = 'MIME-Version: 1.0' . "\r\n";
    $headers .= 'Content-type: text/html; charset=utf-8'."\r\n";
     
    /* Create email headers */
    $headers .= 'From: Organisation'."\r\n".'Bcc: [email]'.$from.'[/email]'."\r\n";
    $headers .= 'Reply-To: '.$from."\r\n".'X-Mailer: PHP/'.phpversion();
     
    /* Compose a simple HTML email message */
    $message = '<html><body>';
    $message .= '<p>Bonjour,</p>';
    $message .= '<p>La comp&eacute;tition ID <b>'.$login.'</b> a bien &eacute;t&eacute;';
    $message .= ' supprim&eacute;e sur le site <a href="https://cu.bvre.fr/">Commande Utile</a>.</p>';
    $message .= '<p>Bonne journ&eacute;e et &agrave; bient&ocirc;t.</p>';
    $message .= '<p>----</p>';
    $message .= '<p>L\'&eacute;quipe d\'administration de Commande Utile</p>';
    $message .= '</body></html>';
     
    /* Sending email */
    if(mail($to, $subject, $message, $headers))
    {
      return true;
    } 
    else
    {
      return false;
    }
  }
  
  function send_credentials($login, $password, $contact)
  {
    $to = $contact;
    $subject = $login.' - Création de la compétition';
    $from = 'maxlefe@bvre.fr';

    /* To send HTML mail, the Content-type header must be set */
    $headers  = 'MIME-Version: 1.0' . "\r\n";
    $headers .= 'Content-type: text/html; charset=utf-8'."\r\n";
     
    /* Create email headers */
    $headers .= 'From: Organisation'."\r\n".'Bcc: [email]'.$from.'[/email]'."\r\n";
    $headers .= 'Reply-To: '.$from."\r\n".'X-Mailer: PHP/'.phpversion();
     
    /* Compose a simple HTML email message */
    $message = '<html><body>';
    $message .= '<p>Bonjour,</p>';
    $message .= '<p>La comp&eacute;tition ID <b>'.$login.'</b> a bien &eacute;t&eacute;';
    $message .= ' cr&eacute;&eacute;e sur le site <a href="https://cu.bvre.fr/">Commande Utile</a>.</p>';
    $message .= '<p>Votre identifiants de connexion admin se trouvent ci-après :</p>';
    $message .= '<ul><li><b>Login :</b> '.$login.'</li>';
    $message .= '<li><b>Mot de passe :</b> '.$password.'</li></ul>';
    $message .= '<p>Bonne journ&eacute;e et &agrave; bient&ocirc;t.</p>';
    $message .= '<p>----</p>';
    $message .= '<p>L\'&eacute;quipe d\'administration de Commande Utile</p>';
    $message .= '</body></html>';
     
    /* Sending email */
    if(mail($to, $subject, $message, $headers))
    {
      return true;
    } 
    else
    {
      return false;
    }
  }
  
  function send_updated_credentials($login, $password, $contact)
  {
    $to = $contact;
    $subject = $login.' - Mise à jour des identifiants de connexion';
    $from = 'maxlefe@bvre.fr';

    /* To send HTML mail, the Content-type header must be set */
    $headers  = 'MIME-Version: 1.0' . "\r\n";
    $headers .= 'Content-type: text/html; charset=utf-8'."\r\n";
     
    /* Create email headers */
    $headers .= 'From: Organisation'."\r\n".'Bcc: [email]'.$from.'[/email]'."\r\n";
    $headers .= 'Reply-To: '.$from."\r\n".'X-Mailer: PHP/'.phpversion();
     
    /* Compose a simple HTML email message */
    $message = '<html><body>';
    $message .= '<p>Bonjour,</p>';
    $message .= '<p>Les nouveaux identifiants pour la comp&eacute;tition ID <b>'.$login.'</b>';
    $message .= ' se trouvent ci-après :</p>';
    $message .= '<ul><li><b>Login :</b> '.$login.'</li>';
    $message .= '<li><b>Mot de passe :</b> '.$password.'</li></ul>';
    $message .= '<p>Bonne journ&eacute;e et &agrave; bient&ocirc;t.</p>';
    $message .= '<p>----</p>';
    $message .= '<p>L\'&eacute;quipe d\'administration de Commande Utile</p>';
    $message .= '</body></html>';
     
    /* Sending email */
    if(mail($to, $subject, $message, $headers))
    {
      return true;
    } 
    else
    {
      return false;
    }
  }
  
  function drop_table($compId, $conn)
  {
    $sql = "DROP TABLE #PREFIX_$compId;";  
      
    if($conn->query($sql)) $status = true;
    else { $status = false; $error = mysqli_error($conn); }

    return [$status, $error];
  }
  
  function delete_competition($compId, $conn)
  {
    $sql = "DELETE FROM #PREFIX_Main WHERE ID_Comp = '$compId';"; 

    if($conn->query($sql)) $status = true;
    else { $status = false; $error = mysqli_error($conn); }

    return [$status, $error];
  }
  
  function create_competition_table($compId, $conn)
  {
    $sql = "CREATE TABLE `#PREFIX_$compId` (
              `ID` char(50) COLLATE utf8_unicode_ci NOT NULL,
              `Name` text COLLATE utf8_unicode_ci NOT NULL,
              `ID_WCA` mediumtext COLLATE utf8_unicode_ci NOT NULL,
              `Email` mediumtext COLLATE utf8_unicode_ci NOT NULL,
              `Order_Data` longtext COLLATE utf8_unicode_ci NOT NULL,
              `Order_Total` float NOT NULL,
              `Comment` longtext COLLATE utf8_unicode_ci NOT NULL,
              `Paid` tinyint(1) NOT NULL
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;";

    if($conn->query($sql)) $status = true;
    else { $status = false; $error = mysqli_error($conn); }
       
    return [$status, $error];
  }
  
  function add_primary($compId, $conn)
  {
    $sql = "ALTER TABLE #PREFIX_$compId ADD PRIMARY KEY (ID), ADD UNIQUE KEY(ID);";
            
    if($conn->query($sql)) $status = true;
    else { $status = false; $error = mysqli_error($conn); }
    
    return [$status, $error];
  }
  
  function insert_competition_db($compId, $compContact, $conn)
  {
    include("includes/wcif_functions.php");
    
    $sql = "REPLACE INTO #PREFIX_Main (ID_Comp, Name, Admins, Contact_Email, Close_Date, Competitors) VALUES ('$compId', '', '', '$compContact', '0000-00-00', '');";
    
    /* Create competition entry in main table */
    if($conn->query($sql)) $status = true;
    else { $status = false; $error = mysqli_error($conn); }
    
    /* Insert WCIF data to newly created entry */
    $error .= update_from_public_wcif($compId, $conn);
    
    return [$status, $error];
  }

?>