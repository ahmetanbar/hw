<?php
    function random_key($str_length = 24)
    {
        $chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $bytes = openssl_random_pseudo_bytes(3*$str_length/4+1);
        $repl = unpack('C2', $bytes);
        $first  = $chars[$repl[1]%62];
        $second = $chars[$repl[2]%62];    
        return strtr(substr(base64_encode($bytes), 0, $str_length), '+/', "$first$second");
    }

    function cookie_set($username)
    {
        session_start();
        $cookie=random_key();
        $_SESSION["auth"] = "$cookie";
        $_SESSION["username"]="$username";
        setcookie("auth","$cookie", time()+3600);    
    }

    function valid_pass($pwd) 
    {
        $pwd = preg_replace ("/ +/", "", $pwd); # convert all multispaces to space
        $r1='/[A-Z]/';  //Uppercase
        $r2='/[a-z]/';  //lowercase
        $r3='/[!@#$%^&*()\-_=+{};:,<.>]/';  // whatever you mean by 'special char'
        $r4='/[0-9]/';  //numbers
        if(preg_match_all($r1,$pwd, $o)<1) return FALSE;
        if(preg_match_all($r2,$pwd, $o)<1) return FALSE;
        if(preg_match_all($r3,$pwd, $o)<1) return FALSE;
        if(preg_match_all($r4,$pwd, $o)<1) return FALSE;
        if(strlen($pwd)<8) return FALSE;
        return TRUE;
    }

    function valid_username($name)
    {
        $name = preg_replace ("/ +/", "", $name); # convert all multispaces to space
        $r3='/[!@#$%^&*()\-_=+{};:,<.>ıüğşçö]/';  // whatever you mean by 'special char'
        if(preg_match_all($r3,$name, $o)>0) return FALSE;
        if(strlen($name)<5) return FALSE;
        return TRUE;
    }
    function db_connect(){
        $servername = "localhost";
        $usrname = "root";
        $passwd = "";
        $dbname="deneme";
        $conn = mysqli_connect($servername, $usrname, $passwd,$dbname);
        if (!$conn) {
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

    if($_POST){
        login();
    }else{
        $cookie=cookie_control();
        if($cookie==True){
            $username=$_SESSION["username"];
            $conn=db_connect();
            header("Location: ./index.php");
            die();
        }
    }
?>
<html>
    <head>
        <meta charset="utf-8">
        <title>Login - Kaan ARI</title>
        <link rel="stylesheet" href="./assest/styles/styles_signup.css">
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
                <form style="" action="./login.php" method="POST">
                <div class="form1">
                        <label><center><b style="color:darkred;">Account Information:</b></center></label><br>
                        <label><b>Username <span style="color:darkred;" required>(*)</span></b> </label>
                        <input class="inp" type="text" name="username" required>
                        <label><b>Password <span style="color:darkred;">(*)</span></b></label>
                        <input class="inp" type="password" name="pwd">
                        <label><b>Retype Password <span style="color:darkred;" required>(*)</span></b></label>
                        <input class="inp" type="text" name="repwd">
                        <label><b>E-mail <span style="color:darkred;" required>(*)</span></b></label>
                        <input class="inp" type="email" name="mail">
                        <br>
                        
                        
                </div>
                <hr class="a">
                <div class="form1">
                        <label><center><b style="color:darkred;">Personal Information:</b></center></label><br>
                        <label><b>Name <span style="color:darkred;">(*)</span></b></label>
                        <input class="inp" type="text" name="name">
                        <label><b>Surname <span style="color:darkred;">(*)</span></b></label>
                        <input class="inp" type="text" name="surname" required>
                        <label><b>Birthday <span style="color:darkred;">(*)</span></b></label>
                        <input placeholder="Enter Date of Birth" class="inp" type="text" onfocus="(this.type='date')" onblur="(this.type='text')" id="date" required>
                        <label><b>Tel Number <span style="color:darkred;"></span></b></label>
                        <input class="inp" type="text" name="usrtel">
                        <label><b>Country</b></label>
                        <input class="inp" type="text" name="username">                        
                        <br>
                        
                        
                </div>
                <hr class="a">
                <div class="form1">
                        <label><center><b style="color:darkred;">Additional Information:</b></center></label><br>
                        <label><b>Profile Photo</b></label>
                        <center><div style="border-radius:10px;margin-top:10px;height:175px;width:150px;overflow:hidden;"><img src="./assest/img/header.jpg"></div></center><br>
                        <center><label class="uploadbtn" for="ppimg">Browse...</label></center>
                        <input style="z-index:-1; position:absolute; opacity:0;" type="file" name="ppimg" id="ppimg" accept=".jpg, .jpeg, .png">
                        <input class="sgninbtn" type="submit" value="LOGIN">
                        <br>
                        
                </div>
                </form>
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