<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" type="text/css" href="index.css">

    <meta charset="UTF-8">
    <title>Socean</title>
</head>
<body>
<div class="banner">
    <div style="float: left;margin-left: -1%;margin-top: -90px"><img src="logo.png" alt="Mountain View" height="300" width="400"> </div>
     <a href="index.php" style="text-decoration: none"> HOMEPAGE</a>
     <a href="posted.php" style="text-decoration: none"> POSTED</a>
     <a href="contact.php" style="text-decoration: none"> CONTACT</a>
    <a href="login.php" style="text-decoration: none"> LOGIN</a>
     <a href="signup.php" style="text-decoration: none"> SIGNUP</a>
</div>

<?php
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
?>

<div class="home-page">
    <?php
            $id = 1;
            for($id = 1;$id<=5;$id++){
            $conn=connection();
            $read = $conn->query("SELECT * FROM articles WHERE id='".$id."'");
            $list = mysqli_fetch_array($read);
            if($list[0]){
                $username = $list[1];
                $date = $list[2];
                $topic = $list[3];
                $article = $list[4];
                $title = $list[5];
            }
            else{
                break;
            }
?>
    <div class="form" >

        <div id="title">
            <h1><?php echo $title?></h1	>
        </div>

        <p>
             <?php echo $article?>
        </p>

        <div id="info">
            <p>Date:<?php echo $date?></p>
            <p>View: UNSET </p>
            <p>Comment: UNSET</p>
            <p>Author:<?php echo $username?></p>
        </div>

    </div>

    <?php } ?>


</div>

<div class="footer">
    powered by bakialmaci - 2018
</div>




</body>
</html>