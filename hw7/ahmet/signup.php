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
      function connect_db(){
        $servername = "localhost";
        $db_username = "root";
        $db_password = "";
        $db="hw7";
        $conn = new mysqli($servername, $db_username, $db_password,$db);
        mysqli_set_charset($conn,"utf8");
        return $conn;
      }

      function mb_ucfirst($string){
      return mb_strtoupper(mb_substr(mb_strtolower($string, 'UTF-8'), 0, 1)).mb_strtolower(mb_substr(mb_strtolower($string , 'UTF-8'), 1));
      }

      function generateRandomString($length = 52) {
          return substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($length/strlen($x)) )),1,$length);
      }

      function control_cookie(){
        if(count($_COOKIE)!=0 and array_key_exists("auth",$_COOKIE)){
          $auth= $_COOKIE['auth'];
          $conn = connect_db();
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
          if(array_key_exists("name",$_POST) and array_key_exists("surname",$_POST) and array_key_exists("email",$_POST) and array_key_exists("username",$_POST) and array_key_exists("psw",$_POST) and array_key_exists("gender",$_POST)){
            $logs=array("name"=>"","surname"=>"","email"=>"","username"=>"","password"=>"","foot_note"=>"","input_control"=>"","value_name"=>"","value_surname"=>"","value_email"=>"","value_username"=>"");
            if($_POST['name']!=NULL and $_POST['surname']!=NULL and $_POST['email']!=NULL and $_POST['username']!=NULL and $_POST['psw']!=NULL and $_POST['gender']!=NULL){
                $verify_cont=0;
                //name regular expression control
                $subject = $_POST['name'];
                $pattern = '/^[a-zA-ZçÇğĞıIiİöÖŞşÜü]{3,20}$/';
                if(preg_match($pattern,$subject)){
                  $verify_cont+=1;
                  $logs['value_name']=$subject;
                }
                else{
                  $logs['name']="Write a real name!";
                }
                //surname regular expression control
                $subject = $_POST['surname'];
                $pattern = '/^[a-zA-ZçÇğĞıIiİöÖŞşÜü]{2,20}$/';
                if(preg_match($pattern,$subject)){
                  $verify_cont+=1;
                  $logs['value_surname']=$subject;
                }
                else{
                  $logs['surname']="Write a real surname!";
                }
                //email regular expression control
                if(filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
                  $verify_cont+=1;
                  $logs['value_email']=$subject;
                }
                else{
                  $logs['email']="Write a valid email!";
                }
                //username regular expression control
                $subject = $_POST['username'];
                $pattern = '/^[a-zA-Z0-9_-]{3,20}$/';
                if(preg_match($pattern,$subject)){
                  $logs['value_username']=$subject;
                  $verify_cont+=1;
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
                  $verify_cont+=1;
                }
                else{
                  if(strlen($subject)>=10 and strlen($subject)<=30)
                  $logs['password']="Password must contain lowercase,uppercase,number!";
                  else if(strlen($subject)<10 or strlen($subject)>30)
                  $logs['password']="Password must has length of 10-30!";
                }
                // ----------------------after right input types-----------------//
                if($verify_cont==5){
                  $conn =connect_db();

                  $email=strtolower($_POST['email']);
                  $stmt = $conn->prepare("SELECT email FROM users WHERE email=?");
                  $stmt->bind_param("s", $email);
                  $stmt->execute();
                  $result = $stmt->get_result();
                  $row = $result->fetch_assoc();

                  if(count($row)==0){
                    $username=$_POST['username'];
                    $stmt = $conn->prepare("SELECT username,email FROM users WHERE username=?");
                    $stmt->bind_param("s", $username);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    $row = $result->fetch_assoc();
                    if(count($row)==0){
                      $name= mb_ucfirst($_POST['name']);
                      $surname=mb_ucfirst($_POST['surname']);
                      $password=$_POST['psw'];
                      $hashed_password = hash('sha512',$_POST['psw']);
                      $gender=$_POST['gender'];

                      $stmt = $conn->prepare("INSERT INTO users (name,surname,email,password,gender,username) VALUES(?,?,?,?,?,?)");
                      $stmt->bind_param("ssssss", $name, $surname,$email,$hashed_password,$gender,$username);
                      $stmt->execute();

                      $stmt = $conn->prepare("SELECT id FROM users WHERE username=?");
                      $stmt->bind_param("s", $username);
                      $stmt->execute();
                      $result = $stmt->get_result();
                      $row = $result->fetch_assoc();

                      $_SESSION['name']=$name; $_SESSION['surname']=$surname; $_SESSION['email']=$_POST['email']; $_SESSION['username']=$_POST['username'];

                      $auth=generateRandomString();
                      $user_id=$row["id"];
                      setcookie('auth',$auth);

                      $stmt = $conn->prepare("INSERT INTO cookie (auth,user_id) VALUES(?,?)");
                      $stmt->bind_param("si", $auth,$user_id);
                      $stmt->execute();
                      header("Location:home.php"); /* Redirect browser */
                    }
                    else{
                      $logs['input_control']="This username is already used.";
                    }
                  }
                  else{
                    $logs['input_control']="This email is already registered.Want to <a href=\"https://google.com\">Login</a>?";
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
      session_start();
      control_cookie();
      $logs=control_post();
  ?>
  <div class="topnav">
    <a href="home.php" style="padding-bottom: 0px; padding-top: 0px;"> <img  src='assets/image/logo.jpg' alt='photo of me' width="100" height="71" /> </a>
    <a href="./home.php">Home</a>
    <a href="#">Archive</a>
    <a href="https://google.com">About</a>
    <a style="float:right;" href="login.php">Log In</a>
  </div>

  <div class="main">
      <div class="header">
        <h1>Code Note</h1>
      </div>

      <br>
      <div class="content">
          <br>
          <h1>Join CodeNote</h1>

          <form action="" method="post" autocomplete="off" accept-charset="UTF-8" />
            <?php echo ($logs['input_control']) ? '<span style="color:#c30000;">'.$logs['input_control'].'</span><br>':''; ?>
            <?php echo ($logs['foot_note']) ? '<span style="color:#c30000;">'.$logs['foot_note'].'</span><br>':''; ?>
            <?php echo ($logs['name']) ? '<span style="color:#c30000;">'.$logs['name'].'</span><br>':''; ?>
            <?php echo ($logs['surname']) ? '<span style="color:#c30000;">'.$logs['surname'].'</span><br>':''; ?>
            <input value="<?php echo ($logs['value_name']) ? $logs['value_name'] : '' ;?>" style="width: 180px;" type="text" name="name" placeholder="Name"><input value="<?php echo ($logs['value_surname']) ? $logs['value_surname'] : '' ;?>" type="text" name="surname" placeholder="Surname" style="width: 180px;">
            <br>
            <?php echo ($logs['email']) ? '<span style="color:#c30000;">'.$logs['email'].'</span><br>':''; ?>
            <input value="<?php echo ($logs['value_email']) ? $logs['value_email'] : '' ;?>" type="text" name="email" placeholder="Phone or Email">
            <br>
            <?php echo ($logs['username']) ? '<span style="color:#c30000;">'.$logs['username'].'</span><br>':''; ?>
            <input value="<?php echo ($logs['value_username']) ? $logs['value_username'] : '' ;?>" type="text" name="username" placeholder="Username">
            <br>
            <?php echo ($logs['password']) ? '<span style="color:#c30000;">'.$logs['password'].'</span><br>':''; ?>
            <input type="password" name="psw" placeholder="Password">
            <br>
            <br><input type="radio" name="gender" value="male" style="font-size:1.2em;" checked> <label style="font-size: 18px;">Male</label>
            <input type="radio" name="gender" value="female"; ><label style="font-size: 18px;">Female</label> <br>
            <br>
            <input type="submit" value="Sign Up" style="padding: 14px 30px; font-size:1.0em;">
          </form>
      </div>
      <br>
      <br>
            <footer>Copyleft <span class="copy-left">©</span></footer>
  </div>
</body>
</html>
