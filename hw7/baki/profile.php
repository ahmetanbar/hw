<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="profile.css">
    <link rel="stylesheet" type="text/html" href="homepage.php">
    <title>Welcome to Socean</title>
</head>
<body class="profile-page">
<?php
$auth= $_COOKIE['auth'];
$conn = new mysqli("localhost", "root", "", "users");
$read = $conn->query("SELECT * FROM cookies WHERE cookie='" . $auth . "'");
$list = mysqli_fetch_array($read);
$username="";
if(!empty($list)){

    $userid = $list["user_id"];
    $read = $conn->query("SELECT * FROM users_table WHERE id='" . $userid . "'");
    $list = mysqli_fetch_array($read);
    $username = "Logout-".$list[1];

}
else{
    header("Location: ./homepage.php");
}
?>
<video autoplay muted loop id="myVideo">
    <source src="cloud.mp4" type="video/mp4">
</video>

    <div class="top-bar">
            <a id="bar-button" href="homepage.php">
                HomePage
            </a>
            <a id="bar-button" href="profile.php">
                Profile
            </a>
            <a id="bar-button" href="logout.php">
                <?php
                echo $username;
                ?>
            </a>

    </div>

    <div class="user-page">
            <?php
            echo "Welcome to Socean <br>";
            echo "Socean mean is = Social <-> Ocean";
            ?>

    </div>


</body>
</html>
