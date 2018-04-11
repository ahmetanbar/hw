<!DOCTYPE html>
<html>
<head>
  <title>Code Note</title>
  <link rel="stylesheet" type="text/css" href="./assets/css/signup.css">

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>
  <?php
      function control_post(){
        if(count($_POST)!=0){
          if(array_key_exists("name",$_POST) and array_key_exists("surname",$_POST) and array_key_exists("email",$_POST) and array_key_exists("username",$_POST) and array_key_exists("psw",$_POST) and array_key_exists("gender",$_POST)){
            $logs=array("name"=>"","surname"=>"","email"=>"","username"=>"","password"=>"","foot_note"=>"");
            if($_POST['name']!=NULL and $_POST['surname']!=NULL and $_POST['email']!=NULL and $_POST['username']!=NULL and $_POST['psw']!=NULL and $_POST['gender']!=NULL){
                $varify_cont=0;
                //name regular expression control
                $subject = $_POST['name'];
                $_SESSION["name"]=$subject;
                $pattern = '/^[a-zA-Z]{3,20}$/';
                if(preg_match($pattern,$subject)){
                  $varify_cont+=1;
                }
                else{
                  $logs['name']="Write a real name!";
                }
                //surname regular expression control
                $subject = $_POST['surname'];
                $_SESSION["surname"]=$subject;
                $pattern = '/^[a-zA-Z]{2,20}$/';
                if(preg_match($pattern,$subject)){
                  $varify_cont+=1;
                }
                else{
                  $logs['surname']="Write a real surname!";
                }
                //email regular expression control
                $_SESSION["email"]=$subject;
                if(filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
                  $varify_cont+=1;
                }
                else{
                  $logs['email']="Write a valid email!";
                }
                //username regular expression control
                $subject = $_POST['username'];
                $_SESSION["username"]=$subject;
                $pattern = '/^[a-zA-Z0-9_-]{3,20}$/';
                if(preg_match($pattern,$subject)){
                  $varify_cont+=1;
                }
                else{
                  if(strlen($subject)>=3 and strlen($subject)<=20)
                  $logs['username']="You can use only letter, number, '_' and '-'!";
                  else if(strlen($subject)<3 or strlen($subject)>20)
                  $logs['username']="Username must has length of 3-20!";
                }
                //password regular expression control
                $subject = $_POST['psw'];
                $pattern='/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])[a-zA-Z0-9]{10,30}$/';
                if(preg_match($pattern,$subject)){
                  $varify_cont+=1;
                  $_SESSION["psw"]=$subject;
                }
                else{
                  if(strlen($subject)>=10 and strlen($subject)<=30)
                  $logs['password']="Password must contain lowercase,uppercase,number!";
                  else if(strlen($subject)<10 or strlen($subject)>30)
                  $logs['password']="Password must has length of 10-30!";
                }
            }
            else{
                $logs['foot_note']="Complete All of Them!";
            }
            return $logs;
          }
        }
      }
    //_SESSION can be move other place???
    $_SESSION=array("name"=>"","surname"=>"","email"=>"","username"=>"","password"=>"");
    $logs=control_post();
  ?>
  <div class="main">
      <div class="header">
        <h1>Code Note</h1>
      </div>
      <div class="topnav">
        <a href="./home.php">Home</a>
        <a href="#">Archive</a>
        <a href="https://google.com">About</a>
        <a style="float:right;" href="#">Log In</a>
      </div>
      <br>
      <div class="content">
          <br>
          <h1>Join CodeNote</h1>

          <form action="" method="post" autocomplete="off" />
            <?php echo ($logs['foot_note']) ? '<span style="color:#c30000;">'.$logs['foot_note'].'</span><br>':''; ?>
            <?php echo ($logs['name']) ? '<span style="color:#c30000;">'.$logs['name'].'</span><br>':''; ?>
            <?php echo ($logs['surname']) ? '<span style="color:#c30000;">'.$logs['surname'].'</span><br>':''; ?>
            <input value="<?php echo ($_SESSION['name']) ? $_SESSION['name'] : '' ;?>" style="width: 180px;" type="text" name="name" placeholder="Name"><input value="<?php echo ($_SESSION['surname']) ? $_SESSION['surname'] : '' ;?>" type="text" name="surname" placeholder="Surname" style="width: 180px;">
            <br>
            <?php echo ($logs['email']) ? '<span style="color:#c30000;">'.$logs['email'].'</span><br>':''; ?>
            <input value="<?php echo ($_SESSION['email']) ? $_SESSION['email'] : '' ;?>" type="text" name="email" placeholder="Phone or Email">
            <br>
            <?php echo ($logs['username']) ? '<span style="color:#c30000;">'.$logs['username'].'</span><br>':''; ?>
            <input value="<?php echo ($_SESSION['username']) ? $_SESSION['username'] : '' ;?>" type="text" name="username" placeholder="Username">
            <br>
            <?php echo ($logs['password']) ? '<span style="color:#c30000;">'.$logs['password'].'</span><br>':''; ?>
            <input value="<?php echo ($_SESSION['password']) ? $_SESSION['password'] : '' ;?>" type="password" name="psw" placeholder="Password">
            <br>
            <br><input type="radio" name="gender" value="male" style="font-size:1.2em;" checked> <label style="font-size: 18px;">Male</label>
            <input type="radio" name="gender" value="female"; ><label style="font-size: 18px;">Female</label> <br>
            <br>
            <input type="submit" value="Sign Up" style="padding: 14px 30px; font-size:1.0em;">
          </form>
      </div>
      <br>
      <br>
      <footer>Copyleft &copy;</footer>
  </div>
</body>
</html>
