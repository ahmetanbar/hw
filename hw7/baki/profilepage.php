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

function user_check(){
    $conn=connection();
    $stmt= $conn->prepare("SELECT * FROM users WHERE username=?");
    $stmt->bind_param("s",$_SESSION["username"]);
    $stmt->execute();
    $query = $stmt->get_result();
    $list=$query->fetch_assoc();
    if($list){
        return 1;
    }
    else
        return 0;
}

if(user_check()==1) {


    /* --------------------------------------------------------------------------------------*/
    if (isset($_SESSION["username"])) {
        $username = $_SESSION["username"];
    } else {
        $username = "";
        echo "Please Login. </br> <b>Redirecting...</b>";
        header("refresh:0;url=index.php");
    }
    ?>

    <div class="banner-text">

        <p>
            WE'VE KNEW YOU WOULD COME HERE
        </p>

        <form action="login.php">
            <button id="login-btn" name="btn" type="submit" value="btn"> LOGIN</button>
        </form>

        <form action="signup.php">
            <button id="signup-btn" name="btn" type="submit" value="btn"> SIGNUP</button>
        </form>

        <div id="social">
            <a href="http://facebook.com/bakialmaci">
                <img src="ASSESTS/STYLE/MEDIA/facebook.png" alt="fb" height="40" width="40">
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
        <a href="index.php" style="text-decoration: none;">
            <button id="btn" name="btn" type="submit" value="btn"> HOMEPAGE</button>
        </a>
        <a href="posted.php" style="text-decoration: none;">
            <button id="btn" name="btn" type="submit" value="btn"> POSTED</button>
            </button> </a>
        <a href="contact.php" style="text-decoration: none;">
            <button id="btn" name="btn" type="submit" value="btn"> CONTACT</button>
        </a>

    </div>

    <div class="menu">
        <ul>
            <li><a href="index.php?category=arduino">ARDUINO</a></li>
            <li><a href="index.php?category=arm">ARM</a></li>
            <li><a href="index.php?category=c">C</a></li>
            <li><a href="index.php?category=java">JAVA</a></li>
            <li><a href="index.php?category=php">PHP</a></li>
            <li><a href="index.php?category=python">PYTHON</a></li>
            <li><a href="index.php?category=html-css">HTML-CSS</a></li>
            <li><a href="index.php?category=algorithms">ALGORITHMS</a></li>
            <li><a href="index.php?category=general">GENERAL</a></li>
            <li><a href="index.php?category=projects">PROJECTS</a></li>
            <!--        <li><a href="profile.php" style="color: #a6e1ec;font-family: -apple-system,sans-serif">-->
            <?php //echo $username
            ?><!--</a></li>-->
            <li class="dropdown">
                <a href="javascript:void(0)" class="dropbtn" style="color: #a6e1ec"><?php echo $username ?></a>
                <div class="dropdown-content">
                    <a href="profilepage.php">Profile</a>
                    <a href="logout.php" style="color: red">Logout</a>
                </div>
            </li>
        </ul>
    </div>

    <div class="home-page">
        <?php
        $conn = connection();
        $stmt = $conn->prepare("SELECT * FROM users WHERE username=?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $query = $stmt->get_result();
        $list = $query->fetch_assoc();
        $userid = $list["id"];
        $username = $list["username"];
        $name = $list["firstname"];
        $surname = $list["surname"];
        $email = $list["email"];
        $tel = $list["tel"];
        $age = $list["age"];
        $sex = $list["sex"];
        $work = $list["work"];
        echo $userid;

        //-----get history-----
        $stmt = $conn->prepare("SELECT * FROM articles WHERE username=?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $query = $stmt->get_result();
        $list = $query->fetch_assoc();
        $articles_Number = mysqli_num_rows($query);

        function get_post_num($username)
        {
            $conn = connection();
            $stmt = $conn->prepare("SELECT * FROM articles WHERE username='" . $username . "'");
            $stmt->execute();
            $query = $stmt->get_result();
            $number = mysqli_num_rows($query);
            return $number;
        }

        function get_last_post($username)
        {
            $conn = connection();
            $stmt = $conn->prepare("SELECT * FROM articles WHERE username='" . $username . "' ORDER BY id DESC LIMIT 1");
            $stmt->execute();
            $query = $stmt->get_result();
            $list = $query->fetch_assoc();
            return $list["title"];
        }

        function get_last_comment($username)
        {
            $conn = connection();
            $stmt = $conn->prepare("SELECT * FROM comments WHERE username='" . $username . "' ORDER BY id DESC LIMIT 1");
            $stmt->execute();
            $query = $stmt->get_result();
            $list = $query->fetch_assoc();
            return $list["title"];
        }


        if (isset($_POST["delete_userid"])) {
            $id = ($_POST["delete_userid"]);
            $conn = connection();
            $stmt = $conn->prepare("DELETE FROM users WHERE id='" . $id . "'");
            $stmt->execute();
            echo "WE ARE WAITING YOUR COME BACK :(";
            echo "<br>";
            echo "REDIRECTING...";
            header("Refresh:3; url=index.php");
            die();
        }

        if (isset($_POST["set_userid"])) {
            $id = $_POST["set_userid"];
            $conn = connection();
            $stmt = $conn->prepare("UPDATE users SET username=?, email=?, firstname=?, surname=?, tel=?, age=? WHERE id=?");
            $stmt->bind_param('sssssss', $_POST["username"], $_POST["email"], $_POST["firstname"], $_POST["surname"], $_POST["tel"], $_POST["age"], $id);
            $stmt->execute();
            echo "AUTHORITY NOT FOUND!";
            echo "<br>";
            echo "REDIRECTING LOGIN PAGE...";
            header("Refresh:3; url=login.php");
            die();
        }
        ?>
        <div class="form">
            <div class="card">
                <form method="post">
                    <input name="username" type="text" value="<?php echo $username ?>"/>
                    <input name="email" type="text" value="<?php echo $email ?>"/><br>
                    <input name="firstname" type="text" value="<?php echo $name ?>"/>
                    <input name="surname" type="text" value="<?php echo $surname ?>"/><br>
                    <input name="tel" type="text" value="<?php echo $tel ?>"/>
                    <input name="age" type="text" value="<?php echo $age ?>"/><br>
                    <button type="submit" name="delete_userid" value="<?php echo $userid ?>">DELETE</button>
                    <button type="submit" name="set_userid" value="<?php echo $userid ?>">SET</button>
                </form>
                <p style="color:#d84500;font-size: 19px">Post Number:<?php echo get_post_num($username) ?></p>
                <p style="color:#d84500;font-size: 19px">Last Post:<?php echo get_last_post($username) ?></p>
                <p style="color:#d84500;font-size: 19px">Last Comment:<?php echo get_last_comment($username) ?></p>
            </div>
        </div>
    </div>
    <div class="footer">
        Copyright © 2018 Designed Baki Almacı
    </div>

    <?php
}
else{
    echo "AUTHORITY NOT FOUND!";
    echo "<br>";
    echo "REDIRECTING...";
    header("Refresh:3; url=index.php");
    die();
}
?>

</body>
</html>