<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" type="text/css" href="ASSESTS/STYLE/profile.css">

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
    $id = 1;
    for($id = 1;$id<=5;$id++){
        $conn=connection();
        $stmt= $conn->prepare("SELECT * FROM articles WHERE id=?");
        $stmt->bind_param("s",$id);
        $stmt->execute();
        $query = $stmt->get_result();
        $list=$query->fetch_assoc();

        if($list){
            $username = $list["username"];
            $date = $list["date"];
            $topic = $list["topic"];
            $article = $list["article"];
            $title = $list["title"];
        }
        else{
            break;
        }
        ?>
        <div class="form" >

            <div id="title">
                <h1><?php echo $title?></h1>
                <p>Author:<?php echo $username?></p>
            </div>

            <p>
                <?php echo $article?>
            </p>

            <li class="more">
                <a id="more2" href="article.php">READ MORE</a>

            </li>

            <div id="info">
                <p>View:<?php echo "UNSET";?></p>
                <p>Comment:<?php echo "UNSET";?></p>
                <p>Date:<?php echo $date?></p>
            </div>

        </div>

    <?php } ?>

</div>

<div class="footer">
    Copyright © 2018 Designed Baki Almacı
</div>

</body>
</html>