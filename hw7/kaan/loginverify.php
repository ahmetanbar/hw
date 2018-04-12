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

    function cookie_set()
    {
        session_start();
        $cookie=random_key();
        $_SESSION["auth"] = "$cookie";
        setcookie("auth","$cookie", time()+3600);    
    }

    function valid_pass($pwd) 
    {
        $pwd = preg_replace ("/ +/", "", $pwd); # convert all multispaces to space
        $r1='/[A-Z]/';  //Uppercase
        $r2='/[a-z]/';  //lowercase
        $r3='/[!@#$%^&*()\-_=+{};:,<.>]/';  // whatever you mean by 'special char'
        $r4='/[0-9]/';  //numbers
        if(preg_match_all($r1,$pwd, $o)<2) return FALSE;
        if(preg_match_all($r2,$pwd, $o)<2) return FALSE;
        if(preg_match_all($r3,$pwd, $o)<2) return FALSE;
        if(preg_match_all($r4,$pwd, $o)<2) return FALSE;
        if(strlen($password)<8) return FALSE;
        return TRUE;
    }

    function valid_username($name)
    {
        $name = preg_replace ("/ +/", "", $name); # convert all multispaces to space
        $r1='/[A-Z]/';  //Uppercase
        $r2='/[a-z]/';  //lowercase
        $r3='/[!@#$%^&*()\-_=+{};:,<.>]/';  // whatever you mean by 'special char'
        $r4='/[0-9]/';  //numbers
        if(preg_match_all($r1,$pwd, $o)<2) return FALSE;
        if(preg_match_all($r2,$pwd, $o)<2) return FALSE;
        if(preg_match_all($r3,$pwd, $o)>0) return FALSE;
        if(preg_match_all($r4,$pwd, $o)<2) return FALSE;
        if(strlen($password)<5) return FALSE;
        return TRUE;
    }

    $servername = "localhost";
    $username = "username";
    $password = "password";
    $dbname = "myDB";
    $username=$_POST["username"]
    $password=$_POST["pwd"]
    $cookieset=$_POST["stylgnin"]

    if(!(valid_username($username)))
    {
        header("Location: ./login.php?check=1");
        die();
    }

    if(!(valid_pass($password)))
    {
        header("Location: ./login.php?check=2");
        die();
    }
    
    $conn = mysqli_connect($servername, $username, $password, $dbname);
    
    if (!$conn) 
    {
        die("Connection failed: " . mysqli_connect_error());
    }

    $query="SELECT id,pwd FROM users WHERE username LIKE '" . mysqli_escape_string($username) . "'";
    $result = mysqli_query($conn, $query);
    
    if(empty($result))
    {
        header("Location: ./login.php?check=3");
        die();
    }else
    {
        if(password_verify($password,$result[1]))
        {
            header("Location: ./index.php?id=$result[0]");
            if(isset($cookieset))
            {
                cookie_set();
            }
            die();

        }else
        {
            header("Location: ./login.php?check=4");
            die();
        }
    }
?>