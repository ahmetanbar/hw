<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" type="text/css" href="ASSESTS/STYLE/profilepage.css">

    <meta charset="UTF-8">
    <title>Socean</title>
</head>
<body>
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
/* --------------------------------------------------------------------------------------*/
if(isset($_SESSION["username"])){
    $username = $_SESSION["username"];
}
else{
    $username="";
    echo "Please Login. </br> <b>Redirecting...</b>";
    header( "refresh:0;url=index.php" );
}
?>

<div class="banner-text">

    <p>
        WE'VE KNEW YOU WOULD COME HERE
    </p>

    <form action="login.php">
        <button id="login-btn"  name="btn" type="submit"  value="btn"> LOGIN </button>
    </form>

    <form action="signup.php">
        <button id="signup-btn"  name="btn" type="submit"  value="btn"> SIGNUP </button>
    </form>

    <div id="social">
        <a href="http://facebook.com/bakialmaci">
            <img src="ASSESTS/STYLE/MEDIA/facebook.png" alt="fb" height="40" width="40" >
        </a>

        <a href="http://twitter.com/baki_almaci">
            <img src="ASSESTS/STYLE/MEDIA/twitter.png" alt="tw" height="40" width="40">
        </a>

        <a href="http://instagram.com/bakialmaci">
            <img src="ASSESTS/STYLE/MEDIA/instagram.png" alt="ins" height="40" width="40">
        </a>

        <a href="http://github.com/bakialmaci">
            <img src="ASSESTS/STYLE/MEDIA/gh.png" alt="gh" height="40" width="40">
        </a>
    </div>
</div>

<div class="banner">
    <a href="index.php" style="text-decoration: none;"> <button id="btn" name="btn" type="submit" value="btn"> HOMEPAGE </button> </a>
    <a href="posted.php" style="text-decoration: none;"> <button id="btn"  name="btn" type="submit"  value="btn"> POSTED </button> </button> </a>
    <a href="contact.php" style="text-decoration: none;"> <button id="btn" name="btn" type="submit" value="btn"> CONTACT </button> </a>

</div>

<div class="menu">
    <ul>
        <li><a href="PAGES/arduino.php">ARDUINO</a></li>
        <li><a href="PAGES/arm.php">ARM</a></li>
        <li><a href="PAGES/c.php">C</a></li>
        <li><a href="PAGES/java.php">JAVA</a></li>
        <li><a href="PAGES/php.php">PHP</a></li>
        <li><a href="PAGES/article.php">PYTHON</a></li>
        <li><a href="PAGES/html-css.php">HTML-CSS</a></li>
        <li><a href="PAGES/algorithms.php">ALGORITHMS</a></li>
        <li><a href="PAGES/general.php">GENERAL</a></li>
        <li><a href="PAGES/projects.php">PROJECTS</a></li>
        <!--        <li><a href="profile.php" style="color: #a6e1ec;font-family: -apple-system,sans-serif">--><?php //echo $username ?><!--</a></li>-->
        <li class="dropdown">
            <a href="javascript:void(0)" class="dropbtn" style="color: #a6e1ec"><?php echo $username ?></a>
            <div class="dropdown-content">
                <a href="profilepage.php">Profile</a>
                <a href="settings.php">Settings</a>
                <a href="logout.php" style="color: red">Logout</a>
            </div>
        </li>
    </ul>
</div>

<div class="home-page">
<?php
    $conn=connection();
    $stmt= $conn->prepare("SELECT * FROM users WHERE username=?");
    $stmt->bind_param("s",$username);
    $stmt->execute();
    $query = $stmt->get_result();
    $list=$query->fetch_assoc();
    $name = $list["name"];
    $surname = $list["surname"];
    $email = $list["email"];
    $tel = $list["tel"];
    $age = $list["age"];
    $sex = $list["sex"];
    $work = $list["work"];

    //-----get history-----
    $stmt= $conn->prepare("SELECT * FROM articles WHERE username=?");
    $stmt->bind_param("s",$username);
    $stmt->execute();
    $query = $stmt->get_result();
    $list=$query->fetch_assoc();
    $articles_Number = mysqli_num_rows($query);

    function get_post_num($username){
        $conn = connection();
        $stmt= $conn->prepare("SELECT * FROM articles WHERE username='".$username."'");
        $stmt->execute();
        $query = $stmt->get_result();
        $number = mysqli_num_rows($query);
        return $number;
    }

    function get_last_post($username){
        $conn = connection();
        $stmt= $conn->prepare("SELECT * FROM articles WHERE username='".$username."' ORDER BY id DESC LIMIT 1");
        $stmt->execute();
        $query = $stmt->get_result();
        $list=$query->fetch_assoc();
        return $list["title"];
    }

    function get_last_comment($username){
        $conn = connection();
        $stmt= $conn->prepare("SELECT * FROM comments WHERE username='".$username."' ORDER BY id DESC LIMIT 1");
        $stmt->execute();
        $query = $stmt->get_result();
        $list=$query->fetch_assoc();
        return $list["title"];
    }
    ?>

        <div class="form" >

            <div class="card">
                <img src="./ASSESTS/STYLE/MEDIA/pp.jpeg"  style="max-width:200px;max-height:200px">
                <p style="color:green;font-size: 19px">Username:<?php echo $_SESSION["username"] ?></p>
                <p style="color:green;font-size: 19px">Name:<?php echo $name ?></p>
                <p style="color:green;font-size: 19px">Surname:<?php echo $surname ?></p>
                <p style="color:green;font-size: 19px">Email:<?php echo $email ?></p>
                <p style="color:#d84500;font-size: 19px">Post Number:<?php echo get_post_num($_SESSION["username"]) ?></p>
                <p style="color:#d84500;font-size: 19px">Last Post:<?php echo get_last_post($_SESSION["username"]) ?></p>
                <p style="color:#d84500;font-size: 19px">Last Comment:<?php echo get_last_comment($_SESSION["username"]) ?></p>
            </div>
        </div>
</div>
<div class="footer">
    Copyright © 2018 Designed Baki Almacı
</div>

</body>
</html>