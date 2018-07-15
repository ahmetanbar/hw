<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" type="text/css" href="ASSESTS/STYLE/index.css">

    <meta charset="UTF-8">
    <title>Socean</title>
</head>
<body>

<?php
session_start();
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
<div class="banner-text">

		<p>
				WE'VE KNEW YOU WOULD COME HERE
		</p>
    <?php echo($_SESSION) ? '':'<form action="login.php">
			<button id="login-btn"  name="btn" type="submit"  value="btn"> LOGIN </button>
		</form>
		
				<form action="signup.php">
				<button id="signup-btn"  name="btn" type="submit"  value="btn"> SIGNUP </button>
		</form>	'; ?>



		<div id="social">
				<a href="http://facebook.com/bakialmaci">
					<img src="ASSESTS/STYLE/MEDIA/facebook.png" alt="fb" height="40" width="40" >
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
		<a href="posted.php" style="text-decoration: none;"> <button id="btn"  name="btn" type="submit"  value="btn"> POSTED </button> </button> </a>
		<a href="contact.php" style="text-decoration: none;"> <button id="btn" name="btn" type="submit" value="btn"> CONTACT </button> </a>
		
	</div>

<div class="menu">
		<ul>
				<li><a href="article.php?arduino">ARDUINO</a></li>
				<li><a href="article.php?category=arm">ARM</a></li>
				<li><a href="article.php?category=c">C</a></li>
				<li><a href="article.php?category=java">JAVA</a></li>
				<li><a href="article.php?category=php">PHP</a></li>
				<li><a href="article.php?category=python">PYTHON</a></li>
				<li><a href="article.php?category=html-css">HTML-CSS</a></li>
				<li><a href="article.php?category=algorithms">ALGORITHMS</a></li>
				<li><a href="article.php?category=general">GENERAL</a></li>
				<li><a href="article.php?category=projects">PROJECTS</a></li>
            <?php if($_SESSION){ ?>
            <li class="dropdown">
                <a href="javascript:void(0)" class="dropbtn" style="color: #ff5351;font-family: 'Raleway', sans-serif"><?php echo $_SESSION["username"]?> </a>
                <div class="dropdown-content">
                    <a href="profilepage.php">Profile</a>
                    <a href="settings.php">Settings</a>
                    <a href="logout.php" style="color: #f3f3f3">Logout</a>
                </div>
            </li>
            <?php } ?>
			  </ul>
</div>
<?php
if($_SESSION){ ?>
    <div class="home-page">
    <div class="form" style="background-color: whitesmoke">
        <form method="post">
            Topic<input type="text" name="topic" style="width: 100%;background-color: #fff7cd">
            Title<input type="text" name="title" style="width: 100%;background-color: #fff7cd">
            Article<textarea type="text" name="article" style="max-width: 100%;width: 100%;min-width: 100%;max-height: 200px;height: 100px;background-color: #d8ece7"></textarea><br>
            <button name="share" type="submit" value="share" style="border-style: solid;width:150px;font-size: 16px;background-color: #005cbf;color: whitesmoke;border-width: 0;border-radius: 5px;padding: 10px">Share</button>
        </form>
    </div>
<?php } ?>


    <?php
    $id = 1;
    for($id = 1;$id<=5;$id++){
    $conn=connection();
    $stmt= $conn->prepare("SELECT * FROM articles WHERE id=?");
    $stmt->bind_param("s",$id);
    $stmt->execute();
    $query = $stmt->get_result();
    $list=$query->fetch_assoc();

    if($list){
        $article_id = $list["id"];
        $username = $list["username"];
        $date = $list["date"];
        $topic = $list["topic"];
        $article = $list["article"];
        $title = $list["title"];
    }
    else{
        break;
    }

    ?>
    	<div class="form" >

        	<div id="title">
				<h1><?php echo $title?></h1>
				<p>Author:<?php echo $username?></p>
    		</div>

    	<p>
            <?php echo $article?>
        </p>


            <form class="more" action="article.php" method="get" style="max-width: 100px;margin: auto;color: white;background-color: #1f4965 ;border: none;border-radius: 10px">
                <button  name="more" value="<?php echo $article_id; ?>" style="margin: auto;background-color: #1f4965;border: 0 solid;color:white;font-family: 'Segoe UI Light',sans-serif;font-size: 18px;border-radius: 10px">READ MORE</button>
            </form>

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

    <?php } ?>

    <?php
    function get_comments_number($id){
        $conn=connection();
        $stmt= $conn->prepare("SELECT * FROM comments WHERE article_id='".$id."'");
        $stmt->execute();
        $query = $stmt->get_result();
        $num_rows = mysqli_num_rows($query);
        return $num_rows;
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
        die();
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

    if (isset($_POST['share']) and check_share()) {
        $share_username = $_SESSION["username"];
        $share_title = $_POST["title"];
        $share_article = $_POST["article"];
        $share_topic = $_POST["topic"];
        $conn = connection();
        $conn->query("INSERT INTO articles (username, title,article,topic) VALUES ('$share_username', '$share_title','$share_article','$share_topic')");
    }

    function check_share(){
        $share_title = $_POST["title"];
        $share_article = $_POST["article"];
        $share_topic = $_POST["topic"];
        if($share_title and $share_article and $share_topic){
            return 1;
        }else{
            return null;
        }
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