<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="profile.css">
    <link rel="stylesheet" type="text/html" href="homepage.php">
    <title>Welcome to Soceanic</title>
</head>
<body class="profile-page">

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
            <a id="bar-button" href="homepage.php">
                <?php
                $auth = $_COOKIE['auth'];
                $conn = new mysqli("localhost", "root", "","users");
                $read = $conn->query("select * from cookies where cookie='".$auth."'");
                $list = mysqli_fetch_array($read);
                $userid = $list["user_id"];
                $read = $conn->query("SELECT * FROM users_table WHERE id='".$userid."'");
                $list = mysqli_fetch_array($read);
                $username = $list[1];
                echo "Logout-$username" ;
                ?>
            </a>
    </div>

    <div class="user-page">
            <?php
            echo "Welcome to Soceanic";
            ?>

    </div>


</body>
</html>
