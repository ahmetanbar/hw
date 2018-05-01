<div class="topnav">
  <a href="home.php" style="padding-bottom: 0px; padding-top: 0px;"> <img  src='assets/image/logo.jpg' alt='logo' width="100" height="71" /> </a>
  <a href="home.php">Home</a>
  <a href="archive.php">Archive</a>
  <a href="about.php">About</a>
  <?php
  if($cookie_know['flag']){ ?>
    <a style="float:right;" href="profile.php"><?php echo($_SESSION['name']." ".$_SESSION['surname']); ?> </a>
    <a style="float:right; background-color:#813322;" href="editarticle.php">Write</a>

    <?php echo ($_SESSION['role']=="admin" ? '<a style="float:right;" href="admin/panel.php"><i class="material-icons">vpn_key</i></a>':'');
  }
  else{ ?>
    <a style="float:right;" href="signup.php">Sign Up</a>
    <a style="float:right;" href="login.php">Log In</a>
  <?php } ?>
</div>
