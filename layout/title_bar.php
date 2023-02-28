      <!-- NAVBAR --->
      <nav id="title-bar" class="row navbar px-3 mb-4 align-items-start">
        <div class="col-2 navbar-left p-0 text-left">
          <a href="<?php echo $baseUrl; ?>">
            <img src="<?php echo $baseUrl; ?>/img/logo_top.png" alt="Commande Utile" />
          </a>
        </div>
        <div class="col-8 navbar-center p-0">
          <h1 id="page-title" class="navbar-title">
            <?php echo $pageTitle; ?>
<?php

  if($_SERVER['REQUEST_URI'] == "/order/")
  {

?>
            <br/>(0 €)
<?php

  }
        
?>
          </h1>
        </div>
        <div class="col-2 navbar-right p-0 text-right">
<?php

  if($_SESSION['Logged_In'])
  {

?>
          <img id="user-avatar" src="<?php echo $_SESSION['Avatar']; ?>" alt="User" onclick="$('#user-menu').toggle();" />
<?php

  }

?>
        </div>
      </nav>
      <div id="user-menu" class="rounded p-3 text-right">
        <?php echo $_SESSION['Name']; ?><br/>
        <?php echo $_SESSION['ID_WCA']; ?><br/>
        <a href="<?php echo $baseUrl; ?>/sessions/session_quit.php">Déconnexion</a>
      </div>