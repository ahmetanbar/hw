<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" type="text/css" href="ASSESTS/STYLE/login.css">

    <meta charset="UTF-8">
    <title>Socean</title>
</head>
<body>
<h1 style="font-family: -apple-system,sans-serif">Turn back to <a href="index.php" style="color: #a94442">Socean</a></h1>
<div class="form" >
    <form method="post">
        <input  id="login-input" name="username" type="text"     placeholder="username"/>
        <input  id="login-input" name="password" type="password" placeholder="password"/>
        <button id="login-btn"   name="btn" type="submit" >LOGIN </button>
        <a>Haven't you any account? </a><a href="signup.php" style="color: #1f648b;font-family: -apple-system,sans-serif;text-decoration: none">Signup</a>
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
        /* -------------------------------------USER ACTİVATE--------------------------------------*/
        function state($username){
            $conn = connection();
            $read = $conn->query("SELECT * FROM users WHERE username='".$username."'");
            $list = mysqli_fetch_array($read);
            $state = $list["state"];
            if($state == 0){
                echo "user";
                return 0;
            }
                else if($state == 1){
                echo "admin";
                return 1;
                }
                else if($state == 2){
                    echo "soft deleted";
                    return 2;
                }
                else if($state == 3){
                    echo "hard deleted";
                    return 3;
                }
        }

        /* ---------------------------------------RE-ACTIVATE-------------------------------------*/
        if(isset($_GET["active_user"])){
            $_SESSION["username"] = $_GET["active_user"];
            re_activate($_SESSION["username"]);
        }
        function re_activate($username){
            $active = null;
            $state = 0;
            echo $username;
            $conn = connection();
            $stmt = $conn->prepare("UPDATE users SET active=?,state=? WHERE username=?");
            $stmt->bind_param('sis',$active,$state,$username);
            $stmt->execute();
            $_SESSION["username"] = $username;
            echo $_SESSION[$username];
            header("Location: index.php");
            die();
        }
        /* -----------------------------------------LOGIN------------------------------------------*/
        if($_POST){
            login();
        }


        function login(){
            $username = $_POST["username"];
            $password = sha1($_POST["password"]);

            if ($username && $password && username_check($username) && !password_check($password) && state($username) != 3){
                $conn = connection();
                $stmt= $conn->prepare("SELECT * FROM users WHERE username=? and passcode=?");
                $stmt->bind_param("ss",$username,$password);
                $stmt->execute();
                $query = $stmt->get_result();
                $data=$query->fetch_assoc();
                if ($data) {
                    if(state($username)){
                        $_SESSION["username"] = $username;
                        $_SESSION["password"] = $password;
                        re_activate($username);
                        header("Location: index.php");
                        die();
                    }
                    echo "<br>";
                    echo "YOUR ACCOUNT WAS DELETED";
                    ?>
                    <?php
                }
                else echo notification("1");
            } else {
                echo notification("3");
            }
        }
        ?>

    </p>

</div>
<div class="footer">
    Copyright © 2018 Designed by Baki Almacı
</div>

</body>
</html>