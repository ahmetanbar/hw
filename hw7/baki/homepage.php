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
            <button id="login-btn"   name="login-btn" type="submit" value="login-btn-v" >LOGIN </button>

            <input  id="register-input" name="username" type="text" placeholder="username"/>
            <input  id="register-input" name="email" type="text" placeholder="email"/>
            <input  id="register-input" name="password" type="password" placeholder="password"/>
            <input  id="register-input" name="passwordv" type="password" placeholder="password verify"/>
            <button id="register-btn"  name="register-btn" type="submit"  value="register-btn-v"> CREATE NOW! </button>

        </form>


        <?php
            $conn = new mysqli("localhost", "root", "","users");

        if(count($_POST)!=0){
            $username_sign = $_POST["username"];
            $mail_sign = $_POST["email"];
            $password_sign = $_POST["password"];
            $passwordv_sign = $_POST["passwordv"];


            if($username_sign != null and $mail_sign != null and $password_sign != null and $passwordv_sign != null){

                $state=$_POST["register-btn"];

                if($state =="register-btn-v")
                {
                    Signup();
                }

            }

            else{
                echo ("Please fill in the blanks correctly");
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

            $username_login = $_POST["username"];
            $password_login = $_POST["password"];

            if($password_login != null or $username_login != null){
                $read = $conn->query("SELECT id FROM users_table WHERE username='".$username_login."'");
                $list = mysqli_fetch_array($read);
                if(!empty($list)){
                    
                }
            }

        }

        ?>

    </div>

</div>

</body>
</html>


