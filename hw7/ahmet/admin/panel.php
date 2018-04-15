<!DOCTYPE html>
<html>
<body>

  <?php

  function post_control(){
    if(count($_POST)!=0){
      if(array_key_exists("title",$_POST) and array_key_exists("article",$_POST)){
        $servername = "localhost";
        $db_username = "root";
        $db_password = "";
        $db="hw7";
        $conn = new mysqli($servername, $db_username, $db_password,$db);

      }
    }
  }

  post_control();
  ?>


<form action="" id="usrform" method="post">
  Title : <input type="text" name="title"><br>
  <textarea rows="4" cols="50" name="article" form="usrform">
  Enter text here...</textarea>
  <input type="submit">
</form>

<br>

<a href="logout.php"><i style="float:left;" class="material-icons md-18">Log Out</i></a>



</body>
</html>
