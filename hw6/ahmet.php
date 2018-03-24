<html>
  <head>
      <meta charset="UTF-8">
      <style>
      p {
          color: black;
          text-align: center;
      }
       body {background-color:white;}
      </style>
      <title>Read Article</title>
   </head>

   <body bgcolor="white">
     <center><h1 style="font-size:300%;" style="color:black;">Center of Article</h1></center>
     <?php
      $servername = "localhost";
      $username = "root";
      $password = "";
      $db="articles";

      $conn = new mysqli($servername, $username, $password,$db);
      if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
      }
      if(count($_GET)!=0){
        $ahmet=$_GET['page'];
        $sql = "SELECT * FROM articles WHERE id=".$ahmet;
        $result = $conn->query($sql);
        $row = $result->fetch_assoc(); ?>
        <td></td>
        <p title=baslik style="font-size:170%;"><?php echo $row["baslik"];?></p>
        <p title=Article style="font-size:120%;" ><?php echo wordwrap($row["article"],100,"<br>\n");?></p>
        <hr>
        <p title=writer><?php echo $row["writer"];?></p>
        <p title=publishdate><?php echo $row["date"];?></p>
        <hr>
        <?php
      }
     else { ?>
      <p>No Response Yet!<br>You maybe want to glance page 1 or 2 </p>
      <?php
      }  ?>
 </body>
</html>
