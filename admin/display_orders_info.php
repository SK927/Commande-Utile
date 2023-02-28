<?php

    $results = $conn->query("SELECT SUM(Order_Total) FROM #PREFIX_$compId;");    
    $total = ($results->fetch_assoc())['SUM(Order_Total)'];
    
    if($total)
    {
    
?>
      <div class="row content rounded-bottom rounded-lg mb-4">
        <div class="col-12 pinned block-header px-3 text-center">
          <h4 class="py-3">COMMANDES (<?php echo round($total,2); ?>&nbsp;€)</h4>
        </div>
        <div class="col-12 block-data rounded-bottom rounded-lg mb-2 p-3">
          <div class="row">
<?php

      $results = $conn->query("SELECT * FROM #PREFIX_$compId ORDER BY Name ASC;");    

      while($row = $results->fetch_assoc())
      {
        $orderArray = json_decode($row['Order_Data'], true);
?>
            <div class="col-md-6 col-xl-4 my-2">
              <div id="<?php echo $row['ID']; ?>" class="card">
                <div class="card-header">
                  <span class="order-info"><?php echo $row['Name']; ?> (<?php if($row['Paid']) echo "Payé"; else echo $row['Order_Total']."&nbsp;€"; ?>)</span>
                </div>
                <div class="card-text p-3 text-left">
 <?php
    
        foreach($competitionJson as $blockKey=>$blockValue)
        {
          $blockData = $orderArray[$blockKey];

?>             
                  <div class="row my-2">
                    <div class="col-9">
                      <?php if($blockData['Given']) echo "<strike>"; ?>
                      <?php echo "<b>".htmlspecialchars(trim(ucfirst(strtolower($blockKey))))."&nbsp;:</b> "; ?>
<?php

          foreach($blockValue as $itemKey=>$itemValue)
          {
            if($blockData[$itemValue['Item-Name']])
            {
              $itemAmounts[$blockKey.$itemValue['Item-Name']] += $blockData[$itemValue['Item-Name']]; /* Calculate number of items ordered through all placed order */
              echo $blockData[$itemValue['Item-Name']]."&nbsp;".htmlspecialchars($itemValue['Item-Name'])."&nbsp;; "; /* Display number of items ordered in current order */ 
            }
          }
          
          if($blockData['Given']) echo "</strike>";
          
?>
                    </div>
                    <div class="col-3 text-right">
                      <form action="toggle_given.php" method="POST">
                        <input type="hidden" name="ID" value="<?php echo $row['ID']; ?>">
                        <input type="hidden" name="Block" value="<?php echo $blockKey; ?>">
                        <button class="btn <? if(!$blockData['Given']) echo 'btn-outline-danger'; else echo 'btn-outline-success'; ?>" name="Submit" title="Marquer comme<?php if($blockData['Given']) echo " non"; ?> distribué"><? if($blockData['Given']) echo "O"; else echo "X"; ?></button>
                      </form>
                    </div>
                  </div>
              
<?php

      }

?>
                  <div class="row my-2">
                    <div class="col-12">
                      <b>Com&nbsp;:</b> <?php echo htmlspecialchars(trim($row['Comment'])); ?>  
                    </div>
                  </div>
                  <div class="row mt-4 mb-2">
                    <div class="col-md-5 mb-1">
                      <form action="toggle_paid.php" method="POST">
                        <input type="hidden" name="ID" value="<?php echo $row['ID']; ?>">
                        <button name="Submit" class="btn <? if(!$row['Paid']) echo 'btn-outline-danger'; else echo 'btn-outline-success'; ?>" title="Marquer comme<?php if($row['Paid']) echo " non"; ?> payé"><? if($row['Paid']) echo "Payé"; else echo "&Agrave; payer"; ?></button>
                      </form>
                    </div>
                    <div class="col-md-7">
                      <form action="delete_order.php" method="POST" onclick="clicked(event)">
                        <input type="hidden" name="ID" value="<?php echo $row['ID']; ?>">
                        <input type="hidden" name="Name" value="<?php echo $row['Name']; ?>">
                        <input type="hidden" name="Email" value="<?php echo $row['Email']; ?>">
                        <button class="btn btn-outline-danger" name="Submit" title="Supprimer la commande">Supprimer</button>
                      </form>
                    </div>
                  </div>
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

      if($competitionJson != NULL)
      {
        foreach($competitionJson as $blockKey=>$blockValue)
        {
    
?>
      <div class="row content rounded-bottom rounded-lg mb-4">
          <div class="col-12 pinned block-header px-3 text-center">
            <h4 class="py-3"><?php echo htmlspecialchars(trim($blockKey)); ?></h4>
          </div>
          <div class="col-12 block-data rounded-bottom rounded-lg mb-2 p-3">
            <div class="row">
<?php

          foreach($blockValue as $itemKey=>$itemValue)
          {
            if($itemAmounts[$blockKey.$itemValue['Item-Name']])
            {
            
?>
                <div class="col-sm-6 col-md-4 col-lg-2 my-2">
                  <div class="card item-sum p-2">
                    <span class="amount"><?php echo $itemAmounts[$blockKey.$itemValue['Item-Name']]; ?></span>
                    <span><?php echo htmlspecialchars($itemValue['Item-Name']); ?></span>
                  </div>
                </div>
<?php 

            }
          }
      
?>
            </div>
          </div>
        </div>
        
<?php

        }
      }
    }

?>