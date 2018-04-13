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
    function control_cookie(){
      if(count($_COOKIE)!=0 and array_key_exists("auth",$_COOKIE)){
        $cookie_know=array("flag"=>"FALSE","username"=>"","name"=>"","surname"=>"");
        $auth= $_COOKIE['auth'];
        $servername = "localhost";
        $db_username = "root";
        $db_password = "";
        $db="hw7";
        $conn = new mysqli($servername, $db_username, $db_password,$db);
        $sql = "SELECT auth,user_id FROM cookie WHERE auth='$auth'";
        $result = $conn->query($sql) or die($conn->error);
        $row = $result->fetch_assoc();
         if(count($row)!=0)
         {
           $sql = "SELECT name,surname,username FROM users WHERE id=".$row["user_id"]."";
           $result = $conn->query($sql) or die($conn->error);
           $row = $result->fetch_assoc();
           $cookie_know['flag']=TRUE;
           $cookie_know['name']=$row['name']; $cookie_know['surname']=$row['surname']; $cookie_know['username']=$row['username'];
           return $cookie_know;
         }
         else{
           $cookie_know['flag']=FALSE;
           return $cookie_know;
         }
      }
    }
    $cookie_know=control_cookie();

  ?>
  <div class="topnav">
    <a href="home.php" style="padding-bottom: 0px; padding-top: 0px;"> <img  src='assets/image/logo.jpg' alt='photo of me' width="100" height="71" /> </a>
    <a href="#">Home</a>
    <a href="#">Archive</a>
    <a href="https://google.com">About</a>
    <?php
    if($cookie_know['flag']){ ?>
      <a style="float:right;" href="profile.php"><?php echo($cookie_know['name']." ".$cookie_know['surname'] ); ?> </a>
    <?php
    }
    else{ ?>
      <a style="float:right;" href="signup.php">Sign Up</a>
      <a style="float:right;" href="login.php">Log In</a>
    <?php } ?>
  </div>

  <div class="main">

      <div class="header">
        <h1>Code Note</h1>
      </div>
      <?php if($cookie_know['flag']){ ?>
      <div class="usernav">
          <a href="profile.php"><i><?php echo($cookie_know['username']); ?></i></a>
          <a href="logout.php"><i style="float:left;" class="material-icons md-18">exit_to_app</i></a>
      </div>
      <br>
      <?php } ?>
      <br>
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

      <footer>Copyleft <span class="copy-left">©</span></footer>
  </div>
</body>
</html>
