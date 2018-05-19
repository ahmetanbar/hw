<html>
<head>
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
    $conn = connection();
    $read = $conn->query("SELECT * FROM users WHERE username='".$username."'");
    $list = mysqli_fetch_array($read);
    $userid = $list[0];
    $email = $list[3];
    $tel = $list[4];
    $age = $list[5];
    $sex = $list[6];
    echo "Welcome: <b>$username</b> </br>" ;
    echo "Email: <b>$email</b> </br>" ;
    echo "Tel Number: <b>$tel</b> </br>";
    echo "Age: <b>$age</b> </br>";
    echo "Sex: <b>$sex</b> </br>";

}
else{
    echo "Please Login. </br> <b>Redirecting...</b>";
    header( "refresh:3;url=login.php" );
}
?>

<a href="logout.php" style="color: red"><i><b>LOGOUT</b></i></a>

</body>
</html>