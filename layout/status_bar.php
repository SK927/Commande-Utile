<?php

    if(isset($_POST['Status']))
    {
      
?>
      <div class='col-12 alert <?php if($_POST['Status']) echo "alert-success"; else echo "alert-danger"; ?> p-1 mb-4'>
        <?php echo "<strong>".$_POST['Display_Text']."</strong>"; if(!empty($_POST['Error'])) echo " (err : ".$_POST['Error'].")"; ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
<?php

    }

?>