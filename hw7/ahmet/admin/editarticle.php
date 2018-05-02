<!DOCTYPE html>
<html>
<head>
  <title>Code Note</title>
  <script src="https://cloud.tinymce.com/stable/tinymce.min.js"></script>
  <script>tinymce.init({ selector:'textarea' });</script>
  <link rel="stylesheet" type="text/css" href="./assets/css/panel.css">
  <link rel="stylesheet" type="text/css" href="./assets/css/sidebar.css">
    <link rel="stylesheet" type="text/css" href="./assets/css/add-art.css">
  <link rel="stylesheet" type="text/css" href="./assets/css/articles.css">
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
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
    mysqli_set_charset($conn,"utf8");
    return $conn;
  }

  function admin_control(){
    if($_SESSION['role']=="admin"){
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

  function get_control(){
    if(count($_GET)!=0){
      if(array_key_exists("id",$_GET) and array_key_exists("status",$_GET)){
        if($_GET["id"]!=NULL and $_GET["status"]!=NULL){
            $art_id=$_GET["id"];
            $conn=connect_db();
            $stmt = $conn->prepare("SELECT id,article,header,category FROM articles WHERE id=?");
            $stmt->bind_param("i", $art_id);
            $stmt->execute();
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();
            if(count($row)!=0){
              $status=$_GET["status"];
              if($status=="delete"){
                update_art($art_id,$status);
              }
              if($status=="edit"){
                return $row;
              }
            }
            else
              header("Location:./articles.php"); /* Redirect browser */
        }
        else
          header("Location:./articles.php");
      }
      else
        header("Location:./articles.php");
    }
    else
      header("Location:./articles.php"); /* Redirect browser */
  }

  function post_control($id){
    if(count($_POST)!=0){
      if(array_key_exists("article",$_POST) and array_key_exists("category",$_POST) and array_key_exists("title",$_POST)){
        if($_POST["article"]!=NULL and $_POST["category"]!=NULL and $_POST["title"]!=NULL){
          $conn=connect_db();
          $article=htmlspecialchars($_POST['article']);
          $stmt = $conn->prepare("UPDATE articles SET article=? , header=? , category=? WHERE id=?");
          $stmt->bind_param('sssi',$_POST["article"],$_POST["title"],$_POST["category"],$id);
          $stmt->execute();
          header("Refresh:0");
        }
        else
          echo("hi");
      }
      else
        header("Location:./articles.php");
    }
  }
  function update_art($art_id,$status){
    $conn=connect_db();
    $stmt = $conn->prepare("UPDATE articles SET status=? WHERE id=?");
    $stmt->bind_param('si',$status,$art_id);
    $stmt->execute();

    header("Location:./articles.php");
  }

  session_start();
  $cookie_know=control_cookie();
  if ($cookie_know['flag']==1){
    if(!admin_control()){
    header("Location:../home.php"); /* Redirect browser */
    }
    else
      $row=get_control();
      post_control($row['id']);
  }
  else{
    header("Location:../home.php"); /* Redirect browser */
  }


  ?>
  <?php include 'sidebar.php';?>

  <div style="margin-left:25%;padding:1px 16px;height:1000px;">
    <div class="container" >
    <form action="" method="post">
      <div class="row">
          <input type="text" id="title" name="title" placeholder="Title" value="<?php echo($row['header']);?>" >
      </div>
      <br>
      <div class="row">
          <select id="category" name="category">
            <option <?php echo($row['category']=="C")? 'selected="selected"':''?> value="C">C</option>
            <option <?php echo($row['category']=="Java")? 'selected="selected"':''?> value="Java">Java</option>
            <option <?php echo($row['category']=="Php")? 'selected="selected"':''?> value="Php">Php</option>
          </select>
      </div>
      <br>
      <div class="row">
          <textarea id="subject" name="article" placeholder="Write something.." style="height:200px"><?php echo(htmlspecialchars_decode($row['article']));?></textarea>
      </div>
      <div class="row">
        <input type="submit" value="Submit">
      </div>
    </form>
  </div>

  </div>

<br>

<a href="../logout.php"><i style="float:left;" class="material-icons md-18">Log Out</i></a>



</body>
</html>
