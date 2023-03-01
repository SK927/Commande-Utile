<?php

  function replace_string($filename, $toReplace, $replaceBy)
  {
    $content = file_get_contents($filename);
    $content = str_replace($toReplace, $replaceBy, $content);
    return file_put_contents($filename, $content);
  }
  
  $pass = true;
  
  #URL
  $list = array("../.htaccess");
  foreach($list as $path) $pass = $pass AND replace_string($path, "#URL", $_SERVER['SERVER_NAME']);
  
  if($pass)
  {
    echo "URL replacement OK...<br/>";
    
    #BASEFTP
    $baseFTP = str_replace("init/init_project.php","",realpath(__file__));
    $list = array(
                    "../admin/extract_csv.php",
                    "../cron/cron_delete_outdated_sessions.php",
                    "../cron/cron_update_competitions.php",
                    "../layout/header.php",
                    "../mysql/mysql_connect.php",
                    "../sessions/session_quit.php"
            );
    foreach($list as $path) $pass = $pass AND replace_string($path, "#BASEFTP", $baseFTP);
  }
  else
  {
    echo "<b>URL replacement NOK...</b><br/>";
  }
  
  if($pass)
  {
    echo "BASE FTP replacement OK...<br/>";   
    
    #PREFIX_
    $list = array(
                  "../admin/delete_order.php",
                  "../admin/display_orders_info.php",
                  "../admin/extract_csv.php",	
                  "../admin/toggle_given.php",
                  "../admin/toggle_paid.php",
                  "../admin/update_close_date.php",
                  "../admin/update_email.php",
                  "../admin/update_info.php",
                  "../admin/update_item_list.php",
                  "../cron/cron_delete_outdated_sessions.php",
                  "../cron/cron_update_competitions.php",
                  "../includes/get_competition_data.php",
                  "../includes/wcif_functions.php",
                  "../manage/functions.php",
                  "../manage/send.php",
                  "../oauth/request_credentials.php",
                  "../order/functions.php",
                  "../order/retrieve_order_data.php",
                  "../select_competition.php",
                  "../sessions/mysql_session_handler.php"  
            );
    foreach($list as $path) $pass = $pass AND replace_string($path, "#PREFIX", $_POST['Prefix']);
  }
  else
  {
    echo "<b>BASEFTP replacement NOK...</b><br/>";
  }
    
  if($pass)
  {
    echo "PREFIX replacement OK...<br/>";
      
    #APP_ID
    $list = array("../oauth/oauth_credentials.php");
    foreach($list as $path) $pass = $pass AND replace_string($path, "#APP_ID", $_POST['App_Id']);
  }
  else
  {
    echo "<b>PREFIX replacement NOK...</b><br/>";
  }
  
  if($pass)
  {
    echo "APP_ID replacement OK...<br/>";
  
    #APP_SECRET
    foreach($list as $path) $pass = $pass AND replace_string($path, "#APP_SECRET", $_POST['App_Secret']);
  }
  else
  {
    echo "<b>APP_ID replacement NOK...</b><br/>";
  }
  
  if($pass)
  {
    echo "APP_SECRET replacement OK...<br/>";
    
    #HOST
    $list = array("../mysql/mysql_credentials.php");
    foreach($list as $path) $pass = $pass AND replace_string($path, "#HOST", $_POST['Host']);
  }
  else
  {
    echo "<b>APP_SECRET replacement NOK...</b><br/>";
  }
  
  if($pass)
  {
    echo "HOST replacement OK...<br/>";
    
    #USERNAME
    foreach($list as $path) $pass = $pass AND replace_string($path, "#USERNAME", $_POST['Username']);
  }
  else
  {
    echo "<b>HOST replacement NOK...</b><br/>";
  }
  
  if($pass)
  {
    echo "USERNAME replacement OK...<br/>";
    
    #PASSWORD
    foreach($list as $path) $pass = $pass AND replace_string($path, "#PASSWORD", $_POST['Password']);
  }
  else
  {
    echo "<b>USERNAME replacement NOK...</b><br/>";
  }
  
  if($pass)
  {
    echo "PASSWORD replacement OK...<br/>";
    
    #DB
    foreach($list as $path) $pass = $pass AND replace_string($path, "#DB", $_POST['Db']);
  }
  else
  {
    echo "<b>PASSWORD replacement NOK...</b><br/>";
  }
  
  if($pass)
  {
    echo "DB replacement OK...<br/>";
    
    #KEY
    $list = array("../includes/encrypt_functions.php");
    foreach($list as $path) $pass = $pass AND replace_string($path, "#KEY", $_POST['Key']);
  }
  else
  {
    echo "<b>DB replacement NOK...</b><br/>";
  }
  
  if($pass)
  {
    echo "KEY replacement OK...<br/>";
    
    #IV
    foreach($list as $path) $pass = $pass AND replace_string($path, "#IV", $_POST['IV']);
  }
  else
  {
    echo "<b>KEY replacement NOK...</b><br/>";
  }
  
  if($pass) echo "IV replacement OK...<br/>";
  else echo "<b>URL replacement NOK...</b><br/>";

  
  include("../mysql/mysql_connect.php");
  include("../includes/encrypt_functions.php");
  
  if($pass)
  {
    $sql = "CREATE TABLE `".$_POST['Prefix']."_Main` (
              `ID` int(11) NOT NULL,
              `ID_Comp` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
              `Name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
              `Admins` text COLLATE utf8_unicode_ci NOT NULL,
              `Contact_Email` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
              `Close_Date` date NOT NULL,
              `Competitors` text COLLATE utf8_unicode_ci NOT NULL,
              `Data_Json` text COLLATE utf8_unicode_ci NOT NULL,
              `Info` longtext COLLATE utf8_unicode_ci NOT NULL
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;";

    $pass = $pass AND $conn->query($sql);
    if($pass) echo "Create main table OK...<br/>";
    else echo "<b>".$conn->error."</b><br/>";
  }
  
  if($pass)
  {
    $sql = "ALTER TABLE `".$_POST['Prefix']."_Main`
              ADD PRIMARY KEY (`ID_Comp`),
              ADD UNIQUE KEY `ID` (`ID`);";
    
    $pass = $pass AND $conn->query($sql);
    if($pass) echo "Alter main table (key) OK...<br/>";
    else echo "<b>".$conn->error."</b><br/>";
  }
   
  if($pass)
  {   
    $sql = "ALTER TABLE `".$_POST['Prefix']."_Main`
              MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=0;";
      
    $pass = $pass AND $conn->query($sql);
    if($pass) echo "Alter main table (AI) OK...<br/>";
    else echo "<b>".$conn->error."</b><br/>";
  } 
   
  if($pass)
  {
    $sql = "CREATE TABLE `".$_POST['Prefix']."_AdminCredentials` (
              `ID` int(11) NOT NULL,
              `Login` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
              `Password` varchar(100) COLLATE utf8_unicode_ci NOT NULL
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;  ";

    $pass = $pass AND $conn->query($sql);
    if($pass) echo "Create credentials table OK...<br/>";
    else echo "<b>".$conn->error."</b><br/>";
  }
  
  if($pass)
  {  
    $sql = "ALTER TABLE `".$_POST['Prefix']."_AdminCredentials`
              ADD PRIMARY KEY (`Password`),
              ADD UNIQUE KEY `ID` (`ID`);";;
      
    $pass = $pass AND $conn->query($sql);
    if($pass) echo "Alter credentials table (key) OK...<br/>";
    else echo "<b>".$conn->error."</b><br/>";
  }
  
  if($pass)
  {
    $sql = "ALTER TABLE `".$_POST['Prefix']."_AdminCredentials`
              MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=0;";

    $pass = $pass AND $conn->query($sql);
    if($pass) echo "Alter credentials table (AI) OK...<br/>";
    else echo "<b>".$conn->error."</b><br/>";
  }
    
  if($pass)
  {  
    $sql = "ALTER TABLE `".$_POST['Prefix']."_AdminCredentials`
              ADD CONSTRAINT `".$_POST['Prefix']."_AdminCredentials_ibfk_1` FOREIGN KEY (`Login`) REFERENCES `".$_POST['Prefix']."_Main` (`ID_Comp`) ON DELETE CASCADE ON UPDATE CASCADE;";
      
    $pass = $pass AND $conn->query($sql);
    if($pass) echo "Alter credentials table (Foreign Key) OK...<br/>";
    else echo "<b>".$conn->error."</b><br/>";
  }
    
  if($pass)
  {  
    $sql = "CREATE TABLE `".$_POST['Prefix']."_Sessions` (
              `session_id` varbinary(192) NOT NULL,
              `created` int(11) NOT NULL DEFAULT '0',
              `session_data` longtext COLLATE utf8mb4_unicode_ci
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;";  
    
    $pass = $pass AND $conn->query($sql);
    if($pass) echo "Create sessions table OK...<br/>";
    else echo "<b>".$conn->error."</b><br/>";
  }
    
  if($pass)
  {  
    $sql = "ALTER TABLE `".$_POST['Prefix']."_Sessions`
              ADD PRIMARY KEY (`session_id`);";
    
    $pass = $pass AND $conn->query($sql);
    if($pass) echo "Alter sessions table (key) OK...<br/>";
    else echo "<b>".$conn->error."</b><br/>";
  }
  
  if($pass)
  {
    $password = md5(rand());
    $encrypted = encrypt_data($password);
        
    $sql = "REPLACE INTO ".$_POST['Prefix']."_Main (ID_Comp) VALUE ('SuperAdmin');";
    
    $pass = $pass AND $conn->query($sql);
    if($pass) echo "Add SuperAdmin to main table OK...<br/>";
    else echo "<b>".$conn->error."</b><br/>";
  }
  
  if($pass)
  {
    $sql = "REPLACE INTO ".$_POST['Prefix']."_AdminCredentials (Login, Password) VALUE ('SuperAdmin', '$encrypted');";
    
    $pass = $pass AND $conn->query($sql);
    if($pass) echo "Admin credentials: SuperAdmin / $password<br/>";
    else echo "<b>".$conn->error."</b><br/>";
  }
  
  if($pass) echo "<br/>Project created without error! Delete init file<br/>";
  else echo "<br/><b>Error: please reload project and retry (delete created tables if needed)...</b><br/>";
     
  $conn->close();
  
?>

