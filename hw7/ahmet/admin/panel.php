<!DOCTYPE html>
<html>
<head>
  <title>Code Note</title>
  <link rel="stylesheet" type="text/css" href="./assets/css/panel.css">
  <link rel="stylesheet" type="text/css" href="./assets/css/sidebar.css">
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>
  <?php
  $admin="admin";
  function connect_db(){
    $servername = "localhost";
    $db_username = "root";
    $db_password = "";
    $db="hw7";
    $conn = new mysqli($servername, $db_username, $db_password,$db);
    return $conn;
  }

  function admin_control($admin){
    if($_SESSION['role']==$admin){
      return TRUE;
    }
    else{return FALSE;}
  }

  function control_cookie(){
    if(count($_COOKIE)!=0 and array_key_exists("auth",$_COOKIE)){
      $auth= $_COOKIE['auth'];

      $cookie_know=array("flag"=>"FALSE");

      $conn=connect_db();

      $stmt = $conn->prepare("SELECT auth,user_id FROM cookie WHERE auth=?");
      $stmt->bind_param("s", $auth);
      $stmt->execute();
      $result = $stmt->get_result();
      $row = $result->fetch_assoc();

       if(count($row)!=0)
       {
         $cookie_know['flag']=TRUE;
         return $cookie_know;
       }
       else{
         $cookie_know['flag']=FALSE;
         return $cookie_know;
       }
    }
  }

  function post_control(){
    if(count($_POST)!=0){
      if(array_key_exists("title",$_POST) and array_key_exists("article",$_POST)){
      $conn=connect_db();
      }
    }
  }
  session_start();
  $cookie_know=control_cookie();
  if ($cookie_know['flag']==1){
    if(!admin_control($admin)){
    header("Location:../home.php"); /* Redirect browser */
    }
    else{

    }
  }
  else{
    header("Location:../home.php"); /* Redirect browser */
  }
  post_control();
  ?>


  <ul>
    <li><a class="active" href="">Home</a></li>
    <li><a href="./add-art.php">Add article</a></li>
    <li><a href="./articles.php">Articles</a></li>
    <li><a href="./members.php">Members</a></li>
    <li><a href="./auth.php">Authority</a></li>
    <li><a href="../logout.php">Log Out</a></li>
  </ul>
  <!-- <div class="main">
  <div class="content">
    <h1>asdassadsadsadsaddddddddddddddddddd</h1>
  </div>
</div> -->

  <div style="margin-left:25%;padding:1px 16px;height:1000px;">

  </div>



<br>

<a href="../logout.php"><i style="float:left;" class="material-icons md-18">Log Out</i></a>



</body>
</html>
