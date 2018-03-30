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
     else{
       echo "succesful";
     }
   }
   catch {

   }

     if(count($_POST)!=0){
       $name=$_POST['name'];
  	   $surname=$_POST['surname'];
  	   $email=$_POST['email'];
       $sql = "INSERT INTO users (name,surname,email) VALUES('$name','$surname','$email')";
       if ($conn->query($sql) === TRUE) {
       echo("succesful");
       }
       else{
         echo("unsuccessful");
       }
     } ?>
  </body>

</html>
