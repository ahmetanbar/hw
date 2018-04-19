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
      function connect_db(){
        $servername = "localhost";
        $db_username = "root";
        $db_password = "";
        $db="hw7";
        $conn = new mysqli($servername, $db_username, $db_password,$db);
        mysqli_set_charset($conn,"utf8");
        return $conn;
      }

      function generateRandomString($length = 52) {
          return substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($length/strlen($x)) )),1,$length);
      }

      function control_cookie(){
        if(count($_COOKIE)!=0 and array_key_exists("auth",$_COOKIE)){
          $auth= $_COOKIE['auth'];
          $conn=connect_db();
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
            $logs=array("useroremail"=>"","password"=>"","foot_note"=>"","input_control"=>"","value_input"=>"");
            if($_POST['useroremail']!=NULL and $_POST['psw']!=NULL){
                $verify_cont=0;
                //email and username regular expression control
                $subject = $_POST['useroremail'];
                if(filter_var($subject, FILTER_VALIDATE_EMAIL)){
                  $verify_cont+=1;
                  $logs['value_input']=$subject;
                }
                else{
                  $pattern = '/^[a-zA-Z0-9_-]{3,20}$/';
                  if(preg_match($pattern,$subject)){
                    $verify_cont+=3;
                    $logs['value_input']=$subject;
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
                }
                else{
                  if($logs['useroremail']==NULL)
                  $logs['useroremail']="Wrong password";
                }

                // ----------------------after right input types-----------------//
                // 6 is 5+1 as email type, 8 is 5+3 as username type
                if($verify_cont==6 or $verify_cont==8){
                  $conn=connect_db();
                  $password=$_POST['psw'];
                  $hashed_password = hash('sha512',$_POST['psw']);

                  //queries according to input type email or username
                  //as stmt control only email for email is alread used, stmt_all controls email and password because of that
                  // email is using but password is true?
                  if($verify_cont==6){
                     $email=strtolower($_POST['useroremail']);
                     $stmt = $conn->prepare("SELECT email FROM users WHERE email=?");
                     $stmt->bind_param("s", $email);

                     $stmt_all = $conn->prepare("SELECT id,name,surname,email,username FROM users WHERE email=? and password=?");
                     $stmt_all->bind_param("ss", $email,$hashed_password);
                  }
                  else{
                    $username=$_POST['useroremail'];
                    $stmt = $conn->prepare("SELECT username FROM users WHERE username=?");
                    $stmt->bind_param("s", $username);

                    $stmt_all = $conn->prepare("SELECT id,name,surname,email,username FROM users WHERE username=? and password=?");
                    $stmt_all->bind_param("ss", $username,$hashed_password);
                  }
                  //queris accured and be queried
                  $stmt->execute();
                  $result = $stmt->get_result();
                  $row = $result->fetch_assoc();
                  if(count($row)!=0){
                    $stmt_all->execute();
                    $result = $stmt_all->get_result();
                    $row = $result->fetch_assoc();
                    if(count($row)!=0){
                      $_SESSION['name']=$row["name"]; $_SESSION['surname']=$row["surname"]; $_SESSION['email']=$row["email"]; $_SESSION['username']=$row["username"];
                      $user_id=$row["id"];
                      $auth=generateRandomString();
                      $stmt = $conn->prepare("INSERT INTO cookie (auth, user_id) VALUES (?, ?)");
                      $stmt->bind_param("si", $auth, $user_id);
                      $stmt->execute();
                      setcookie('auth',$auth);
                         header("Location:home.php");
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
      session_start();
      control_cookie();
      $logs=control_post();
  ?>
  <div class="topnav">
    <a href="home.php" style="padding-bottom: 0px; padding-top: 0px;"> <img  src='assets/image/logo.jpg' alt='photo of me' width="100" height="71" /> </a>
    <a href="./home.php">Home</a>
    <a href="#">Archive</a>
    <a href="https://google.com">About</a>
    <a style="float:right;" href="signup.php">Sign Up</a>
  </div>

  <div class="main">
      <div class="header">
        <h1>Code Note</h1>
      </div>
      <br>
      <div class="content">
          <br>
          <h1>Log in to CodeNote</h1>

          <form action="" method="post" autocomplete="off" />
            <?php echo ($logs['input_control']) ? '<span style="color:#c30000;">'.$logs['input_control'].'</span><br>':''; ?>
            <?php echo ($logs['foot_note']) ? '<span style="color:#c30000;">'.$logs['foot_note'].'</span><br>':''; ?>
            <?php echo ($logs['useroremail']) ? '<span style="color:#c30000;">'.$logs['useroremail'].'</span><br>':''; ?>
            <input value="<?php echo ($logs['value_input']) ? $logs['value_input'] : '' ;?>" type="text" name="useroremail" placeholder="Username or email">
            <br>
            <?php echo ($logs['password']) ? '<span style="color:#c30000;">'.$logs['password'].'</span><br>':''; ?>
            <input type="password" name="psw" placeholder="Password">
            <br>
            <input type="submit" value="Log In" style="padding: 14px 30px; font-size:1.0em;">
          </form>
      </div>
      <br>
      <br>
            <footer>Copyleft <span class="copy-left">©</span></footer>
  </div>
</body>
</html>
