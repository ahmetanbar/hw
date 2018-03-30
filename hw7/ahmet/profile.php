<html>
  <head>
  </head>
  <body>
    <?php
      $servername = "localhost";
      $username = "root";
      $password = "";
      $db="hw7";
      try{
      $conn = new mysqli($servername, $username, $password,$db);
      if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
      }
    }
    catch(Exception $e) {
    echo 'Message: ' .$e->getMessage();
    }
      if(count($_COOKIE)!=0){
      $key_id= $_COOKIE['key_id'];
      $user_id= $_COOKIE['user_id'];
    }

      if(count($_POST)!=0){
        $sql = "DELETE FROM cookie WHERE user_id='$user_id' AND key_id='$key_id'";
          if (mysqli_query($conn, $sql)) {

          }

        header("Location:index.php"); /* Redirect browser */
      }
      $sql = "SELECT key_id,user_id FROM cookie WHERE key_id='$key_id' AND user_id='$user_id'";
      $result = $conn->query($sql) or die($conn->error);
      $row = $result->fetch_assoc();

      if(count($row)!=0){
        $sql = "SELECT email,name FROM users WHERE id='$user_id'";
        $result = $conn->query($sql) or die($conn->error);
        $row = $result->fetch_assoc();
        echo "Hi!".$row["email"]."Welcome to your own page.";
        ?> <br><br>
        <h1>Don't Worry.You are the first of the hearts as design</h1>
        <form action="" method="post">
        <input type="submit" value="Log Out" style="padding: 16px 32px; font-size:1.5em;" name='username'>
        </form>
        <?php
      }
      else{
        echo "your requested refused!!!cCc";
      }
      ?>
  </body>
</html>
