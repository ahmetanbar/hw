<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" type="text/css" href="ASSESTS/STYLE/update_user.css">
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

    function get_category_id($category_name){
        $conn=connection();
        $stmt ="SELECT * FROM categories WHERE category= '".$category_name."'";
        $result = $conn->query($stmt);
        $list = $result->fetch_assoc();
        return $list["id"];
    }

    function get_category_name($category_id){
        $conn=connection();
        $stmt ="SELECT * FROM categories WHERE id='".$category_id."'";
        $result = $conn->query($stmt);
        $list = $result->fetch_assoc();
        return $list["category"];
    }


    if (isset($_POST["delete_userid"])) {
        $id = ($_POST["delete_userid"]);
        $conn = connection();
        $stmt = $conn->prepare("DELETE FROM users WHERE id='" . $id . "'");
        $stmt->execute();
        header("Refresh:0");
        die();
    }

    function set_user_button($userid){
        $conn=connection();
        $stmt= $conn->prepare("SELECT * FROM users WHERE id=?");
        $stmt->bind_param("i",$userid);
        $stmt->execute();
        $query = $stmt->get_result();
        $list=$query->fetch_assoc();
        if($_POST["username"] != $list["username"] or $_POST["email"] != $list["email"]){
            return 1;
        }
        else{
            return null;
        }
    }

    if (isset($_POST["set_userid"])) {
            $userid = $_GET["userid"];
            if(get_user_name($userid) != $_POST["username"]) {
                $_SESSION["username"] = $_POST["username"];
            }
            $conn = connection();
            $stmt = $conn->prepare("UPDATE users SET username=?, email=?, firstname=?, surname=?, tel=?, age=?, work=?, sex=? WHERE id=?");
            $stmt->bind_param('ssssssssi', $_POST["username"], $_POST["email"], $_POST["firstname"], $_POST["surname"], $_POST["tel"], $_POST["age"],$_POST["work"],$_POST["sex"],$userid);
            $stmt->execute();
            echo $userid;
            header("Refresh:0; url=update_user.php?userid=".$userid);
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

    if (isset($_POST["set_article_id"])) {
        $id = $_POST["set_article_id"];
        $conn = connection();
        $stmt = $conn->prepare("UPDATE articles SET username=?, date=?, topic=?, title=?, article=? WHERE id=?");
        $stmt->bind_param('ssssss', $_POST["username"], $_POST["date"], $_POST["topic"], $_POST["title"], $_POST["article"], $id);
        $stmt->execute();
        header("Refresh:0");
        die();
    }



    ?>
    <div class="banner">
        <a id="block2" href="index.php"><--Go Back SOCEAN</a>
        <a href="admin.php" id="block1" style="font-size: 24px">MANAGEMENT PANEL</a>
    </div>

    <div class="grid-container">
        <div class="left">
            <h1>USERLIST</h1>
            <?php
            $stmt= $conn->prepare("SELECT * FROM users WHERE id=?");
            $stmt->bind_param("i",$_GET["userid"]);
            $stmt->execute();
            $query = $stmt->get_result();
            $list=$query->fetch_assoc();
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

                }
                else{
                    header("Refresh:3; url=admin.php");
                    die();
                }
                ?>
                <form method="post" class="users">
                    <input name="username" type="text" value="<?php echo $username ?>" placeholder="username"/>
                    <input name="email" type="text" value="<?php echo $email ?>" placeholder="email" />
                    <input name="firstname" type="text" value="<?php echo $name ?>" placeholder="firstname" />
                    <input name="surname" type="text" value="<?php echo $surname ?>" placeholder="surname" />
                    <input name="tel" type="text" value="<?php echo $tel ?>" placeholder="tel" />
                    <input name="age" type="text" value="<?php echo $age ?>" placeholder="age" />
                    <input name="sex" type="text" value="<?php echo $sex ?>" placeholder="sex" />
                    <input name="work" type="text" value="<?php echo $work ?>" placeholder="work" />
                    <input name="active" type="text" value="<?php echo $active ?>" placeholder="Active" style="color: red" /><br>
                    <button type="submit" name="delete_userid" value="<?php echo $userid ?>" style="color: crimson">DELETE</button>
                    <button type="submit" name="set_userid"    value="<?php echo $userid ?>" style="color: cadetblue">UPDATE</button>
                </form>
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
                    $username = get_user_name($list["user_id"]);
                    $date = $list["date"];
                    $topic = get_category_name($list["category_id"]);
                    $title = $list["title"];
                    $article = $list["article"];
                } else {
                    break;
                }
                ?>
                <form method="post" class="posts">
                    <input name="userid" type="text" value="<?php echo $id ?>" style="max-width: 20px;font-family: Tohoma,sans-serif"/>
                    <input name="username" type="text" value="<?php echo $username ?>"/>
                    <input name="date" type="text" value="<?php echo $date ?>"/>
                    <input name="topic" type="text" value="<?php echo $topic ?>" style="max-width: 100px"/>
                    <input name="title" type="text" value="<?php echo $title ?>" style="max-width: 100px"/>
                    <!--                            <textarea name="article" type="text" style="min-width: 816px;max-height: 400px;min-height: 100px;max-width: 816px">--><?php //echo $article ?><!--</textarea><br>-->
                    <button type="submit" name="delete_article_id" value="<?php echo $id ?>" style="color: crimson">DELETE</button>
                    <button type="submit" name="set_article_id"    value="<?php echo $id ?>" style="color: cadetblue">UPDATE</button>
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