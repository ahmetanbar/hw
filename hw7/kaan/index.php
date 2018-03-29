<html>

    <head>
        <title>Ana Sayfa</title>
        <link rel="stylesheet" href="style.css">
        <meta charset="utf-8">
    </head>
    <?php
        $baglanti = @mysql_connect('localhost', 'kaanari1_kaan', 'hwworld');
        $veritabani = @mysql_select_db('kaanari1_hw1');


        function cookie()
        {
            $cookie=$_COOKIE["auth"];
            $read = mysql_query("SELECT userid FROM cookie WHERE auth='".$cookie."'");
            $list = mysql_fetch_array($read); 
            if(empty($list)){
                setcookie("auth","", time()-3600);          
            }else{
                header("Location: ./profile.php?profile=$list[0]");
            }
        }
    
        function kayit()
        {
            if(empty($_POST["username"]) or empty($_POST["pwd"]) or empty($_POST["name"]) or empty($_POST["surname"]) or empty($_POST["email"])){
                echo ("<script type='text/javascript'>  alert('Please fill all the blanks'); </script>"); 

            }else{
                $username=$_POST["username"];
                $pwd=password_hash($_POST["pwd"], PASSWORD_DEFAULT);
                $name=$_POST["name"];
                $surname=$_POST["surname"];
                $email=$_POST["email"];
                $read = mysql_query("SELECT id FROM users WHERE username='".$username."'");
                $list = mysql_fetch_array($read);
                if(empty($list))
                {
                    mysql_query("INSERT INTO users (username, pwd,names,surname,email) VALUES ('$username', '$pwd', '$name', '$surname', '$email')");
                    $auth=random_key();
                    $read = mysql_query("SELECT id FROM users WHERE username='".$username."'");
                    $list = mysql_fetch_array($read);
                    $userid=$list[0];
                    mysql_query("INSERT INTO cookie (userid, auth) VALUES ('$userid', '$auth')");
                    setcookie("auth","$auth", time()+3600);
                    header("Location: ./profile.php?profile=$userid");
                }else{
                    echo ("<script type='text/javascript'>  alert('$username is already exist.'); </script>"); 
                }
            }
        }

        function giris()
        {
            if(!(empty($_POST["username"]))){
                $pwd=password_hash($_POST["pwd"], PASSWORD_DEFAULT);
                $read = mysql_query("select id,username,pwd from users where username=? and password=?",$_POST["username"],$pwd);
                $list = mysql_fetch_array($read);
                if(empty($list)){
                    echo ("<script type='text/javascript'>  alert('Wrong Username or Password'); </script>"); 
                }else{
                    $read = mysql_query("select id,userid,keys from cookie where userid=?",$list[0]);
                    $list = mysql_fetch_array($read); 
                    if(empty($list)){
                        $auth=random_key();
                        mysql_query("INSERT INTO cookie (userid, auth) VALUES ('$list[0]', '$auth')");
                        setcookie("auth","$auth", time()+3600);
                        header("Location: ./profile.php?profile=$key");
                    }else{
                        $auth=random_key();
                        mysql_query("UPDATE cookie SET auth=$auth WHERE userid=$list[0]");
                        setcookie("auth","$auth", time()+3600);
                        header("Location: ./profile.php?profile=$userid");
                    }
                
                }
            }else{
                echo("<script type='text/javascript'>  alert('Enter Username and Password'); </script>"); 
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
        echo($_COOKIE["auth"]);

        $status=$_POST["type"];
        if(empty($_COOKIE["auth"])){
            if(empty($status)){

        
            } else{
                if($status=="Login"){ //Üye girişi varsa
                    giris();
                }
                if($status=="Signup"){ //Kayıt varsa

                    kayit();
                } else{
                    http_response_code(400);
                }
            }
        }else{
            cookie();
        }
    ?> 


    <body>
        <div class="nav">
            <header>
                <nav>
                    <ul>
                        <li><a href="./index.php">Home</a></li>
                        <li><a href="./profile.php">Profile</a></li>
                    </ul>    
                </nav>
            </header>
            
        </div>
        <center><h2 class="text">Login or Signup</h2></center>
        <div style="margin:auto;width:80%;margin-top:5%;">
            <div class="box" style="margin-top:35px;float:left;padding-top:7%; height:32.5%;min-height:150px;margin-right:35%;">
                <form action="./index.php?process=2" method="post">
                    <center>
                        <label>Username</label><br>
                        <input class="textbox" type="text" name="username"><br>
                        <label>Password</label><br>
                        <input class="textbox" type="password" name="pwd"><br>
                        <input class="button" type="submit" name ="type" value="Login">
                    </center>
                </form>
            </div>
            <div class="box" style="float:right;">
                    <form action="./index.php" method="post">
                        <center>
                            <label>Name</label><br>
                            <input class="textbox" type="text" name="name"><br>
                            <label>Surname</label><br>
                            <input class="textbox" type="text" name="surname"><br>
                            <label>E-Mail</label><br>
                            <input class="textbox" type="text" name="email"><br>
                            <label>Username</label><br>
                            <input class="textbox" type="text" name="username"><br>
                            <label>Password</label><br>
                            <input class="textbox" type="password" name="pwd"><br>
                            <input class="button" type="submit" name="type" value="Signup"><br>
                        </center>
                    </form>
                </div>
        </div>

    </body>
