<html>
<head>
  <link rel="stylesheet" type="text/css" href="./index.css">
  <meta charset="UTF-8"/>

<?php
$servername = "localhost";
$username = "root";
$password = "";
$db="hw7";
try{
$conn = new mysqli($servername, $username, $password,$db);
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
else{
}
}
catch(Exception $e) {
echo 'Message: ' .$e->getMessage();
}
?>
</head>
<body>
  <?php
  function generateRandomString($length = 52) {
    return substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($length/strlen($x)) )),1,$length);
  }
    if(count($_COOKIE)!=0){
    $key_id= $_COOKIE['key_id'];
    $user_id= $_COOKIE['user_id'];
    $sql = "SELECT key_id,user_id FROM cookie WHERE key_id='$key_id' AND user_id='$user_id'";
    $result = $conn->query($sql) or die($conn->error);
    $row = $result->fetch_assoc();
    if(count($row)!=0)
    {
      header("Location:profile.php"); /* Redirect browser */
    }
  }

  function login_verify() {
    $servername = "localhost";
    $username = "root";
    $password = "";
    $db="hw7";
    try{
    $conn = new mysqli($servername, $username, $password,$db);
    if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
    }
  }
  catch(Exception $e) {
 echo 'Message: ' .$e->getMessage();
}
    if(count($_POST)!=0){
    try{
      if(array_key_exists("emailorphone",$_POST) or array_key_exists("password_2",$_POST)){
        if($_POST['emailorphone']==NULL or $_POST['password_2']==NULL){
          echo "Complete all of them!!cCc";
        }
        else{
          $email=$_POST['emailorphone'];
          $password=$_POST['password_2'];
          $sql = "SELECT email,parola,id FROM users WHERE email='$email' AND parola='$password'";
          $result = $conn->query($sql) or die($conn->error);
          $row = $result->fetch_assoc();
          if(count($row)!=0){
            $key_id=generateRandomString();
            $user_id=$row["id"];
            setcookie('key_id',$key_id);
            setcookie('user_id',$user_id);
            $sql2 = "INSERT INTO cookie (key_id,user_id) VALUES('$key_id','$user_id')";
            if ($conn->query($sql2) === TRUE) {
            echo("succesful");
            }
            else{
              echo("unsuccessful");
            }
            header("Location:profile.php"); /* Redirect browser */
        }
        else{
          echo "Wrong password or username";
        }
      }
    }
  }
  catch(Exception $e){
echo 'Message: ' .$e->getMessage();
  }
  try{
    if(array_key_exists("name",$_POST) or array_key_exists("surname",$_POST) or array_key_exists("psw",$_POST) or array_key_exists("email",$_POST) or array_key_exists("username",$_POST)){
      if($_POST['name']==NULL or $_POST['surname']==NULL or $_POST['psw']==NULL or $_POST['email']==NULL or $_POST['username']==NULL){
        echo("Complete all of block!!!cCc");
      }
      else{
   	    $email=$_POST['email'];
        $username=$_POST['username'];
        $flag_signup=null;
        $sql = "SELECT email,username FROM users WHERE email='$email' AND username='$username'";
        $result = $conn->query($sql) or die($conn->error);
        $row = $result->fetch_assoc();
        // if ($conn->query($sql) === TRUE) {
        //   $flag_signup=True;
        // }
        if(count($row)==0){
          $name=$_POST['name'];
     	    $surname=$_POST['surname'];
          $password=$_POST['psw'];
          $gender=$_POST['gender'];
          $sql = "INSERT INTO users (name,surname,email,parola,gender,username) VALUES('$name','$surname','$email','$password','$gender','$username')";
          if ($conn->query($sql) === TRUE) {
            $sql = "SELECT id FROM users WHERE username='$username'";
            $result = $conn->query($sql) or die($conn->error);
            $row = $result->fetch_assoc();
            echo $row['id'];
            $key_id=generateRandomString();
            $user_id=$row["id"];
            setcookie('key_id',$key_id);
            setcookie('user_id',$user_id);
            $sql = "INSERT INTO cookie (key_id,user_id) VALUES('$key_id','$user_id')";
            if ($conn->query($sql) === TRUE) {
            }
            header("Location:profile.php"); /* Redirect browser */
          }
          else{
            echo "accured a error!!!cCc";
          }
        }
        else{
          echo "we have already the username or mail";
        }
      }
    }
    else if(!array_key_exists("emailorphone",$_POST) and !array_key_exists("gender",$_POST)){
      echo "bad connected";
    }
    }
    catch(Exception $e){
    }
}
}
  login_verify();
  ?>

<div>
<header>
  <h1>What About?</h1>
</header>
<div>
  <article>
    <form action="" method="post">
    <input style="width: 350px;" type="text" name="emailorphone" placeholder="Phone or Email"><input type="password" name="password_2" placeholder="Password" style="width: 350px;">
    <br>
    <input type="submit" value="Login" style="padding: 16px 32px; font-size:1.5em;">
  </form>
  </article>

</div>
<div>
<article>
  <form action="" method="post">
  <input style="width: 240px;" type="text" name="name" placeholder="Name"><input type="text" name="surname" placeholder="Surname" style="width: 240px;">
  <br>
  <input type="text" name="email" placeholder="Phone or Email">
  <br><input type="text" name="username" placeholder="Username">
  <br><input type="password" name="psw" placeholder="Password">
  <br><br>
  <br><input type="radio" name="gender" value="male" style="font-size:1.5em;" checked> <label style="font-size: 30px;">Male</label>
  <input type="radio" name="gender" value="female"; ><label style="font-size: 30px;">Female</label> <br>
  <br><br>
  <input type="submit" value="Sign Up" style="padding: 16px 32px; font-size:1.5em;">
</form>
</article>
<footer>Copyright &copy; BAK Software</footer>
</div>
</div>
</body>
</html>
