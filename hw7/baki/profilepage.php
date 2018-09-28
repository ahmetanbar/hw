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

function admin_check(){
    $conn=connection();
    $stmt= $conn->prepare("SELECT * FROM users WHERE username=?");
    $stmt->bind_param("s",$_SESSION["username"]);
    $stmt->execute();
    $query = $stmt->get_result();
    $list=$query->fetch_assoc();
    if($list["state"] == 1){
        return 1;
    }
    else
        return 0;
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
        <a href="index.php" style="text-decoration: none;"> <button id="btn" name="btn" type="submit" value="btn"> HOMEPAGE </button> </a>
        <a href="index.php?posted=<?php echo $_SESSION["username"]?>"style="text-decoration: none;"> <button id="btn"  name="btn" type="submit"  value="btn"> POSTED </button></a>
        <a href="contact.php" style="text-decoration: none;"> <button id="btn" name="btn" type="submit" value="btn"> CONTACT </button> </a>

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
            <li class="dropdown">
                <a href="javascript:void(0)" class="dropbtn" style="color: #a6e1ec"><?php echo $username ?></a>
                <div class="dropdown-content">
                    <a href="profilepage.php">Profile</a>
                    <?php
                    if(admin_check() == 1) {?>
                        <a href="admin.php">Admin</a>
                    <?php }?>
                    <a href="logout.php" style="color: red">Logout</a>
                </div>
            </li>
        </ul>
    </div>

    <div class="home-page">
        <?php
        if(isset($_GET["profile"])) {
            $username = $_GET["profile"];
        }else{
            header("Refresh:0; url=index.php");
            die();
        }
        $conn = connection();
        $stmt = $conn->prepare("SELECT * FROM users WHERE username=?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $query = $stmt->get_result();
        $list = $query->fetch_assoc();
        if($list && !$list["active"]){
            $userid = $list["id"];
            $username = $list["username"];
            $name = $list["firstname"];
            $surname = $list["surname"];
            $email = $list["email"];
            $tel = $list["tel"];
            $age = $list["age"];
            $sex = $list["sex"];
            $work = $list["work"];
        }
        else{
            header("Refresh:0; url=index.php");
            die();
        }

        $stmt = $conn->prepare("SELECT * FROM articles WHERE user_id=?");
        $stmt->bind_param("s", $userid);
        $stmt->execute();
        $query = $stmt->get_result();
        $list = $query->fetch_assoc();
        $articles_Number = mysqli_num_rows($query);

        function get_post_num($user_id)
        {
            $conn = connection();
            $stmt = $conn->prepare("SELECT * FROM articles WHERE user_id='" . $user_id . "'");
            $stmt->execute();
            $query = $stmt->get_result();
            $number = mysqli_num_rows($query);
            return $number;
        }

        function get_last_post($user_id)
        {
            $conn = connection();
            $stmt = $conn->prepare("SELECT * FROM articles WHERE user_id='" . $user_id . "' ORDER BY id DESC LIMIT 1");
            $stmt->execute();
            $query = $stmt->get_result();
            $list = $query->fetch_assoc();
            return $list["title"];
        }

        function get_last_post_id($user_id)
        {
            $conn = connection();
            $stmt = $conn->prepare("SELECT * FROM articles WHERE user_id='" . $user_id . "' ORDER BY id DESC LIMIT 1");
            $stmt->execute();
            $query = $stmt->get_result();
            $list = $query->fetch_assoc();
            return $list["id"];
        }

        function get_last_comment($user_id){
            $conn = connection();
            $stmt = $conn->prepare("SELECT * FROM comments WHERE user_id='" . $user_id . "' ORDER BY id DESC LIMIT 1");
            $stmt->execute();
            $query = $stmt->get_result();
            $list = $query->fetch_assoc();
            return $list["title"];
        }

        function get_last_comment_id($user_id){
            $conn = connection();
            $stmt = $conn->prepare("SELECT * FROM comments WHERE user_id='" . $user_id . "' ORDER BY id DESC LIMIT 1");
            $stmt->execute();
            $query = $stmt->get_result();
            $list = $query->fetch_assoc();
            return $list["article_id"];
        }

        function get_user_name($user_id){
            $conn=connection();
            $stmt ="SELECT * FROM users WHERE id= '".$user_id."'";
            $result = $conn->query($stmt);
            $list = $result->fetch_assoc();
            return $list["username"];
        }

        function get_user_id($username){
            $conn=connection();
            $stmt ="SELECT * FROM users WHERE username= '".$username."'";
            $result = $conn->query($stmt);
            $list = $result->fetch_assoc();
            return $list["id"];
        }


        if (isset($_POST["delete_userid"])) {
            $current_time = date ('Y-m-d h:m');
            $id = $_POST["delete_userid"];
            $state = 2;
            $conn = connection();
            $stmt = $conn->prepare("UPDATE users SET state=?,active=? WHERE id=?");
            $stmt->bind_param('ssi', $state,$current_time, $id);
            $stmt->execute();
            session_destroy();
            echo "WE ARE WAITING YOUR COME BACK :(";
            echo "<br>";
            echo "REDIRECTING...";
            header("Refresh:3; url=index.php");
            die();
        }

        /* --------------------------------------USERNAME CHECK-----------------------------------*/
        function username_check($username){
            $username = preg_replace ("/ +/", "", $username);
            $case1='/[!@#$%^&*()\-_=+{};:,<.>ıüğşçö]/';
            if(preg_match_all($case1,$username, $o)>0) return null;
            if(strlen($username)<5) return null;
            return 1;
        }
        /* ---------------------------------------EMAIL CHECK--------------------------------------*/
        function email_check($email){
            if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                return 1;
            }
            else return null;
        }
        function firstname_check($firstname){
            $firstname = preg_replace ("/ +/", "", $firstname);
            $case1='/[!@#$%^&*()\-_=+{};:,<.>ıüğşçö]/';
            if(preg_match_all($case1,$firstname, $o)>0) return null;
            if(strlen($firstname)<5) return null;
            return 1;
        }

        function validate_phone_number($phone)
        {
            if($phone == ""){
                return 1;
            }
            return preg_match('/^[0-9]{10}+$/', $phone);
        }

        if (isset($_POST["set_userid"]) and username_check($_POST["username"]) and email_check($_POST["email"]) and firstname_check($_POST["firstname"]) and validate_phone_number($_POST["tel"]) and strlen($_POST["age"]) <= 2) {
            $id = $_POST["set_userid"];
            $conn = connection();
            $stmt = $conn->prepare("UPDATE users SET username=?, email=?, firstname=?, surname=?, tel=?, age=? WHERE id=?");
            $stmt->bind_param('sssssss', $_POST["username"], $_POST["email"], $_POST["firstname"], $_POST["surname"], $_POST["tel"], $_POST["age"], $id);
            $stmt->execute();
            $_SESSION["username"] = $_POST["username"];
            header("Refresh:0; url=profilepage.php?profile=".$_SESSION["username"]);
            die();
        }
        ?>
        <div class="form">
            <div class="card">
                <form method="post">
                    <input placeholder="username" name="username" type="text" value="<?php echo $username ?>" <?php if($_SESSION["username"] != $_GET["profile"]){ ?> disabled style="border: 0 solid;text-align: center" <?php } ?> />
                    <input placeholder="email" name="email" type="text" value="<?php echo $email ?>" <?php if($_SESSION["username"] != $_GET["profile"]){ ?> disabled style="border: 0 solid;text-align: center" <?php } ?> /><br>
                    <input placeholder="firstname" name="firstname" type="text" value="<?php echo $name ?>" <?php if($_SESSION["username"] != $_GET["profile"]){ ?> disabled style="border: 0 solid;text-align: center" <?php } ?> />
                    <input placeholder="surname" name="surname" type="text" value="<?php echo $surname ?>" <?php if($_SESSION["username"] != $_GET["profile"]){ ?> disabled style="border: 0 solid;text-align: center" <?php } ?> /><br>
                    <input placeholder="tel(5XXXXXXXX)" name="tel" type="text" value="<?php echo $tel ?>" <?php if($_SESSION["username"] != $_GET["profile"]){ ?> disabled style="border: 0 solid;text-align: center" <?php } ?> />
                    <input placeholder="Age" name="age" type="text" value="<?php echo $age ?>" <?php if($_SESSION["username"] != $_GET["profile"]){ ?> disabled style="border: 0 solid;text-align: center" <?php } ?> /><br>
                    <button type="submit" name="delete_userid" value="<?php echo $userid ?>" <?php if($_SESSION["username"] != $_GET["profile"]){ ?>style="display: none"<?php } ?>>DELETE</button>
                    <button type="submit" name="set_userid" value="<?php echo $userid ?> "  <?php if($_SESSION["username"] != $_GET["profile"]){ ?>style="display: none"<?php } ?> >SET</button>
                </form>
                <p style="color:#d84500;font-size: 19px">Post Number:<?php echo get_post_num(get_user_id($_GET["profile"])) ?></p>
                <p style="color:#d84500;font-size: 19px">Last Post:<a style="text-decoration: none" href="article.php?more=<?php    echo get_last_post_id(get_user_id($_GET["profile"]))?>"><?php if(get_last_post(get_user_id($_GET["profile"]))){
                    echo get_last_post(get_user_id($_GET["profile"]));
                        }else{
                    echo "Not Found";
                        } ?></a></p>
                <p style="color:#d84500;font-size: 19px;<?php if(!get_last_comment_id($username)){?> display: none <?php }?>">Last Comment:<a style="text-decoration: none" href="article.php?more=<?php echo get_last_comment_id(get_user_id($_GET["profile"]))?>"><?php if(get_last_comment(get_user_id($_GET["profile"]))){
                            echo get_last_comment(get_user_id($_GET["profile"]));
                        }else{
                            echo "Not Found";
                        } ?></a></p>
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