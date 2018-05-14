<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="ASSESTS/login.css">
    <title>Page Title</title>
</head>
<body>

<div class="login-page">
    <div class="form">
        <form class="login-form" method="post">
            <input type="text" placeholder="username" name="username"/>
            <input type="password" placeholder="password" name="password"/>
            <button type="submit">login</button>
            <p class="message">Not registered? <a href="signup.php">Create an account</a></p>
        </form>
    <p>
        <?php
        session_start();
        function notification($notif){
            $notifications = [
                "0" => "Please enter valid email.",
                "1" => "Check Username or Password.",
                "2" => "Username exist, please try another one.",
                "3" => "Please fill in the blanks correctly."
            ];
            return $notifications["$notif"];
        }
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
        /* -----------------------------------------LOGIN------------------------------------------*/
        if($_POST){login();}
        function login(){
            $username = $_POST["username"];
            $password = $_POST["password"];
            if ($username && $password && username_check($username) && !password_check($password)){
                $conn = connection();
                $stmt= $conn->prepare("SELECT * FROM users WHERE username=? and passcode=?");
                $stmt->bind_param("ss",$username,$password);
                $stmt->execute();
                $query = $stmt->get_result();
                $data=$query->fetch_assoc();
                if ($data) {
                    cookie_control();
                    $_SESSION["username"] = $username;
                    header("Location: profile.php");
                    die();
                }
                else echo notification("1");
            } else {
                echo notification("3");
            }
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
    </p>
    </div>
</div>
</body>
</html>