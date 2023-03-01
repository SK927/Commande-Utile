<?php

  include("layout/header.php");

  if($_SESSION['Logged_In'])
  {        
    include("mysql/mysql_connect.php"); 
  
    $pageTitle = "Accueil";
    include("layout/title_bar.php");    
        
    $_SESSION['Comp_ID'] = null;
    $user = "%[".$_SESSION['User_ID']."]%";
    
?>
      <div class="row content rounded rounded-lg my-3 p-5">
        <div class="col-12">          
          <h3 class="mb-4 pb-2">Sélectionnez votre compétition :</h3>
        </div>     
        <div class="col-10 mx-auto my-3"> 
<?php       
            
    if($_SESSION['Is_SuperAdmin']) $results = $conn->query("SELECT * FROM #PREFIX_Main WHERE ID_Comp != 'SuperAdmin' ORDER BY ID_Comp ASC;"); 
    else $results = $conn->query("SELECT * FROM #PREFIX_Main WHERE Competitors LIKE '$user' AND Close_Date >= NOW() ORDER BY ID_Comp ASC;");  
  
    if($results->num_rows) /* Display competition the competitor partcipates in */
    { 
    
?>
          <form action="<?php echo $baseUrl; ?>/order/" method="POST">  
<?php 

      while($row = $results->fetch_assoc())
      { 
      
?>
            <button class="btn btn-classic mb-2" value="<?php echo $row['ID_Comp']; ?>" name="Comp_ID"><?php echo $row['Name']; ?></button>
<?php  

      } 
      
?>
          </form> 
<?php

    }
    else echo "Pas de compétitions en cours";  

    if($_SESSION['Is_Admin'])
    {          
      if($_SESSION['Is_SuperAdmin']) $results = $conn->query("SELECT * FROM #PREFIX_Main WHERE ID_Comp != 'SuperAdmin' ORDER BY ID_Comp ASC;"); 
      else $results = $conn->query("SELECT * FROM #PREFIX_Main WHERE Admins LIKE '$user' ORDER BY ID_Comp ASC;");           
      
      if($results->num_rows) /* Display competition the competitor partcipates in as organizer and/or Delegate */
      { 
      
?>
          <form action="<?php echo $baseUrl; ?>/admin/" method="POST">  
<?php      
 
        while($row = $results->fetch_assoc())
        {

?>
            <button class="btn btn-admin mb-2" value="<?php echo $row['ID_Comp']; ?>" name="Comp_ID">Administrer <?php echo $row['Name']; ?></button>
<?php

        }  

?>
          </form>
<?php
        
      }
    }
    
    if($_SESSION['Is_SuperAdmin']) /* Display master admin button, add master admin ID here */
    { 
?>
          <form action="<?php echo $baseUrl; ?>/manage/" method="POST">
            <button class="btn btn-dark mb-2">Gérer les compétitions</button>
          </form>
<?php
    }
    
    $conn->close();
    
?>
        </div>
      </div>
<?php   
        
  }
  else
  {
    header("Location: $baseUrl");    
    exit();
  }

  include("layout/footer.php"); 
  
?>