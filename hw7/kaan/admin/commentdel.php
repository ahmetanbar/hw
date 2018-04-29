<?php
    session_start();
    
    function db_connect(){
        $servername = "localhost";
        $usrname = "root";
        $passwd = "";
        $dbname="deneme";
        $conn = mysqli_connect($servername, $usrname, $passwd,$dbname);
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }else{
            return $conn;
        }
    }
    
    function cookie_control()
    {
        if(!(empty($_COOKIE["auth"]))&&!(empty($_SESSION))){
            $cookie=$_COOKIE["auth"];
                if($_SESSION["auth"] == $cookie){
                    $conn=db_connect();
                    $stmt=$conn->prepare("SELECT uid FROM admin WHERE username=?");
                    $stmt->bind_param("s",$_SESSION["username"]);
                    $stmt->execute();
                    $query = $stmt->get_result();
                    $result2=$query->fetch_assoc();
                    if(!(empty($result2))){
                        return True;
                    }else{
                        return False;
                    }
                }else{
                    setcookie("auth", "", time() - 3600);
                    session_destroy();
                    return False;
                }
        }else{
            return False;
        }   
    }

    function del(){
        $conn=db_connect();
        $stmt=$conn->prepare("DELETE FROM comments WHERE id=?");
        $stmt->bind_param("i",$_GET["id"]);
        $stmt->execute();
    }
    function comment_num(){
            $conn=db_connect();
            $stmt = $conn->query("SELECT * FROM comments WHERE artid=".$_GET["artid"]."");
            $comment=$stmt->num_rows;
            $stmt = $conn->prepare("UPDATE articles SET comments=? WHERE id=?");
            $stmt->bind_param("ii",$comment,$_GET["artid"]);
            $stmt->execute();
    }

    if(cookie_control()){
        $url=$_SERVER["HTTP_REFERER"];
        del();
        comment_num();
        header("Location: ".$url);
        die();
    }else{
        header("Location: ./index.php");
        die();
    }
?>
