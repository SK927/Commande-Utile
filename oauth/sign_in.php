<!DOCTYPE html>
<?php
  
  include("../layout/header.php");
  include("layout/footer.php");

  require("oauth/wca-oauth.php");
  require("oauth/oauth_credentials.php");

  if(isset($_GET['code']))
  {
    $user = null;
    
    /* Set WCA auth information */
    $wca = new WcaOauth(array(
      'applicationId' => APP_ID,
      'applicationSecret' => APP_SECRET, 
      'redirectUri' => 'https://'.$_SERVER['SERVER_NAME'].'/oauth/sign_in.php', 
    ));
    
    try
    {
      $wca->fetchAccessToken($_GET['code']); /* Get auth token */
      $user = $wca->getUser(); /* Get current user information */

      /* Set session information */
      $_SESSION['Logged_In'] = true;
      $_SESSION['User_ID'] = $user->id;
      $_SESSION['Name'] = $user->name;
      $_SESSION['Email'] = $user->email;
      $_SESSION['ID_WCA'] = $user->wca_id;
      $_SESSION['Avatar'] =  $user->avatar->thumb_url;  
                
    } 
    catch (Exception $e)
    {
      echo $e->message;
    }
    
    /* Redirect to homepage */
    header('Location: https://'.$_SERVER['SERVER_NAME']);
    exit();
  }
  
?>

<html>
  <body>
    <img src=<?php echo $_SESSION['Avatar']; ?> />
  </body>
</html>