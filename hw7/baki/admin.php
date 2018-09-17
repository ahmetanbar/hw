<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" type="text/css" href="ASSESTS/STYLE/admin.css">
    <meta charset="UTF-8">
    <title>Socean</title>
</head>
<body>
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
if(isset($_GET["delete_userid"])){
    $id = ($_GET["delete_userid"]);
    $conn=connection();
    $stmt= $conn->prepare("DELETE FROM users WHERE id='".$id."'");
    $stmt->execute();
    header("Location:admin.php");
    die();
}

if(isset($_GET["set_userid"])){
    $id = ($_GET["set_userid"]);    
    $conn=connection();
    $stmt= $conn->prepare("UPDATE users SET username=?, email=?, firstname=?, surname=? WHERE id=?");
    $stmt->bind_param('ssssi', $_POST["username"], $_POST["email"], $_POST["firstname"],$_POST["surname"],$id);
    $stmt->execute();
    header("Location:admin.php");
    die();
}

?>

<div class="grid-container">
    <div class="left">
        <h1>USERLIST</h1>
        <?php
        $conn = connection();
        $stmt ="SELECT * FROM users ORDER BY id DESC";
        $result = $conn->query($stmt);
        while($list = $result->fetch_assoc()) {
        if($list){
            $userid = $list["id"];
            $username = $list["username"];
            $email = $list["email"];
            $name = $list["firstname"];
            $surname = $list["surname"];
            $tel = $list["tel"];
            $age = $list["age"];
            $sex = $list["sex"];
            $work = $list["work"];

        }
        else{
            break;
        }
        ?>
        <div style="border: 1px solid crimson;margin: 10px;padding: 5px">
            <form method="post">
                <input name="username" placeholder=<?php echo $username?>><br>
                <input name="email" placeholder=<?php echo $email?>><br>
                <input name="firstname" placeholder=<?php echo $name?>><br>
                <input name="surname" placeholder=<?php echo $surname?>><br>
                <a href="admin.php?delete_userid=<?php echo $userid; ?>">Delete</a>
                <a href="admin.php?set_userid=<?php echo $userid; ?>">Set</a>
            </form>


        </div>
        <?php } ?>
    </div>
    <div class="right">
        <h1>POSTS</h1>
        <?php
        $conn = connection();
        $stmt ="SELECT * FROM articles ORDER BY id DESC";
        $result = $conn->query($stmt);

        while($list = $result->fetch_assoc()) {
            if($list){
                $username = $list["username"];
                $date = $list["date"];
                $topic = $list["topic"];
                $title = $list["title"];
            }
            else{
                break;
            }
            ?>
            <div style="border: 1px solid crimson;margin: 10px;padding: 5px">
                <form method="post">
                    <p>Username:<?php echo $username?></p>
                    <p>Date:<?php echo $date?></p>
                    <p>Topic:<?php echo $topic?></p>
                    <p>Title:<?php echo $title?></p>
                    <button name="delete_article">Delete</button>
                    <button name="set_article">Set</button>
                </form>
            </div>
        <?php } ?>
    </div>
</div>



<div class="footer">
    Copyright © 2018 Designed Baki Almacı
</div>

</body>
</html>