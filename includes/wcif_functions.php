<?php
  
  function update_from_public_wcif($compId, $conn)
  {
    
    /* Load public WCIF of the competition */
    $wcifUrl = "https://www.worldcubeassociation.org/api/v0/competitions/$compId/wcif/public";
    
    $status = true;
    $error = "";

    /* Setup and exec cURL */
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $wcifUrl);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($curl);

    if($e = curl_error($curl))
    {
      $status = false;
      $error = $e;
      curl_close($curl);
    } 
    else
    {
      $json = json_decode($response, false, 512, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    
      curl_close($curl);

      if(empty($json->error))
      {
        $name = addslashes($json->name);
        $competitors = "";
        $admins = "#ADMINS"; /* Add default admins here if needed, leave brackets */

        /* If person is orga or delegate, add to admins
           Add to competitors in any case */
        foreach($json->persons as $person)
        {
          $isOrga = false;
          
          foreach($person->roles as $role)
          {
            if($role == "organizer" OR $role == "delegate") $isOrga = true;
          }
          
          if($isOrga) $admins .= "[".$person->wcaUserId."]";
          $competitors .= "[".$person->wcaUserId."]";
        }

        /* Insert WCIF data to newly created table */
        $sql = "UPDATE #PREFIX_Main SET Name='$name', Admins='$admins', Competitors='$competitors' WHERE ID_Comp='$compId';";
        
        if(!$conn->query($sql)) $error = mysqli_error($conn); 
      }
      else{
        $status = false;
        $error = $json->error;
      }
    }
    return [$status, $error];     
  }

?>