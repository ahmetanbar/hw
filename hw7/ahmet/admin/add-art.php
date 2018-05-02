<!DOCTYPE html>
<html>
<head>
  <title>Code Note</title>
  <link rel="stylesheet" type="text/css" href="./assets/css/add-art.css">
  <link rel="stylesheet" type="text/css" href="./assets/css/sidebar.css">
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <script src="https://cloud.tinymce.com/stable/tinymce.min.js"></script>
  <script>tinymce.init({ selector:'textarea' });</script>
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
    mysqli_set_charset($conn,"utf8");
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

      $article=htmlspecialchars($_POST['article']);
      date_default_timezone_set("Europe/Istanbul");
      $date=date("y.m.d H:i");
      $namesurname=$_SESSION['name']." ".$_SESSION['surname'];
      $stmt = $conn->prepare("INSERT INTO articles (author_id, header, article, date, category) VALUES (?, ?, ?, ?, ?)");
      $stmt->bind_param("sssss",$_SESSION['id'],$_POST['title'], $article ,$date,$_POST['category']);
      $stmt->execute();
      }
    }
  }

  session_start();
  $cookie_know=control_cookie();

  if ($cookie_know['flag']==1){
    if(!admin_control($admin)){
    header("Location:../home.php"); /* Redirect browser */
    }
  }
  else{
    header("Location:../home.php"); /* Redirect browser */
  }
  post_control();
  ?>
  <?php include 'sidebar.php'; ?>
  <div style="margin-left:25%;padding:1px 16px;height:1000px;">
    <div class="container" >
    <form action="" method="post">
      <div class="row">
          <input type="text" id="title" name="title" placeholder="Title">
      </div>
      <br>
      <div class="row">
          <select id="category" name="category">
            <option value="C">C</option>
            <option value="Java">Java</option>
            <option value="Php">Php</option>
          </select>
      </div>
      <br>
      <div class="row">
          <textarea id="subject" name="article" placeholder="Write something.." style="height:200px"></textarea>
      </div>
      <div class="row">
        <input type="submit" value="Submit">
      </div>
    </form>
  </div>
  </div>


</body>
</html>
