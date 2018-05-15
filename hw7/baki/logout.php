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
function delete_cookie(){
    if($_COOKIE and array_key_exists("auth",$_COOKIE)){
        $auth= $_COOKIE['auth'];
        $conn=connection();
        $stmt = $conn->prepare("SELECT * FROM auth WHERE cookie=?");
        $stmt->bind_param("s", $auth);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        if($row){
            $stmt = $conn->prepare("DELETE FROM auth WHERE cookie=?");
            $stmt->bind_param("s",$auth);
            $stmt->execute();
            $stmt->close();
            header("Location:login.php"); /* Redirect browser */
        }
    }
}
session_start();
session_unset();
session_destroy();
delete_cookie();
?>