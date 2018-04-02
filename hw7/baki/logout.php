<?php

if(count($_COOKIE) != 0){
    if(!is_null($_COOKIE['auth'])) {
        $conn = new mysqli("localhost", "root", "", "users");
        $read = $conn->query("DELETE FROM cookies WHERE cookie='" . $auth . "'");
        $list = mysqli_fetch_array($read);
        setcookie("auth","", time()-3600);
        header("Location: ./homepage.php");
    }
}

/**
 * Created by PhpStorm.
 * User: Muhamemd Baki
 * Date: 31.03.2018
 * Time: 17:47
 */
