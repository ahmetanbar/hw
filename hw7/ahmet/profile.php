<!DOCTYPE html>
<html>
<head>
  <title>Code Note</title>
  <link rel="stylesheet" type="text/css" href="./assets/css/profile.css">
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
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <?php include 'topnav.php';?>
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

      <div class="row">
        <div class="column1">
          <?php $img_source="./assets/image/profiles/";
          $profiles=array("james","dennis","linus","morgan","rasmus");
          $img_source=$img_source.$_SESSION['photo'].".jpg";
          echo("<img src=".$img_source." ");
           ?>
          alt="profile" height="220" width="220">
          <h2 style="padding-top:0px;"><?php echo $_SESSION['name']." ".$_SESSION['surname']; ?></h2>
          <h3 style="padding-top:0px;">@<?php echo $_SESSION['username']; ?></h3>
          <h5 style="padding-top:0px;"><?php echo $_SESSION['about']; ?></h5>
          </div>
        <div class="column2">
          <h1>Activities</h1>
          <ul>
            <li>CoffeeCoffeeCoffeeCoffeeCoffeeCoffeeCoffeeCoffeeCoffeeCoffeeCoffeeCoffeeCoffeeCoffeeCoffeeCoffeeCoffeeCoffeeCoffeeCoffeeCoffeeCoffee</li>
            <li>Nanana</li>
            <li>Nanana</li>
          </ul>
          </div>
      </div>





    <?php include 'footer.php';?>
  </div>
</body>
</html>
