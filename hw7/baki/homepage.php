<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" type="text/css" href="homepage.css">

    <meta charset="UTF-8">
    <title>Soceanic</title>
</head>
<body>



<div class="home-page1">

    <video autoplay muted loop id="myVideo">
        <source src="b-video.mp4" type="video/mp4">
    </video>

    <div class="form" >
        <form method="post">

            <input  id="login-input" name="username_login" type="text"     placeholder="username"/>
            <input  id="login-input" name="password_login" type="password" placeholder="password"/>
            <button id="login-btn"   name="btn" type="submit" value="login-btn-v" >LOGIN </button>

                <input  id="register-input" name="username" type="text" placeholder="username"/>
            <input  id="register-input" name="email" type="text" placeholder="email"/>
            <input  id="register-input" name="password" type="password" placeholder="password"/>
            <input  id="register-input" name="passwordv" type="password" placeholder="password verify"/>
            <button id="register-btn"  name="btn" type="submit"  value="register-btn-v"> CREATE NOW! </button>

        </form>


        <?php
            $conn = new mysqli("localhost", "root", "","users");

        if(count($_POST)!=0){
            $username_sign = $_POST["username"];
            $mail_sign = $_POST["email"];
            $password_sign = $_POST["password"];
            $passwordv_sign = $_POST["passwordv"];

            $username_login = $_POST["username_login"];
            $password_login = $_POST["password_login"];

            $state=$_POST["btn"];

            if($state =="register-btn-v")
            {

                if($username_sign != null or $mail_sign != null or $password_sign != null or $passwordv_sign != null){

                    Signup();

                }

                else{
                    echo ("Please fill in the blanks correctly");
                }
            }

            if($state == "login-btn-v")
            {

                if($username_login != null or $password_login != null){
                    Login();
                }

                else{
                    echo ("Please fill in the blanks correctly");
                }
            }


        }

        function cookie()
        {
            $conn = new mysqli("localhost", "root", "","users");
            $cookie=$_COOKIE["auth"];
            $read = $conn->query("SELECT user_id FROM cookies WHERE cookie='".$cookie."'");
            $list = mysqli_fetch_array($read);
            if(empty($list)){
                setcookie("auth","", time()-3600);
            }else{
                header("Location: ./profile.php?profile=$list[0]");
            }
        }


        function Signup()
        {
            $conn = new mysqli("localhost", "root", "","users");

            $username_sign = $_POST["username"];
            $mail_sign = $_POST["email"];
            $password_sign = $_POST["password"];
            $passwordv_sign = $_POST["passwordv"];


            $read = $conn->query("SELECT id FROM users_table WHERE username='".$username_sign."'");
            $list = mysqli_fetch_array($read);

            if($passwordv_sign == $password_sign and empty($list))
            {

                $conn->query("INSERT INTO users_table (username,pwd,mail) VALUES('$username_sign','$password_sign','$mail_sign')");

                echo ("REGISTERING IS SUCCESSFUL !");
            }
            else if (!empty($list)){
                echo ("USER ALREADY EXIST");
            }
            else
            {
                echo ("PASSWORDS ARE DIFFERENT");
            }

        }

        function Login()
        {
            $conn = new mysqli("localhost", "root", "","users");

            $username_login = $_POST["username_login"];
            $password_login = $_POST["password_login"];

            if(!empty($password_login) and !empty($username_login)){
                $read = $conn->query("SELECT * FROM users_table WHERE username='".$username_login."'");
                $list = mysqli_fetch_array($read);
                $user_id = $list[0];
                if($password_login == $list[2]){

                    $read = $conn->query("select * from cookies where user_id='".$user_id."'");
                    $list = mysqli_fetch_array($read);

                    if(empty($list)){

                    $auth=random_key();
                    $conn->query("INSERT INTO cookies (user_id, cookie) VALUES ('$list[1]', '$auth')");
                    setcookie("auth","$auth", time()+3600);
                    header("Location: ./profile.php?id=$user_id");

                    }else{

                        $auth=random_key();
                        $conn->query("UPDATE cookies SET cookie=$auth WHERE user_id=$list[1]");
                        setcookie("auth","$auth", time()+3600);
                        header("Location: ./profile.php?profile=$user_id");

                    }

//                    $auth=random_key();
//                    $conn->query("INSERT INTO cookies (user_id, cookie) VALUES ('$list[0]', '$auth')");
//                    setcookie("auth","$auth", time()+3600);
//                    header("Location: ./profile.php?id=$userid");
                }
                else{
                    echo ("Password is wrong !");
                }
            }
            else{
                echo ("Please check in the blanks");
            }

        }

        function random_key($str_length = 24)
        {
            $chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $bytes = openssl_random_pseudo_bytes(3*$str_length/4+1);
            $repl = unpack('C2', $bytes);
            $first  = $chars[$repl[1]%62];
            $second = $chars[$repl[2]%62];

            return strtr(substr(base64_encode($bytes), 0, $str_length), '+/', "$first$second");
        }


        ?>

    </div>

</div>

</body>
</html>


