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
            <?php echo($_SESSION) ? '<li><a href="profile.php" style="color: cornflowerblue">HOMEPAGE</a></li>':'<li><a href="index.php" style="color: cornflowerblue">HOMEPAGE</a></li>'; ?>
            <li><a href="PAGES/arduino.php">ARDUINO</a></li>
            <li><a href="PAGES/arm.php">ARM</a></li>
            <li><a href="PAGES/c.php">C</a></li>
            <li><a href="PAGES/java.php">JAVA</a></li>
            <li><a href="PAGES/php.php">PHP</a></li>
            <li><a href="PAGES/python.php">PYTHON</a></li>
            <li><a href="PAGES/html-css.php">HTML-CSS</a></li>
            <li><a href="PAGES/algorithms.php">ALGORITHMS</a></li>
            <li><a href="PAGES/general.php">GENERAL</a></li>
            <li><a href="PAGES/projects.php">PROJECTS</a></li>
			  </ul>
</div>

<div class="home-page">

    	<div class="form" >

        	<div id="title">
				<h1>WHATS PYTHON?</h1>
				<p>Author:bakialmaci</p>
    		</div>

    	<p>
    		Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed sed pharetra augue. Morbi porta eleifend felis, in vehicula est consequat nec. Nam scelerisque finibus efficitur. Mauris ut fermentum eros. Cras sit amet lorem lacus. Cras ullamcorper mattis cursus. Maecenas eu enim in risus cursus auctor eget id orci. Sed eget mattis nulla, at vulputate risus. Aliquam lorem neque, sagittis nec luctus non, placerat a velit.

			Vivamus rutrum urna ut iaculis mollis. Etiam id efficitur sem. Pellentesque eleifend, nunc quis semper blandit, felis augue tristique mauris, ut pellentesque neque risus eget dui. Curabitur aliquet nisl id lorem tempus, sit amet pellentesque sem ornare. Nullam nec tellus quis massa pellentesque porttitor non a leo. Sed hendrerit vitae enim nec lacinia. Curabitur placerat urna at auctor faucibus. Aliquam erat volutpat. Fusce eu vestibulum magna. Sed quam lectus, consectetur sit amet diam vitae, scelerisque interdum ipsum. Pellentesque tincidunt id nisi vel volutpat. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam sagittis a ipsum ut faucibus. Etiam a nunc dolor. Praesent id bibendum enim. Lorem ipsum dolor sit amet, consectetur adipiscing elit.

			Morbi aliquet, orci sit amet dapibus porta, odio sapien aliquet mauris, vitae imperdiet velit leo ut quam. Aenean vitae mauris augue. Maecenas eget mauris luctus diam consectetur fermentum. Donec posuere cursus odio, sit amet molestie diam faucibus eu. Morbi in placerat lorem. Sed sit amet dolor nec felis vehicula maximus id et ante. In quis varius elit, a laoreet nunc.
		</p>

			<div id="info">
				<p>View:55</p>
				<p>Comment:13</p>
				<p>Date:04/08/2018</p>
				
            </div>

        </div>

        <div id="comments">
                <h2>$Username:</h2>
                <p>Muhteşem</p>
            </div>


        <div id="comment">
                <form method="post">
                    <input    id="contact-input" name="title" type="text"     placeholder="Title"/>
                    <?php echo($_SESSION) ? '<textarea id="msg-input"     name="comment"  placeholder="Write here..."></textarea>':'<textarea id="msg-input"     name="msg"  placeholder="Write here..." disabled></textarea>'; ?>
                    <?php echo($_SESSION) ? '<button   id="contact-btn"   name="send" type="submit" value="send" >SEND</button>':'<button   id="contact-btn"   name="send" type="submit" value="send" disabled  style="background: whitesmoke;color: darkgray">SEND</button>'; ?>
                </form>
            </div>

    <?php
    if($_SESSION){
        $title = $_POST["title"];
        $comment = $_POST["comment"];
        $username = $_SESSION["username"];
        $conn = connection();
        $conn->query("INSERT INTO comments (user_id, article_id,comment,title) VALUES ('$user_id', '$article_id','$comment','$title')");
        $stmt= $conn->prepare("SELECT * FROM articles WHERE id=?");
        $stmt->bind_param("s",$id);
        $stmt->execute();
        $query = $stmt->get_result();
        $list=$query->fetch_assoc();
    }
    ?>



</div>

<div class="footer">
		Copyright © 2018 Designed Baki Almacı
</div>

</body>



</html>