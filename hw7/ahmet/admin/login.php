<!DOCTYPE html>
<html>
<head>
  <title>Code Note</title>
  <link rel="stylesheet" type="text/css" href="./assets/css/login.css">
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>
  <div class="bg"></div>
  <?php
      function generateRandomString($length = 52) {
          return substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($length/strlen($x)) )),1,$length);
      }

      function control_cookie(){
        if(count($_COOKIE)!=0 and array_key_exists("auth",$_COOKIE)){
          $auth= $_COOKIE['admin_auth'];
          $servername = "localhost";
          $db_username = "root";
          $db_password = "";
          $db="hw7";
          $conn = new mysqli($servername, $db_username, $db_password,$db);
          $stmt = $conn->prepare("SELECT auth FROM cookie_admin WHERE auth=?");
          $stmt->bind_param("s", $auth);
          $stmt->execute();
          $result = $stmt->get_result();
          $row = $result->fetch_assoc();
           if(count($row)!=0)
           {
             echo '<pre>';
             print_r($_COOKIE);
             echo '</pre>';
             header("Location:panel.php"); /* Redirect browser */
           }
        }
      }

      function control_post(){
        if(count($_POST)!=0){
          if(array_key_exists("useroremail",$_POST) and array_key_exists("psw",$_POST)){
            $logs=array("useroremail"=>"","password"=>"","foot_note"=>"","input_control"=>"");
            $_SESSION['useroremail']=$_POST['useroremail'];
            if($_POST['useroremail']!=NULL and $_POST['psw']!=NULL){
                $verify_cont=0;
                //email and username regular expression control
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
                  $logs['useroremail']="Wrong password.Try again.";
                }

                // ----------------------after right input types-----------------//
                // 6 is 5+1 as email type, 8 is 5+3 as username type
                if($verify_cont==6 or $verify_cont==8){
                  $servername = "localhost";
                  $db_username = "root";
                  $db_password = "";
                  $db="hw7";
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
                  //queries according to input type email or username
                  //as stmt control only email for email is alread used, stmt_all controls email and password because of that
                  // email is using but password is true?
                  if($verify_cont==6){
                     $email=strtolower($_POST['useroremail']);
                     $stmt = $conn->prepare("SELECT email FROM users WHERE email=?");
                     $stmt->bind_param("s", $email);

                     $stmt_all = $conn->prepare("SELECT id,email,password FROM users WHERE email=? and password=?");
                     $stmt_all->bind_param("ss", $email,$hashed_password);
                  }
                  else{
                    $username=$_POST['useroremail'];
                    $stmt = $conn->prepare("SELECT username FROM users WHERE username=?");
                    $stmt->bind_param("s", $username);

                    $stmt_all = $conn->prepare("SELECT id,username,password FROM users WHERE username=? and password=?");
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
                      $user_id=$row["id"];
                      $stmt = $conn->prepare("SELECT user_id FROM admin WHERE user_id=?");
                      $stmt->bind_param("i", $user_id);
                      $stmt->execute();
                      $result = $stmt->get_result();
                      $row = $result->fetch_assoc();
                      if(count($row)!=0){
                        $auth=generateRandomString();
                        echo("buradayim");
                        $stmt = $conn->prepare("INSERT INTO cookie_admin (auth, user_id) VALUES (?, ?)");
                        $stmt->bind_param("ss", $auth, $user_id);
                        $stmt->execute();
                        setcookie('admin_auth',$auth);
                        header("Location:panel.php");
                      }
                      else{
                        $logs['input_control']="Not found authorization";
                      }
                    }
                    else{
                      $logs['input_control']="Wrong password.Try again.";
                    }
                  }
                  else{
                      $logs['input_control']="Wrong username or password.Try again.";
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

      <br>
      <div class="content">
          <br>
          <form action="" method="post" autocomplete="off" />
            <?php echo ($logs['input_control']) ? '<span style="color:#66ff99; size:20px;">'.$logs['input_control'].'</span><br>':''; ?>
            <?php echo ($logs['foot_note']) ? '<span style="color:#66ff99; size:20px;">'.$logs['foot_note'].'</span><br>':''; ?>
            <?php echo ($logs['useroremail']) ? '<span style="color:#66ff99; size:20px;">'.$logs['useroremail'].'</span><br>':''; ?>
            <input value="<?php echo ($_SESSION['useroremail']) ? $_SESSION['useroremail'] : '' ;?>" type="text" name="useroremail" placeholder="Username or email">
            <br>
            <?php echo ($logs['password']) ? '<span style="color:#66ff99; size:20px;">'.$logs['password'].'</span><br>':''; ?>
            <input value="<?php echo ($_SESSION['password']) ? $_SESSION['password'] : '' ;?>" type="password" name="psw" placeholder="Password">
            <br>
            <input type="submit" value="Log In" style="padding: 14px 30px; font-size:1.0em;">
          </form>
      </div>

  </div>
</body>
</html>
