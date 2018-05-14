<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="signup.css">
    <title>Page Title</title>
</head>
<body>

<div class="login-page">
    <div class="form">
        <form class="register-form" method="post">
            <input type="text" placeholder="username" name="username"/>
            <input type="password" placeholder="password" name="password"/>
            <input type="text" placeholder="email address" name="email"/>
            <button type="submit"> Create Now !</button>
            <p class="message">Already registered? <a href="login.php">Sign In</a></p>
        </form>
    </div>
</div>
<?php
session_start();
/* ------------------------------------DATABASE CONNECTION----------------------------*/
function connection(){
    $server_name = "localhost";
    $username = "root";
    $password = "";
    $db_name="blog";
    $conn = mysqli_connect($server_name, $username, $password,$db_name);
    mysqli_set_charset($conn,"utf8");
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
    else{
        return $conn;
    }
}
/* --------------------------------------KEY GENERATOR------------------------------ */
function key_generate($length) {
    $chars = array_merge(range(0,9), range('a','z'), range('A', 'Z'));
    $chars = implode("", $chars);
    return substr(str_shuffle($chars), 0, $length);
}
/* --------------------------------------PASSWORD CHECK--------------------------------*/
function password_check($password){
    $case1='/[A-Z]/';
    $case2='/[a-z]/';
    $case3='/[!@#$%^&()\-_=+{};:,<.>"|]/';
    $case4='/[0-9]/';
    if(preg_match_all($case1,$password, $o)<1) return null;
    if(preg_match_all($case2,$password, $o)<1) return null;
    if(preg_match_all($case3,$password, $o)>0) return null;
    if(preg_match_all($case4,$password, $o)<1) return null;
    if(strlen($password)<6) return null;
    return 1;
}
/* --------------------------------------USERNAME CHECK-----------------------------------*/
function username_check($username){
    $username = preg_replace ("/ +/", "", $username);
    $case1='/[!@#$%^&*()\-_=+{};:,<.>ıüğşçö]/';
    if(preg_match_all($case1,$username, $o)>0) return null;
    if(strlen($username)<5) return null;
    return 1;
}
/* ---------------------------------------EMAIL CHECK--------------------------------------*/
function email_check($email){
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return 1;
    }
    else return null;
}
/* -----------------------------------------SIGN UP------------------------------------------*/
if($_POST){signup();}
function signup(){
    $username = $_POST["username"];
    $password = $_POST["password"];
    $email    = $_POST["email"];
    if ($username && $password && username_check($username) && !password_check($password) && email_check($email)){
        if (!member_control()) {
            cookie_control();
            $_SESSION["username"] = $username;
            $conn = connection();
            $conn->query("INSERT INTO users (username, passcode,email) VALUES ('$username', '$password','$email')");
            header("Location: profile.php");
            die();
        }
        else echo "Username Exist !";
    } else echo "Fill in the blanks and Give importance <br> Username & Password Standarts.";
}
/* ---------------------------------------MEMBER CONTROL---------------------------------*/
function member_control(){
    $username = $_POST["username"];
    $conn = connection();
    $stmt= $conn->prepare("SELECT * FROM users WHERE username=?");
    $stmt->bind_param("s",$username);
    $stmt->execute();
    $query = $stmt->get_result();
    $data=$query->fetch_assoc();
    return $data;
}
/*---------------------------------------- COOKIE SETTINGS---------------------------------------*/
function cookie_control() {
    $conn = connection();
    $username = $_POST["username"];

    $read = $conn->query("SELECT * FROM users WHERE username='".$username."'");
    $list = mysqli_fetch_array($read);
    $userid = $list[0];

    $read = $conn->query("SELECT * FROM auth WHERE user_id='".$userid."'");
    $list = mysqli_fetch_array($read);
    $userid_auth = $list[0];

    if(!$userid_auth) {
        $auth = key_generate(32);
        $conn->query("INSERT INTO auth (user_id, cookie) VALUES ('$userid', '$auth')");
        setcookie("auth", "$auth", time() + 3600);
    }
}
?>
</body>
</html>