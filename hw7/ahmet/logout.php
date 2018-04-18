<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
</head>
<body>
  <?php
  function connect_db(){
    $servername = "localhost";
    $db_username = "root";
    $db_password = "";
    $db="hw7";
    $conn = new mysqli($servername, $db_username, $db_password,$db);
    return $conn;
  }

  function delete_cookie(){
        if(count($_COOKIE)!=0 and array_key_exists("auth",$_COOKIE)){
          $auth= $_COOKIE['auth'];
          $conn=connect_db();
          $stmt = $conn->prepare("SELECT auth FROM cookie WHERE auth=?");
          $stmt->bind_param("s", $auth);
          $stmt->execute();
          $result = $stmt->get_result();
          $row = $result->fetch_assoc();

           if(count($row)!=0)
           {
             $stmt = $conn->prepare("DELETE FROM cookie WHERE auth=?");
             $stmt->bind_param("s",$auth);
             $stmt->execute();
             $stmt->close();
             header("Location:home.php"); /* Redirect browser */
           }
        }
      }
      session_start();
      session_unset();
      session_destroy();
      delete_cookie();
  ?>
</body>
</html>
