<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr">
  <head>
    <title>INIT</title>
    <meta name="author" content="ML" />
    <meta name="Description" content="Initialisation" />
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <link rel="icon" type="image/png" href="../img/favicon.png" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <!-- Bootstrap Core CSS -->
    <link href="../css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="../css/custom.css" rel="stylesheet">
    
    <!-- Add jQuery support -->
    <script src="../js/jquery-3.6.3.min.js"></script>
  </head>

  <body>
    <div class="container text-center">
      <form action="init_project.php" method="POST" style="width:100%">
        <div class="row content rounded-bottom rounded-lg my-3 p-5">
          <div class="col-6"><label for="Admins">Admins WCA User Id (as [UserID1][UserID2]...)</label></div>
          <div class="col-6 mb-4"><input name="Admins" class="form-control rounded text-center" type="text" /></div>
          <div class="col-6"><label for="Prefix">DB Tables Prefix</label></div>
          <div class="col-6 mb-4"><input name="Prefix" class="form-control rounded text-center" type="text" /></div>
          <div class="col-6"><label for="App_Id">WCA Application ID</label></div>
          <div class="col-6 mb-4"><input name="App_Id" class="form-control rounded text-center" type="text" /></div>
          <div class="col-6"><label for="App_Secret">WCA Application Secret</label></div>
          <div class="col-6 mb-4"><input name="App_Secret" class="form-control rounded text-center" type="text" /></div>
          <div class="col-6"><label for="Host">DB Host</label></div>
          <div class="col-6 mb-4"><input name="Host" class="form-control rounded text-center" type="text" /></div>
          <div class="col-6"><label for="Username">DB Username</label></div>
          <div class="col-6 mb-4"><input name="Username" class="form-control rounded text-center" type="text" /></div>
          <div class="col-6"><label for="Password">DB Password</label></div>
          <div class="col-6 mb-4"><input name="Password" class="form-control rounded text-center" type="text" /></div>
          <div class="col-6"><label for="Db">DB Name</label></div>
          <div class="col-6 mb-4"><input name="Db" class="form-control rounded text-center" type="text" /></div>
          <div class="col-6"><label for="Key">Encrypt Key</label></div>
          <div class="col-6 mb-4"><input name="Key" class="form-control rounded text-center" type="text" /></div>
          <div class="col-6"><label for="IV">Encrypt IV</label></div>
          <div class="col-6 mb-4"><input name="IV" class="form-control rounded text-center" type="text" /></div>
        </div>
        <div class="row submit-buttons">
          <button class="btn btn-success" name="Submit">Démarrer</button>
        </div>
      </form>
    </div>
  </body>
</html>

