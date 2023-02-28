<?php

  include("../layout/header.php");

  if($_SESSION['Logged_In'] AND isset($_POST['Comp_ID']))
  {    

    $_SESSION['Comp_ID'] = $_POST['Comp_ID'];
    
    include("includes/get_competition_data.php");
    
    $pageTitle = "Commande ".$competitionData['Name'];
    include("layout/title_bar.php"); 
    
    include("order/retrieve_order_data.php");

?>
      <form id="orderForm" action="confirm_order.php" method="POST" name="OrderForm" onsubmit="submitted = 1;">
        <div class="row content rounded-bottom rounded-lg mb-4">
          <div class="col-12 pinned block-header px-3 text-center">
            <div class="col-12 text-center">
              <h4 class="py-3">INFORMATIONS</h4>
            </div>
          </div>
          <div class="col-12 block-data rounded-bottom rounded-lg mb-4 py-3 px-4">
            <div class="row">
              <div class="col-md-6 mt-2 mb-sm-4 mb-md-0 text-left">
                <h4><?php echo $_SESSION['Name']; ?></h4>
                <p>
                  <?php echo $_SESSION['ID_WCA']; ?><br/>
                  <?php echo $_SESSION['Email']; ?> 
                </p>
                <label class="mt-2">Commentaire</label>
                <textarea class="form-control rounded" name="Comment"><?php echo htmlspecialchars($orderData['Comment']); ?></textarea>
              </div>
              <div class="col-md-6 mt-2 text-left">
                <h4>Note de l'équipe organisatrice</h4>
                <p class="mb-4">
                  <?php echo htmlspecialchars($competitionData['Info']); ?>
                </p>
                <a class="col-12 contact text-center" href="https://www.worldcubeassociation.org/contact/website?competitionId=<?php echo $competitionData['ID_Comp']; ?>" target="_blank">
                  <div class="alert alert-contact m-0"><strong>Contacter l'équipe organisatrice</strong></div>
                </a>
              </div>
            </div>
          </div>
        </div>
<?php

    if($competitionJson != NULL)
    {
      foreach($competitionJson as $blockKey=>$blockValue)
      {
          $dataBlock = $orderJson[$blockKey];
    
?>
        <div class="row content rounded-bottom rounded-lg mb-4">
          <div class="col-12 pinned block-header px-3 text-center">
            <div class="col-12 text-center"><h4 class="py-3"><?php echo htmlspecialchars(trim($blockKey)); ?></h4></div>
          </div>
          <div class="col-12 block-data rounded-bottom rounded-lg mb-4 py-3 px-4">
            <div class="row">
<?php

        foreach($blockValue as $itemKey=>$itemValue)
        {
  
?>
              <div class="col-md-6 col-lg-4 col-xl-3 item-order my-2">
                <div class="card">
                  <img class="card-img-top my-2 mx-auto" src="../img/icons/<?php echo trim($itemValue['Item-Image']); ?>" alt="<?php echo htmlspecialchars(trim($itemValue['Item-Name'])); ?>">
                  <div class="card-footer">
                    <h5 class="card-title"><?php echo htmlspecialchars($itemValue['Item-Name'])." (".$itemValue['Item-Price']."&nbsp;€)"; ?></h5>
                    <p class="card-text description"><?php echo htmlspecialchars($itemValue['Item-Descr']); ?></p>
                    <div class="button sub" onclick="updateValue('<?php echo $itemKey; ?>', <?php echo $itemValue['Item-Price']; ?>, -1);">-</div>
                    <input id="<?php echo $itemKey; ?>" type="number" min=0 id="<?php echo $itemKey; ?>" name="<?php echo $itemKey; ?>" value="<?php echo $dataBlock[$itemValue['Item-Name']]; ?>" />
                    <div class="button add" onclick="updateValue('<?php echo $itemKey; ?>', <?php echo $itemValue['Item-Price']; ?>, 1);">+</div>
                  </div>
                </div>
              </div>      
<?php      
      
        }
      
?>
          
            </div>
          </div>
        </div>
        
<?php

      }
    }

?>

        <input type="hidden" name="ID" value="<?php echo $orderData['ID']; ?>" />
        <div class="row submit-buttons">
          <button class="btn btn-success mx-2" name="Send">Envoyer</button>
          <?php if($orderData['ID']) { ?><button class="btn btn-danger mx-2" type="submit" name="Cancel" onclick="clicked(event)">Annuler la commande</button><?php } ?>  
        </div>
      </form>
 <?php

    include("order/handle_orders_script.php");
  }
  else
  {
    header("Location: $baseUrl");    
    exit();
  } 
    
  include("layout/footer.php");

?>  