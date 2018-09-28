<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" type="text/css" href="ASSESTS/STYLE/article.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <meta charset="UTF-8">
    <title>Socean</title>
</head>
<body>
<?php
global $view;
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

/* --------------------------------------------------------------------------------------*/
if(isset($_SESSION["username"])){
    $username = $_SESSION["username"];
}
else{
    $username="";
}
?>

<?php

if (isset($_POST["delete_comment_id"])) {
    $id = ($_POST["delete_comment_id"]);
    $conn = connection();
    $stmt = $conn->prepare("DELETE FROM comments WHERE id='" . $id . "'");
    $stmt->execute();
    header("Refresh:0");
    die();
}


function do_comment(){
    $user_id = get_user_id($_SESSION["username"]);
    $article_id = $_GET["more"];
    $title = $_POST["title"];
    $comment = $_POST["comment"];
    $username = $_SESSION["username"];
    $conn = connection();
    $conn->query("INSERT INTO comments (user_id, article_id,comments,title,username) VALUES ('$user_id', '$article_id','$comment','$title','$username')");
}

if(isset($_POST["send"])){
    do_comment();
}

    function get_articles_number(){
        $conn = connection();
        $stmt= $conn->prepare("SELECT * FROM comments WHERE article_id='".$_GET["more"]."'");
        $stmt->execute();
        $query = $stmt->get_result();
        $number_articles = mysqli_num_rows($query);
        return $number_articles;
    }

    function get_page_numbers(){
        $page_numbers = null;
        if(get_articles_number() <= 5){
            $page_numbers = 1;
        }
        else{
            $page_numbers = intval(get_articles_number()%5+1);
        }
        return $page_numbers;
    }

?>

