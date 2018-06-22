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
             session_control();
           else
            header("Location:home.php");
        }
        else
          header("Location:home.php");
      }

      function session_control(){
        if(count($_SESSION)!=0){
          if(!array_key_exists("id",$_SESSION))
            header("Location:home.php");
        }
        else
          header("Location:home.php");
      }

      function get_control(){
        if(count($_GET)!=0){
          if(array_key_exists("state",$_GET)){
            if($_GET['state']=="account"){
              return "account";
            }
            else if($_GET['state']=="password"){
              return "password";
            }
            else
              header("Location:profile.php");
          }
          else
            header("Location:profile.php");
        }
      }

      function control_post(){
        if(count($_POST)!=0){
          if(array_key_exists("name",$_POST) and array_key_exists("surname",$_POST) and array_key_exists("email",$_POST) and array_key_exists("username",$_POST) and array_key_exists("psw",$_POST) and array_key_exists("gender",$_POST) and array_key_exists("about",$_POST)){
            $logs=array("name"=>"","surname"=>"","email"=>"","username"=>"","password"=>"", "about"=>"","foot_note"=>"","input_control"=>"","value_name"=>"","value_surname"=>"","value_email"=>"","value_username"=>"");
            if($_POST['name']!=NULL and $_POST['surname']!=NULL and $_POST['email']!=NULL and $_POST['username']!=NULL and $_POST['psw']!=NULL and $_POST['gender']!=NULL and $_POST['about']!=NULL){
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
                  $logs['value_email']=$_POST['email'];
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
                  $logs['password']="Wrong password!";
                }
                // ----------------------after right input types-----------------//
                if($verify_cont==5){
                  $verify_cont=0;
                  $conn =connect_db();

                  $email=strtolower($_POST['email']);
                  if($email!=$_SESSION['email']){
                    if(email_control($email)){
                      $verify_cont+=1;
                    }
                    else
                      $logs['email']="The email is already used.";
                  }
                  else
                    $verify_cont+=1;

                    $username=$_POST['username'];
                    if($username!=$_SESSION['username']){
                      if(username_control($username)){
                        $verify_cont+=1;
                      }
                      else
                        $logs['username']="The username is already used.";
                    }
                    else
                      $verify_cont+=1;

                      $password=$_POST['psw'];
                      if(password_control($password)){
                        $verify_cont+=1;
                      }
                      else
                        $logs['password']="Password is wrong!";

                      if($verify_cont=3){
                      $name= mb_ucfirst($_POST['name']);
                      $surname=mb_ucfirst($_POST['surname']);
                      $gender=$_POST['gender'];
                      $about=$_POST['about'];
                      $photo=$_POST['photo'];
                      $stmt = $conn->prepare("UPDATE users SET name=?, surname=?, email=?, gender=?, username=?, about=?, photo=? WHERE id=?");
                      $stmt->bind_param("ssssssss", $name, $surname,$email,$gender,$username,$about,$photo,$_SESSION['id']);
                      $stmt->execute();

                      $_SESSION['name']=$name; $_SESSION['surname']=$surname; $_SESSION['email']=$_POST['email']; $_SESSION['username']=$_POST['username']; $_SESSION['role']="";
                      $_SESSION['photo']=$photo; $_SESSION['about']=$about;
                      }

                      header("Location:profile.php"); /* Redirect browser */
                    }
            }
            else{
                $logs['foot_note']="Complete All of Them!";
            }
            return $logs;
          }
          // **************************
          else if(array_key_exists("psw1",$_POST) and array_key_exists("psw2",$_POST) and array_key_exists("psw3",$_POST)){
            $logs=array("name"=>"","surname"=>"","email"=>"","username"=>"","password_bottom"=>"","password_top"=>"","foot_note"=>"","input_control"=>"","value_name"=>"","value_surname"=>"","value_email"=>"","value_username"=>"");
            if($_POST['psw1']!=NULL and $_POST['psw2']!=NULL and $_POST['psw3']!=NULL){
              $verify_cont=0;

              $pattern='/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])[a-zA-Z0-9]{10,30}$/';
              if(preg_match($pattern,$_POST['psw1'])){
                $verify_cont+=1;
              }
              else
                $logs['password_top']="Password must contain lowercase,uppercase,number and has length of 10-30!";

              if($_POST['psw2']==$_POST['psw3']){
                if(preg_match($pattern,$_POST['psw2'])){
                  $verify_cont+=1;
                }
                else
                  $logs['password_bottom']="Password must contain lowercase,uppercase,number and has length of 10-30!";
              }
              else
                $logs['password_bottom']="Passwords aren't the same!";

              if($verify_cont==2){
                $pass_control=password_control($_POST['psw1']);
                if($pass_control){
                  pass_change($_POST['psw2']);
                  header("Location:profile.php");
                }
                else
                  $logs['password_top']="Wrong Password";
              }
            }
            else
              $logs['foot_note']="Complete All of Them!";
            return $logs;
          }
          // ***************************************
        }
      }
      function password_control($password){
        $conn = connect_db();
        $hashed_password=hash('sha512',$password);
        $stmt = $conn->prepare("SELECT * FROM users WHERE password=? and id=?");
        $stmt->bind_param("si", $hashed_password,$_SESSION['id']);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        if(count($row)!=0)
          return TRUE;
        else
          return FALSE;
      }

      function pass_change($password){
        $conn = connect_db();
        $hashed_password=hash('sha512',$password);

        $stmt = $conn->prepare("UPDATE users SET password=? WHERE id=?");
        $stmt->bind_param('si',$hashed_password,$_SESSION['id']);
        $stmt->execute();
      }

      function email_control($email){
        $conn = connect_db();
        $stmt = $conn->prepare("SELECT email FROM users WHERE email=?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        if(count($row)==0)
          return TRUE;
        else
          return FALSE;
      }

      function username_control($username){
        $conn = connect_db();
        $stmt = $conn->prepare("SELECT username FROM users WHERE username=?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        if(count($row)==0)
          return TRUE;
        else
          return FALSE;
      }



      session_start();
      control_cookie();
      $cookie_know=array("flag"=>TRUE);
      $state=get_control();
      $logs=control_post();
  ?>
  <?php include 'topnav.php';?>

  <div class="main">
      <div class="header">
        <h1>Code Note</h1>
      </div>

      <br>

          <br>
          <div class="topnav">
            <a <?php echo($state=="account") ? 'style="background-color: #DB3E1D; color: white;"':''; ?> href="./editprofile.php?state=account">Account</a>
            <a <?php echo($state=="password") ? 'style="background-color: #DB3E1D; color: white;"':''; ?> href="./editprofile.php?state=password">Password</a>
          </div>
          <div class="content">
          <form action="" method="post" autocomplete="off" accept-charset="UTF-8" />
            <?php if($state=="account"){?>
            <?php echo ($logs['input_control']) ? '<span style="color:#c30000;">'.$logs['input_control'].'</span><br>':''; ?>
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
            <!-- <?php echo ($logs['about']) ? '<span style="color:#c30000;">'.$logs['about'].'</span><br>':''; ?> -->
            <input value="<?php echo ($_SESSION['about']) ? $_SESSION['about'] : '' ;?>" type="text" name="about" placeholder="About">
            <br>
            <h3>Photo:
            <select name="photo">
              <option <?php echo($_SESSION['photo']=="james") ? 'selected':'' ?> value="james">James</option>
              <option <?php echo($_SESSION['photo']=="dennis") ? 'selected':'' ?> value="dennis">Dennis</option>
              <option <?php echo($_SESSION['photo']=="linus") ? 'selected':'' ?> value="linus">Linus</option>
              <option <?php echo($_SESSION['photo']=="morgan") ? 'selected':'' ?> value="morgan">Morgan</option>
              <option <?php echo($_SESSION['photo']=="rasmus") ? 'selected':'' ?> value="rasmus">Rasmus</option>
            </select></h3>

            <?php echo ($logs['password']) ? '<span style="color:#c30000;">'.$logs['password'].'</span><br>':''; ?>
            <input type="password" name="psw" placeholder="Password">
            <br>
            <br><input type="radio" name="gender" value="male" style="font-size:1.2em;" checked> <label style="font-size: 18px;">Male</label>
            <input type="radio" name="gender" value="female"; ><label style="font-size: 18px;">Female</label> <br>
            <br>
            <input type="submit" value="Save" style="padding: 14px 30px; font-size:1.0em;">
          <?php } ?>
          <?php if($state=="password"){?>
            <?php echo ($logs['password_top']) ? '<span style="color:#c30000;">'.$logs['password_top'].'</span><br>':''; ?>
            <input type="password" name="psw1" placeholder="Existing password"><br>
            <?php echo ($logs['password_top']) ? '<span style="color:#c30000;">'.$logs['password_bottom'].'</span><br>':''; ?>
            <input type="password" name="psw2" placeholder="New password"><br>
            <input type="password" name="psw3" placeholder="Verify new password"><br>
            <input type="submit" value="Save" style="padding: 14px 30px; font-size:1.0em;">
          <?php } ?>
          </form>
      </div>
      <br>
      <br>
            <footer><a href="https://github.com/ahmetanbar"><img src='assets/image/github-logo.png' alt='photo of me' width="35" height="35" ></a><br>Copyleft<span class="copy-left">©</span></footer>
  </div>
</body>
</html>
