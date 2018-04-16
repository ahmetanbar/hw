<?php
    function db_connect(){
        $servername = "localhost";
        $usrname = "username";
        $passwd = "password";
        $dbname = "myDB";
        $conn = mysqli_connect($servername, $usrname, $passwd, $dbname);
        if (!($conn))
        {
            die("Connection failed: " . mysqli_connect_error());
        }else{
            return $conn;
        }
    }
    function cookie_control()
    {
        if(!(empty($cookie))) {
            session_start();
            if($_SESSION["auth"] == "$cookie"){
                return True;
            }else{
                setcookie("auth", "", time() + 3600);
                session_destroy();
                return False;
            }
        }
    }
    $cookie=cookie_control();
    if($cookie==True){
        $username=$_SESSION["username"];
        $conn=db_connect();
        header("Location: ./index.php");
        die();
    }
?>
<html>
    <head>
        <meta charset="utf-8">
        <title>Login - Kaan ARI</title>
        <link rel="stylesheet" href="./assest/styles/styles_login.css">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    
    <body>
        <div class="wrapper">
            <header>
                <div  class="header"></div>
            </header>
            <div class="navbar">
                <ul>
                    <li><a href="./index.php">Home</a></li>
                    <li><a href="./archive.php">Archive</a></li>
                    <li><a href="./about.php">About</a></li>
                    <li><a href="./signup.php" style="cursor:pointer; float: right;">Sign Up</a></li> 
                    <li><a class="active" href="./login.php" style="float:right;">Login</a></li>
                </ul>
            </div>

            <div class="content">
                <div class="loginform">
                    <form style="align-item:center;" action="./loginvalid.php" method="POST">
                        <label><b>Username</b></label>
                        <input class="inp" placeholder="Enter Username" type="text" name="username" required>
                        <label><b>Password</b></label>
                        <input class="inp" placeholder="Enter Password" type="password" name"pwd" required>
                        <br>
                        <div style="display:block;">
                            <input style="height:15px; width:15px;" type="checkbox" name="stylgnin">
                            <span style="position:static;font-size:15px;">Keep me signed in</span>
                        </div>
                        
                        <input class="loginbtn" type="submit" value="LOGIN">
                    </form>
                </div>
            </div>
            <footer>
                <div  class="footer">
                    <center>
                        <ul>
                            <li><a id="in1" href="http://wwww.facebook.com/kaan.ari.tr"><img style="height:30px; width:30px;" src="./assest/img/face5.png"/></a></li>
                            <li><a id="in2" href="https://twitter.com/kaanaritr"><img style="height:30px; width:30px;" src="./assest/img/twitter6.png"/></a></li>
                            <li><a id="in3" href="https://www.tumblr.com/login?redirect_to=%2Fblog%2Fengineerofhctp"><img style="height:30px; width:30px;" src="./assest/img/tumblr5.png"/></a></li>
                        </ul>
                    </center>
                </div>
            </footer>
        </div>
    </body>
</html>