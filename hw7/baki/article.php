<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" type="text/css" href="ASSESTS/STYLE/article.css">

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
}
?>

<div class="menu">
		<ul>
            <li><a href="index.php" style="color: cornflowerblue">HOMEPAGE</a></li>
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
			  </ul>
</div>

<div class="home-page">

    <?php
    $article_id = $_GET["more"];
    $conn=connection();
    $stmt= $conn->prepare("SELECT * FROM articles WHERE id='".$article_id."'");
    $stmt->execute();
    $query = $stmt->get_result();
    $list=$query->fetch_assoc();

    $username = $list["username"];
    $date = $list["date"];
    $topic = $list["topic"];
    $article = $list["article"];
    $title = $list["title"];

    ?>

    	<div class="form" >

        	<div id="title">
				<h1><?php echo $title; ?></h1>
				<p>Author:<?php echo $username; ?></p>
    		</div>

    	<p>
        <?php echo $article; ?>
        </p>

			<div id="info">
				<p>View:55</p>
				<p>Comment:13</p>
				<p>Date:04/08/2018</p>
				
            </div>

        </div>

            <?php
            $conn=connection();
            $stmt= $conn->prepare("SELECT * FROM comments WHERE article_id='".$article_id."'");
            $stmt->execute();
            $query = $stmt->get_result();
            $rows = array(); ?>

        <?php
        $counter = 0;
                while($row = mysqli_fetch_array($query)) {
                    array_push($rows, $row);
                }
           ?>
                    <?php
                    while ($rows){
                        if(!isset($rows[$counter])){
                            break;
                        }
                        $username = json_encode($rows[$counter]["username"]);
                        $title = json_encode($rows[$counter]["title"]);
                        $comments =  json_encode($rows[$counter]["comments"]);
                        $counter++;

                    ?>
                <div id="comments">
                <h2 style="font-family: 'Segoe UI Black',serif;color: #7a48b3"><?php echo $username;?>:</h2>
                    <h3 style="color: #1f648b;font-size: 16px"> <?php echo $title; ?></h3  >
                <p><?php echo $comments;?>:</p>
            </div>
        <?php } ?>


        <div id="comment">
                <form method="post">
                    <input    id="contact-input" name="title" type="text"     placeholder="Title"/>
                    <?php echo($_SESSION) ? '<textarea id="msg-input"     name="comment"  placeholder="Write here..."></textarea>':'<textarea id="msg-input"     name="msg"  placeholder="Write here..." disabled></textarea>'; ?>
                    <?php echo($_SESSION) ? '<button   id="contact-btn"   name="send" type="submit" value="send"  >SEND</button>':'<button   id="contact-btn"   name="send" type="submit" value="send" disabled  style="background: whitesmoke;color: darkgray">LOGIN TO SEND</button>'; ?>
                </form>

    <?php
    if($_POST){
        $user_id = get_user_id();
        $article_id = $_GET["more"];
        $title = $_POST["title"];
        $comment = $_POST["comment"];
        $username = $_SESSION["username"];
        $conn = connection();
        $conn->query("INSERT INTO comments (user_id, article_id,comments,title,username) VALUES ('$user_id', '$article_id','$comment','$title','$username')");
        $stmt->execute();
        $query = $stmt->get_result();
    }
    function get_user_id(){
        $username = $_SESSION["username"];
        $userid = null;
        $conn = connection();
        $read = $conn->query("SELECT * FROM users WHERE username='".$username."'");
        $list = mysqli_fetch_array($read);
        $userid = $list[0];
        //echo $userid;
        return $userid;
    }

//    function get_article_id(){
//        $article_id = null;
//        $conn = connection();
//        $read = $conn->query("SELECT * FROM articles WHERE username='".$username."'");
//        $list = mysqli_fetch_array($read);
//        $userid = $list[0];
//        echo $userid;
//        return $userid;
//    }

    ?>



</div>

<div class="footer">
		Copyright © 2018 Designed Baki Almacı
</div>

</body>



</html>