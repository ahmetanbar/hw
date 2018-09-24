<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" type="text/css" href="ASSESTS/STYLE/admin.css">
    <meta charset="UTF-8">
    <title>Socean</title>
</head>
<body>
<?php
session_start();
    function connection()
    {
        $server_name = "localhost";
        $username = "root";
        $password = "";
        $db_name = "blog";
        $conn = mysqli_connect($server_name, $username, $password, $db_name);
        mysqli_set_charset($conn, "utf8");
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        } else {
            return $conn;
        }
    }

    $conn=connection();
    $stmt= $conn->prepare("SELECT * FROM users WHERE username=?");
    $stmt->bind_param("s",$_SESSION["username"]);
    $stmt->execute();
    $query = $stmt->get_result();
    $list=$query->fetch_assoc();
    if($list["state"] == 1) {

        if (isset($_POST["delete_userid"])) {
            $id = ($_POST["delete_userid"]);
            $conn = connection();
            $stmt = $conn->prepare("DELETE FROM users WHERE id='" . $id . "'");
            $stmt->execute();
            header("Refresh:0");
            die();
        }

        if (isset($_POST["set_userid"])) {
            $id = $_POST["set_userid"];
            $conn = connection();
            $stmt = $conn->prepare("UPDATE users SET username=?, email=?, firstname=?, surname=?, tel=?, age=?, state=? WHERE id=?");
            $stmt->bind_param('ssssssss', $_POST["username"], $_POST["email"], $_POST["firstname"], $_POST["surname"], $_POST["tel"], $_POST["age"],$_POST["state"], $id);
            $stmt->execute();
            header("Refresh:0");
            die();
        }

        if (isset($_POST["delete_article_id"])) {
            $id = ($_POST["delete_article_id"]);
            $conn = connection();
            $stmt = $conn->prepare("DELETE FROM articles WHERE id='" . $id . "'");
            $stmt->execute();
            header("Refresh:0");
            die();
        }
//
//        $username = $list["username"];
//        $date = $list["date"];
//        $topic = $list["topic"];
//        $title = $list["title"];
//        $article = $list["article"];

        if (isset($_POST["set_article_id"])) {
            $id = $_POST["set_article_id"];
            $conn = connection();
            $stmt = $conn->prepare("UPDATE articles SET username=?, date=?, topic=?, title=?, article=? WHERE id=?");
            $stmt->bind_param('ssssss', $_POST["username"], $_POST["date"], $_POST["topic"], $_POST["title"], $_POST["article"], $id);
            $stmt->execute();
            header("Refresh:0");
            die();
        }

        function accounts(){
            $conn=connection();
            $stmt= $conn->prepare("SELECT * FROM users");
            $stmt->execute();
            $query = $stmt->get_result();
            $list=$query->num_rows;
            return $list;
        }

        function de_accounts(){
            $conn=connection();
            $stmt= $conn->prepare("SELECT * FROM users WHERE active IS NOT NULL");
            $stmt->execute();
            $query = $stmt->get_result();
            $list=$query->num_rows;
            return $list;
        }

        function ac_accounts(){
            $conn=connection();
            $stmt= $conn->prepare("SELECT * FROM users WHERE active IS NULL");
            $stmt->execute();
            $query = $stmt->get_result();
            $list=$query->num_rows;
            return $list;
        }

        function posts(){
            $conn=connection();
            $stmt= $conn->prepare("SELECT * FROM articles ");
            $stmt->execute();
            $query = $stmt->get_result();
            $list=$query->num_rows;
            return $list;
        }

        function comments(){
            $conn=connection();
            $stmt= $conn->prepare("SELECT * FROM comments ");
            $stmt->execute();
            $query = $stmt->get_result();
            $list=$query->num_rows;
            return $list;
        }

        ?>
        <div class="banner">
            <a id="block2" href="index.php"><--Go Back SOCEAN</a>
            <h2 id="block1">MANAGEMENT PANEL</h2>
        </div>

        <div class="grid-container">
            <div class="left">
                <h1>SOCEAN STATISTIC</h1>
                <div>
                    <p style="border: 1px solid #1f648b;max-width: 200px;margin: 5px auto;border-radius: 5px;font-family:'Segoe UI Light',sans-serif">Accounts:<?php echo accounts()?></p>
                    <p style="border: 1px solid #1f648b;max-width: 200px;margin: 5px auto;border-radius: 5px;font-family:'Segoe UI Light',sans-serif">Deactivated Accounts:<?php echo de_accounts()?></p>
                    <p style="border: 1px solid #1f648b;max-width: 200px;margin: 5px auto;border-radius: 5px;font-family:'Segoe UI Light',sans-serif">Active Accounts:<?php echo ac_accounts()?></p>
                    <p style="border: 1px solid #1f648b;max-width: 200px;margin: 5px auto;border-radius: 5px;font-family:'Segoe UI Light',sans-serif">Posts:<?php echo posts()?></p>
                    <p style="border: 1px solid #1f648b;max-width: 200px;margin: 5px auto;border-radius: 5px;font-family:'Segoe UI Light',sans-serif">Comments:<?php echo comments()?></p>
                </div>

                <h1>USERLIST</h1>
                <?php
                $conn = connection();
                $stmt = "SELECT * FROM users ORDER BY id DESC";
                $result = $conn->query($stmt);
                while ($list = $result->fetch_assoc()) {
                    if ($list) {
                        $userid = $list["id"];
                        $username = $list["username"];
                        $email = $list["email"];
                        $name = $list["firstname"];
                        $surname = $list["surname"];
                        $tel = $list["tel"];
                        $age = $list["age"];
                        $sex = $list["sex"];
                        $work = $list["work"];
                        $active = $list["active"];
                        $state = $list["state"];

                    } else {
                        break;
                    }
                    ?>
                    <form method="post" class="users">
                            <input name="username" type="text" value="<?php echo $username ?>" placeholder="username"/>
                            <input name="email" type="text" value="<?php echo $email ?>" placeholder="email" /><br>
                            <input name="firstname" type="text" value="<?php echo $name ?>" placeholder="firstname" />
                            <input name="surname" type="text" value="<?php echo $surname ?>" placeholder="surname" /><br>
                            <input name="tel" type="text" value="<?php echo $tel ?>" placeholder="tel" />
                            <input name="age" type="text" value="<?php echo $age ?>" placeholder="age" /><br>
                            <input name="active" type="text" value="<?php echo $active ?>" placeholder="active/de-active" style="color: red" />
                            <input name="state" type="text" value="<?php echo $state ?>" placeholder="user/admin" /><br>
                            <button type="submit" name="delete_userid" value="<?php echo $userid ?>">DELETE</button>
                            <button type="submit" name="set_userid"    value="<?php echo $userid ?>">SET</button>
                    </form>
                <?php } ?>
            </div>
            <div class="right">
                <h1>POSTS</h1>
                <?php
                $conn = connection();
                $stmt = "SELECT * FROM articles ORDER BY id DESC";
                $result = $conn->query($stmt);

                while ($list = $result->fetch_assoc()) {
                    if ($list) {
                        $id = $list["id"];
                        $username = $list["username"];
                        $date = $list["date"];
                        $topic = $list["topic"];
                        $title = $list["title"];
                        $article = $list["article"];
                    } else {
                        break;
                    }
                    ?>
                    <form method="post" class="posts">
                            <input name="username" type="text" value="<?php echo $username ?>"/>
                            <input name="date" type="text" value="<?php echo $date ?>"/><br>
                            <input name="topic" type="text" value="<?php echo $topic ?>"/>
                            <input name="title" type="text" value="<?php echo $title ?>"/><br>
                            <textarea name="article" type="text" style="min-width: 816px;max-height: 400px;min-height: 100px;max-width: 816px"><?php echo $article ?></textarea><br>
                             <button type="submit" name="delete_article_id" value="<?php echo $id ?>">DELETE</button>
                            <button type="submit" name="set_article_id"    value="<?php echo $id ?>">SET</button>
                    </form>

                <?php } ?>
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