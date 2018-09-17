<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" type="text/css" href="ASSESTS/STYLE/contact.css">

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
?>
<h1>Contact to Socean</h1>
    <div class="form" >
        <form method="post">
            <input  id="contact-input" name="username" type="text"     placeholder="Username"/>
            <input  id="contact-input" name="mail" type="text" placeholder="Mail"/>
            <textarea id="msg-input"  name=msg placeholder="Write here..."></textarea>
            <button id="contact-btn"   name="send" type="submit" value="send" >SEND</button>
        </form>

    </div>

<?php

    $conn = connection();
    if(isset($_POST["send"]))
    {
        $conn->query("INSERT INTO contact (username, email,msg) VALUES ('".$_POST["username"]."', '".$_POST["mail"]."','".$_POST["msg"]."')");
    }


?>

<div class="footer">
		Copyright © 2018 Designed Baki Almacı
</div>

</body>
</html>