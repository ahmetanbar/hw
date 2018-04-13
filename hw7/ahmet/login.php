<!DOCTYPE html>
<html>
<head>
  <title>Code Note</title>
  <link rel="stylesheet" type="text/css" href="./assets/css/login.css">
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>
  <?php
      function generateRandomString($length = 52) {
          return substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($length/strlen($x)) )),1,$length);
      }

      function control_cookie(){
        if(count($_COOKIE)!=0 and array_key_exists("auth",$_COOKIE)){
          $auth= $_COOKIE['auth'];
          $servername = "localhost";
          $db_username = "root";
          $db_password = "";
          $db="hw7";
          $conn = new mysqli($servername, $db_username, $db_password,$db);
          $stmt = $conn->prepare("SELECT auth FROM cookie WHERE auth=?");
          $stmt->bind_param("s", $auth);
          $stmt->execute();
          $result = $stmt->get_result();
          $row = $result->fetch_assoc();
           if(count($row)!=0)
           {
             header("Location:home.php"); /* Redirect browser */
           }
        }
      }

      function control_post(){
        if(count($_POST)!=0){
          if(array_key_exists("useroremail",$_POST) and array_key_exists("psw",$_POST)){
            $logs=array("useroremail"=>"","password"=>"","foot_note"=>"","input_control"=>"");
            $_SESSION['useroremail']=$_POST['useroremail']; $_SESSION['password']=$_POST['psw'];
            if($_POST['useroremail']!=NULL and $_POST['psw']!=NULL){
                $verify_cont=0;
                $flag="";
                //email and email regular expression control
                $subject = $_POST['useroremail'];
                if(filter_var($subject, FILTER_VALIDATE_EMAIL)){
                  $verify_cont+=1;
                }
                else{
                  $pattern = '/^[a-zA-Z0-9_-]{3,20}$/';
                  if(preg_match($pattern,$subject)){
                    $verify_cont+=3;
                  }
                  else{
                    $logs['useroremail']="Wrong username or email";
                  }
                }

                //password regular expression control
                $subject = $_POST['psw'];
                $pattern='/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])[a-zA-Z0-9]{10,30}$/';
                if(preg_match($pattern,$subject)){
                  $verify_cont+=5;
                  $_SESSION["password"]=$subject;
                }
                else{
                  if($logs['useroremail']==NULL)
                  $logs['useroremail']="Wrong password";
                }
                // ----------------------after right input types-----------------//
                if($verify_cont==6 or $verify_cont==8){
                  $servername = "localhost";
                  $db_username = "root";
                  $db_password = "";
                  $db="hw7";
                  // $conn = new mysqli($servername, $db_username, $db_password,$db);
                  try{
                    $conn = new mysqli($servername, $db_username, $db_password,$db);
                    if ($conn->connect_error) {
                      die("Connection failed: " . $conn->connect_error);
                    }
                  }
                  catch(Exception $e) {
                    //log handled
                  }

                  $password=$_POST['psw'];
                  $hashed_password = hash('sha512',$_POST['psw']);
                  if($verify_cont==6){
                     $email=strtolower($_POST['useroremail']);
                     $stmt = $conn->prepare("SELECT email FROM users WHERE email=?");
                     $stmt->bind_param("s", $email);
                     $stmt->execute();


                     $sql_all = "SELECT email,password FROM users WHERE email='$email' and password='$hashed_password'";
                  }
                  else{
                    $username=$_POST['useroremail'];
                    $sql = "SELECT username FROM users WHERE username='$username'";
                    $sql_all = "SELECT id,username,password FROM users WHERE username='$username' and password='$hashed_password'";
                  }
                  echo($verify_cont);
                  $result = $stmt->get_result();
                  $row = $result->fetch_assoc();
                  if(count($row)!=0){
                    $result = $stmt_all->get_result();
                    $row = $result->fetch_assoc();
                    if(count($row)!=0){
                      $user_id=$row["id"];
                      $auth=generateRandomString();
                      $sql = "INSERT INTO cookie (auth,user_id) VALUES('$auth','$user_id')";
                      setcookie('auth',$auth);
                      if ($conn->query($sql)==TRUE) {
                         header("Location:home.php"); /* Redirect browser */
                       }
                    }
                    else{
                      $logs['input_control']="Wrong password.Try again.";
                    }
                  }
                  else{
                      $logs['input_control']="Not found username or email.Want to <a href=\"signup.php\">Sign Up</a>?";
                  }
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
      control_cookie();
      $_SESSION=array("useroremail"=>"", "password"=>"");
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
        <a style="float:right;" href="signup.php">Sign Up</a>
      </div>
      <br>
      <div class="content">
          <br>
          <h1>Log in to CodeNote</h1>

          <form action="" method="post" autocomplete="off" />
            <?php echo ($logs['input_control']) ? '<span style="color:#c30000;">'.$logs['input_control'].'</span><br>':''; ?>
            <?php echo ($logs['foot_note']) ? '<span style="color:#c30000;">'.$logs['foot_note'].'</span><br>':''; ?>
            <?php echo ($logs['useroremail']) ? '<span style="color:#c30000;">'.$logs['useroremail'].'</span><br>':''; ?>
            <input value="<?php echo ($_SESSION['useroremail']) ? $_SESSION['useroremail'] : '' ;?>" type="text" name="useroremail" placeholder="Username or email">
            <br>
            <?php echo ($logs['password']) ? '<span style="color:#c30000;">'.$logs['password'].'</span><br>':''; ?>
            <input value="<?php echo ($_SESSION['password']) ? $_SESSION['password'] : '' ;?>" type="password" name="psw" placeholder="Password">
            <br>
            <input type="submit" value="Log In" style="padding: 14px 30px; font-size:1.0em;">
          </form>
      </div>
      <br>
      <br>
      <footer>Copyleft &copy;</footer>
  </div>
</body>
</html>
