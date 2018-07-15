<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" type="text/css" href="ASSESTS/STYLE/article.css">

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
            <li><a href="index.php" style="color: white;font-family: Tahoma,serif">HOMEPAGE</a></li>
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
    get_view($article_id);
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
				<p style="background-color: #c5f8ff;border-radius: 10px">View:<?php echo get_views_number($article_id); ?></p>
				<p style="background-color: #f0e8ff;border-radius: 10px">Comment:<?php echo get_comments_number($article_id); ?></p>
				<p style="background-color: #fff2f6;border-radius: 10px">Date:04/08/2018</p>
                <form method="post">
                    <button name="like" value="like" style="border: 0 solid;background-color: #cde4ff;font-family: 'Segoe UI Light',sans-serif;font-size: 16px;border-radius: 10px">Like:<?php echo get_like_number($article_id) ?></button>
                    <button name="dislike" value="dislike"  style="border: 0 solid;background-color: #ffc3be;font-family: 'Segoe UI Light',sans-serif;font-size: 16px;border-radius: 10px">Dislike:<?php echo get_dislike_number($article_id) ?></button>
                </form>

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
                    <h2 style="font-family: 'Segoe UI Light',serif;color: #ff5351"><a style="color: #000000;font-family: 'Segoe UI Light',sans-serif;float: left">Writer:</a><?php echo $username;?>:</h2>
                    <h2 style="color: #2b92a7;font-size: 16px;font-family: 'Segoe UI Light',sans-serif;"><a style="color: black">Title:</a> <?php echo $title; ?></h2  >
                    <h2 style="color: #a94442"> <a style="color: black;font-size: 18px;">Comment:</a> <br> <?php echo $comments;?>:</h2>
            </div>
        <?php } ?>


        <div id="comment">
                <form method="post">
                    <?php echo($_SESSION) ? '<input    id="contact-input" name="title" type="text"     placeholder="Title"/>':'<input    id="contact-input" name="title" type="text"     placeholder="Title" disabled/>'; ?>
                    <?php echo($_SESSION) ? '<textarea id="msg-input"     name="comment"  placeholder="Write here..."></textarea>':'<textarea id="msg-input"     name="msg"  placeholder="Write here..." disabled></textarea>'; ?>
                    <?php echo($_SESSION) ? '<button   id="contact-btn"   name="send" type="submit" value="send"  >SEND</button>':'<button id="contact-btn"  style="background: #a94442;color: white" disabled><a href="login.php" style="text-decoration: none;color: white">LOGIN TO SEND</a></button>'; ?>
                </form>

    <?php
    function do_comment(){
        $user_id = get_user_id();
        $article_id = $_GET["more"];
        $title = $_POST["title"];
        $comment = $_POST["comment"];
        $username = $_SESSION["username"];
        $conn = connection();
        $conn->query("INSERT INTO comments (user_id, article_id,comments,title,username) VALUES ('$user_id', '$article_id','$comment','$title','$username')");
    }

    if(isset($_POST["more"])){
        comment();
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
    if (isset($_POST['like'])) {
        do_like(get_like_number($article_id),$article_id);
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

    if (isset($_POST['dislike'])) {
        do_dislike(get_dislike_number($article_id),$article_id);
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

            <script>
                if ( window.history.replaceState ) {
                    window.history.replaceState( null, null, window.location.href );
                }
            </script>


</div>

<div class="footer">
		Copyright © 2018 Designed Baki Almacı
</div>

</body>



</html>