<div class="menu">
		<ul>
            <li><a href="index.php" style="color: white;font-family: Tahoma,serif">HOMEPAGE</a></li>
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

    $username = get_user_name($list["user_id"]);
    $date = $list["date"];
    $topic = get_category_name($list["category_id"]);
    $article = $list["article"];
    $title = $list["title"];
    get_view($article_id);
    ?>

    	<div class="form" >
        	<div id="title">
				<h1><?php echo $title; ?></h1>
				<p>Author:<?php echo $username; ?></p>
    		</div>

    	<p>
        <?php echo $article;
        if (isset($_POST['like'])) {
            do_like(get_like_number($article_id),$article_id);
        }

        if (isset($_POST['dislike'])) {
            do_dislike(get_dislike_number($article_id),$article_id);
        }
        ?>
        </p>

			<div id="info">
                <p style="background-color: #c5f8ff;border-radius: 10px"><i class="material-icons" style="font-size: 16px;color: black">visibility</i>:<?php echo get_views_number($article_id); ?></p>
				<p style="background-color: #f0e8ff;border-radius: 10px"><i class="material-icons" style="font-size: 14px;color: black">comment</i>:<?php echo get_comments_number($article_id); ?></p>
				<p style="background-color: #fff2f6;border-radius: 10px"><span class="glyphicon glyphicon-calendar"></span>:<?php echo $date ?></p>
                <form method="post">
                    <button name="like" value="like" style="border: 0 solid;background-color: #cde4ff;font-family: 'Segoe UI Light',sans-serif;font-size: 18px;border-radius: 10px"><i class="material-icons" style="font-size: 14px">thumb_up</i>:<?php echo get_like_number($article_id) ?></button>
                    <button name="dislike" value="dislike"  style="border: 0 solid;background-color: #ffc3be;font-family: 'Segoe UI Light',sans-serif;font-size: 18px;border-radius: 10px"><i class="material-icons" style="font-size: 14px">thumb_down</i>:<?php echo get_dislike_number($article_id) ?></button>
                </form>

            </div>

        </div>

            <?php
            $conn = connection();
            $stmt ="SELECT * FROM comments WHERE article_id='".$_GET["more"]."'ORDER BY id DESC";
            $result = $conn->query($stmt);
            while($list = $result->fetch_assoc()) {
                if($list){
                    $username = $list["username"];
                    $title = $list["title"];
                    $comments = $list["comments"];
                }
                else{
                    break;
                }
                ?>
                <div id="comments">
                    <?php if(isset($_SESSION["username"])){
                        if($_SESSION["username"] == $username){?>
                        <form method="post">
                            <button style="border: 1px solid;background-color: #d58388;padding: 5px;border-radius: 5px;float: right" name="delete_comment_id" value="<?php echo get_comment_id();?>">Delete Comment</button>
                        </form>
                    <?php }}
                    ?>
                    <h2 style="font-family: 'Segoe UI Light',serif;color: #ff5351"><a style="color: #000000;font-family: 'Segoe UI Light',sans-serif;float: left">Writer:</a><?php echo $username;?>:</h2>
                    <h2 style="color: #2b92a7;font-size: 16px;font-family: 'Segoe UI Light',sans-serif;"><a style="color: black">Title:</a> <?php echo $title; ?></h2  >
                    <h2 style="color: #a94442"> <a style="color: black;font-size: 18px;">Comment:</a> <br> <?php echo $comments;?>:</h2>
            </div>
        <?php }        ?>


        <div id="comment">
                <form method="post">
                    <?php echo($_SESSION and user_check()==1) ? '<input    id="contact-input" name="title" type="text"     placeholder="Title"/>':'<input    id="contact-input" name="title" type="text"     placeholder="Title" disabled/>'; ?>
                    <?php echo($_SESSION and user_check()==1) ? '<textarea id="msg-input"     name="comment"  placeholder="Write here..."></textarea>':'<textarea id="msg-input"     name="msg"  placeholder="Write here..." disabled></textarea>'; ?>
                    <?php echo($_SESSION and user_check()==1) ? '<button   id="contact-btn"   name="send" type="submit" value="send"  >SEND</button>':'<button id="contact-btn"  style="background: #a94442;color: white" disabled><a href="login.php" style="text-decoration: none;color: white">LOGIN TO SEND</a></button>'; ?>
                </form>

    <?php

    function get_category_id($category_name){
        $conn=connection();
        $stmt ="SELECT * FROM categories WHERE category= '".$category_name."'";
        $result = $conn->query($stmt);
        $list = $result->fetch_assoc();
        return $list["id"];
    }

    function get_category_name($category_id){
        $conn=connection();
        $stmt ="SELECT * FROM categories WHERE category= '".$category_id."'";
        $result = $conn->query($stmt);
        $list = $result->fetch_assoc();
        return $list["category"];
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


    function get_comment_id(){
        $username = $_SESSION["username"];
        $conn = connection();
        $read = $conn->query("SELECT * FROM comments WHERE username='".$username."'");
        $list = mysqli_fetch_array($read);
        $comment_id = $list["id"];
        return $comment_id;
    }

    function count_view($view,$article_id){
        $view = $view + 1;
        $conn=connection();
        $stmt = $conn->prepare("UPDATE articles SET views=? WHERE id=?");
        $stmt->bind_param('ii',$view,$article_id);
        $stmt->execute();
        return $view;
    }

    function get_view($article_id){
        $conn=connection();
        $stmt= $conn->prepare("SELECT * FROM articles WHERE id='".$article_id."'");
        $stmt->execute();
        $query = $stmt->get_result();
        $list=$query->fetch_assoc();
        $view = $list["views"];
        $view = count_view($view,$article_id);
        return $view;
    }

    function get_views_number($id){
        $conn=connection();
        $stmt= $conn->prepare("SELECT * FROM articles WHERE id='".$id."'");
        $stmt->execute();
        $query = $stmt->get_result();
        $list=$query->fetch_assoc();
        $views = $list["views"];
        return $views;
    }

    function get_comments_number($id){
        $conn=connection();
        $stmt= $conn->prepare("SELECT * FROM comments WHERE article_id='".$id."'");
        $stmt->execute();
        $query = $stmt->get_result();
        $num_rows = mysqli_num_rows($query);
        return $num_rows;
    }

      function do_like($like,$article_id) {
          $like++;
          $conn=connection();
          $stmt = $conn->prepare("UPDATE articles SET likes=? WHERE id=?");
          $stmt->bind_param('ii',$like,$article_id);
          $stmt->execute();

      }

      function get_like_number($id){
          $conn=connection();
          $stmt= $conn->prepare("SELECT * FROM articles WHERE id='".$id."'");
          $stmt->execute();
          $query = $stmt->get_result();
          $list=$query->fetch_assoc();
          $likes = $list["likes"];
          return $likes;
      }


    function do_dislike($dislike,$article_id) {
        $dislike++;
        $conn=connection();
        $stmt = $conn->prepare("UPDATE articles SET dislikes=? WHERE id=?");
        $stmt->bind_param('ii',$dislike,$article_id);
        $stmt->execute();
    }

    function get_dislike_number($id){
        $conn=connection();
        $stmt= $conn->prepare("SELECT * FROM articles WHERE id='".$id."'");
        $stmt->execute();
        $query = $stmt->get_result();
        $list=$query->fetch_assoc();
        $dislikes = $list["dislikes"];
        return $dislikes;
    }
    ?>
</div>

<div class="footer">
		Copyright © 2018 Designed Baki Almacı
</div>

</body>



</html>