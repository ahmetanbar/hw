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
                <a href="javascript:void(0)" class="dropbtn" style="color: #a6e1ec"><?php echo $_SESSION["username"]?> </a>
                <div class="dropdown-content">
                    <a href="profilepage.php">Profile</a>
                    <a href="settings.php">Settings</a>
                    <a href="logout.php" style="color: red">Logout</a>
                </div>
            </li>
            <?php } ?>
			  </ul>
</div>

<div class="home-page">
    <?php
//    if (isset($_SESSION["username"])){
//        header( "refresh:0;url=profile.php" );
//    }
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


            <form class="more" action="article.php" method="get" style="max-width: 100px;margin: auto;color: white;background-color: #4d4d4d;border: 0">
                <button id="more2" name="more" value="<?php echo $article_id; ?>" style="max-width: 100px;margin: auto;background-color: #4d4d4d;border: 0 solid;color:white">READ MORE</button>
            </form>

			<div id="info">
				<p>View:<?php echo "UNSET";?></p>
				<p>Comment:<?php echo "UNSET";?></p>
				<p>Date:<?php echo $date?></p>
			</div>
		
		</div>

    <?php } ?>

</div>

<div class="footer">
		Copyright © 2018 Designed Baki Almacı
</div>

</body>
</html>