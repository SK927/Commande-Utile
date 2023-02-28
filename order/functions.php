<?php

  function GetConfirmationSQL($competitionArray, $order, $mysqli)
  {
    if(isset($order['Cancel']))
    {
      $sql = "DELETE FROM #PREFIX_".$_SESSION['Comp_ID']." WHERE ID = '".$order['ID']."';";
    }
    else
    {      
      $blockArray = array();
      $amount = 0;
      
      foreach($competitionArray as $blockKey=>$blockValue)
      {
        $itemArray = array();
        $quantity = 0;
        
        foreach($blockValue as $itemKey=>$itemValue)
        {
          if(!is_numeric($order[$itemKey])) $order[$itemKey] = 0; /* If item quantity is not defined, set to 0 */
          $itemArray[$itemValue['Item-Name']] = $order[$itemKey]; /* Store item quantity in item array */
          $amount += $itemValue['Item-Price'] * $order[$itemKey]; /* Add item amount to total order amount */
          $quantity += $order[$itemKey]; /* Add item quantity to total block quantity */
        }    
        $itemArray['Given'] = (int)($quantity == 0); /* If items are selected for the current block, set given status to 0 */
        $blockArray[$blockKey] = $itemArray; /* Store item in block array */
      }
      
      $json = mysqli_real_escape_string($mysqli, json_encode($blockArray));
      $name = mysqli_real_escape_string($mysqli, $_SESSION['Name']);
      $comment = mysqli_real_escape_string($mysqli, $order['Comment']);
      
      $sql = "REPLACE INTO #PREFIX_".$_SESSION['Comp_ID']." VALUE ('".$order['ID']."', '$name', '".$_SESSION['ID_WCA']."', '".$_SESSION['Email']."', '$json', $amount, '$comment', 0);";
    }
    return $sql;
  }
  
  function sendConfirmation($competitionArray, $order, $edit)
  {      
    $competitionJson = json_decode($competitionArray['Data_Json'], true);
  
    $to = $_SESSION['Email'];
    if($edit) $subject = $competitionArray['Name'].' - Modification commande n° '.$order['ID'];
    else $subject = $competitionArray['Name'].' - Confirmation commande n° '.$order['ID'];
    $from = $competitionArray['Contact_Email'];

    /* To send HTML mail, the Content-type header must be set */
    $headers  = 'MIME-Version: 1.0' . "\r\n";
    $headers .= 'Content-type: text/html; charset=utf-8'."\r\n";
     
    /* Create email headers */
    $headers .= 'From: Organisation'."\r\n".'Bcc: [email]'.$from.'[/email]'."\r\n";
    $headers .= 'Reply-To: '.$from."\r\n".'X-Mailer: PHP/'.phpversion();
     
    /* Compose a simple HTML email message */
    $message = '<html><body>';
    $message .= '<p>Bonjour '.$_SESSION['Name'].',</p>';
    if($edit) $message .= '<h3>VOTRE COMMANDE A BIEN &Eacute;T&Eacute; MODIFI&Eacute;E !</h3>';
    else $message .= '<h3>MERCI POUR VOTRE COMMANDE !</h3>';
    $message .= '<p>Vous trouverez ci-apr&egrave;s le r&eacute;capitulatif de votre commande';
    $message .= ' n° <b>'.$order['ID'].'</b>.</p>';
    
    $total = 0;
    
    foreach($competitionJson as $blockKey=>$blockValue)
    {
      $message .= '<p><b>'.$blockKey.'</b> : ';
      
      foreach($blockValue as $itemKey=>$itemValue)
      { 
        if($order[$itemKey] != 0) 
        {
          $total += ($itemValue['Item-Price'] * $order[$itemKey]);
          $message .= $order[$itemKey].' x '.$itemValue['Item-Name'].' ; ';
        }
      }    
      $message .= '</p>';
    }
            
    if(!empty($order['Comment'])) $message .= '<p><b>Commentaire : </b>'.$order['Comment'].'</p>';
    
    $message .= '<p><b>Total : '.$total.' &euro;</b></p>';
    $message .= '<p>Merci de vous r&eacute;f&eacute;rer aux e-mails des organisateur·rice·s';
    $message .= '  pour le paiement.</p>';
    $message .= '<p>Pour modifier votre commande avant le '.$competitionArray['Close_Date'].',';
    $message .= ' <a href="https://'.$_SERVER['SERVER_NAME'];
    $message .= '" target=\'_blank\'">cliquez ici</a></p>';
    $message .= '<p style="color:red">Note de l\'&eacute;quipe organisatrice : '.$competitionArray['Info'].'</p>';
    $message .= '<p>Bonne journ&eacute;e et &agrave; bient&ocirc;t.</p>';
    $message .= '<p>----</p>';
    $message .= '<p>L\'&eacute;quipe organisatrice du '.$competitionArray['Name'].'</p>';
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
    
  function sendCancellation($array, $order)
  {  
    $to = $_SESSION['Email'];
    $subject = $array['Name'].' - Annulation commande n° '.$order['ID'];
    $from = $array['Contact_Email'];

    /* To send HTML mail, the Content-type header must be set */
    $headers  = 'MIME-Version: 1.0' . "\r\n";
    $headers .= 'Content-type: text/html; charset=utf-8'."\r\n";
     
    /* Create email headers */
    $headers .= 'From: Organisation'."\r\n".'Bcc: [email]'.$from.'[/email]'."\r\n";
    $headers .= 'Reply-To: '.$from."\r\n".'X-Mailer: PHP/'.phpversion();
     
    /* Compose a simple HTML email message */
    $message = '<html><body>';
    $message .= '<p>Bonjour '.$_SESSION['Name'].',</p>';
    $message .= '<p>Votre commande n° <b>'.$order['ID'].'</b> a bien &eacute;t&eacute;';
    $message .= ' annul&eacute;e.</p>';
    $message .= '<p>Bonne journ&eacute;e et &agrave; bient&ocirc;t.</p>';
    $message .= '<p>----</p>';
    $message .= '<p>L\'&eacute;quipe organisatrice du '.$array['Name'].'</p>';
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
  
?>