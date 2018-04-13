<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
</head>
<body>
  <?php
  function delete_cookie(){
        if(count($_COOKIE)!=0 and array_key_exists("auth",$_COOKIE)){
          $auth= $_COOKIE['auth'];
          $servername = "localhost";
          $db_username = "root";
          $db_password = "";
          $db="hw7";
          $conn = new mysqli($servername, $db_username, $db_password,$db);
          $sql = "SELECT auth FROM cookie WHERE auth='$auth'";
          $result = $conn->query($sql) or die($conn->error);
          $row = $result->fetch_assoc();
           if(count($row)!=0)
           {
              $sql = "DELETE FROM cookie WHERE auth='$auth'";
              if(mysqli_query($conn, $sql)){
                header("Location:home.php"); /* Redirect browser */
              }

           }
        }
      }
      //_SESSION can be move other place???
      delete_cookie();
  ?>
</body>
</html>
