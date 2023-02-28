      <script>
        function updateValue(chars, cost, increment) 
        {
          var elt = document.getElementById(chars);
          if(increment == 1) elt.stepUp(); /* Increment value by 1  */
          else if (increment == -1) elt.stepDown(); /* Decrement value by 1 */
                
          getTotal();
        }

        function getTotal()
        {
          var total = 0;
                    
          /* Create items list */
          var items = [
          
<?php 
  
  foreach($competitionJson as $blockKey=>$blockValue)
  {
    foreach($blockValue as $itemKey=>$itemValue)
      {
      
?>
            [<?php echo "'".htmlspecialchars($itemKey)."', ".$itemValue['Item-Price']; ?>], /* For each item, create tuple containing item ID and item price */
<?php
       
    }
  }
  
?>
          ];
              
          /* Check for all items if added to order or not and modify classes as needed */
          for (var i = 0; i < items.length; i++)
          { 
            item = document.getElementById(items[i][0]);
            if(item.value == 0) item.classList.remove("has-item");
            else 
            {
              item.classList.add("has-item");
              price = items[i][1]; /* Get price */
              total += parseFloat(item.value * price); /* Add amount to total for display */
            }
          }
                    
          if(total==NaN) total = 0;
          
          var str = "(" + total.toFixed(2).toString() + "&nbsp;€)";
               
          /* Update total cost in title bar */
          var old_str = document.getElementById('page-title').innerHTML;
          document.getElementById('page-title').innerHTML = old_str.replace(/ *\([^)]*\) */g, str);
        }
        
        function clicked(e)
        {
          if(!confirm('Confirmer la suppression?')) e.preventDefault();
        };

        var submitted = 0;
        var form = $('#orderForm').serialize();
                
        window.addEventListener('beforeunload', (event) => {
          if(form != $('#orderForm').serialize() && !submitted) event.preventDefault();
        });

        getTotal();
      </script>
