<!DOCTYPE html>
<html>
<head>
  <title>Code Note</title>
  <link rel="stylesheet" type="text/css" href="./assets/css/home.css">
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>
  <?php
    $admin="admin";

    function connect_db(){
      $servername = "localhost";
      $db_username = "root";
      $db_password = "";
      $db="hw7";
      $conn = new mysqli($servername, $db_username, $db_password,$db);
      mysqli_set_charset($conn,"utf8");
      return $conn;
    }

    function control_cookie(){
      if(count($_COOKIE)!=0 and array_key_exists("auth",$_COOKIE)){
        $auth= $_COOKIE['auth'];

        $cookie_know=array("flag"=>"FALSE","username"=>"","name"=>"","surname"=>"");

        $conn=connect_db();
        $stmt = $conn->prepare("SELECT auth,user_id FROM cookie WHERE auth=?");
        $stmt->bind_param("s", $auth);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

         if(count($row)!=0)
         {
           $cookie_know['flag']=TRUE;
           return $cookie_know;
         }
         else{
           $cookie_know['flag']=FALSE;
           return $cookie_know;
         }
      }
    }

    session_start();
    $cookie_know=control_cookie();

  ?>
  <div class="topnav">
    <a href="home.php" style="padding-bottom: 0px; padding-top: 0px;"> <img  src='assets/image/logo.jpg' alt='logo' width="100" height="71" /> </a>
    <a href="">Home</a>
    <a href="#">Archive</a>
    <a href="https://google.com">About</a>
    <?php
    if($cookie_know['flag']){ ?>
      <a style="float:right;" href="profile.php"><?php echo($_SESSION['name']." ".$_SESSION['surname']); ?> </a>
      <?php echo ($_SESSION['role']==$admin ? '<a style="float:right;" href="admin/panel.php"><i class="material-icons">vpn_key</i></a>':'');
    }
    else{ ?>
      <a style="float:right;" href="signup.php">Sign Up</a>
      <a style="float:right;" href="login.php">Log In</a>
    <?php } ?>
  </div>

  <div class="main">
    <?php if($cookie_know['flag']){ ?>
    <div class="usernav">
        <a href="profile.php"><i><?php echo("@".$_SESSION['username']); ?></i></a>
        <a href="logout.php"><i style="float:left;" class="material-icons md-18">exit_to_app</i></a>
    </div>
    <br>
    <?php } ?>
    <br>
      <div class="header">
        <h1>Code Note</h1>
      </div>

        <?php $number_box=5;
        for($i=0; $i<=$number_box ;$i++) { ?>
          <div class="content">
              <div class="art_head">
                <h3><a href="https://google.com">Code Day</a></h3>
              </div>
              <div class="article"><p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas sit amet pretium urna. Vivamus venenatis velit nec neque Lorem ipsum dolor sit amet,ass consectetur adipiscing elit. Maecenas sit amet pretium urna. Vivamus venenatis velit nec nequeLorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas sit amet pretium urna. Vivamus venenatis velit nec nequeLorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas sit amet pretium urna. Vivamus venenatis velit nec neque ultricies, eget elementum magna tristique. Quisque vehicula, risus eget aliquam placerat, purus leo tincidunt eros, eget luctus quam orci in velit. Praesent scelerisque tortor sed accumsan convallis.
              <a href="https://google.com">More▷</a></p>
            </div>
            <div class="info">
              <i style="float:left; " class="material-icons md-18">date_range</i>
              <a style="float:left;" href="https://google.com">12.01.2017</a>
              <i style="float:left;" class="material-icons md-18" >account_balance</i>
              <a style="float:left;" href="https://google.com">Java</a>

              <i style="float:left;" class="material-icons md-18" >account_circle </i>
              <a style="float:left; " href="https://google.com">Ahmet Anbar</a>
              <a style="float:right;" href="https://google.com" >Viewing:5</a>
              <i style="float:right;" class="material-icons md-18">assessment</i>
              <a style="float:right;" href="https://google.com">Comments:7</a>
              <i style="float:right;" class="material-icons md-18">comment</i>
              <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
            </div>
          </div>
            <br>
          <?php } ?>

      <footer><a href="https://github.com/ahmetanbar"><img src='assets/image/github-logo.png' alt='photo of me' width="35" height="35" ></a><br>Copyleft<span class="copy-left">©</span></footer>
  </div>
</body>
</html>
