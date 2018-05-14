<?php
session_start();

if(isset($_SESSION["username"])){
    $username = $_SESSION["username"];
    echo "Welcome: $username";
}
else{
    echo "Please Login. </br> <b>Redirecting...</b>";
    header( "refresh:3;url=login.php" );
}
?>