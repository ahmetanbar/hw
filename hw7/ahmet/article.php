<!DOCTYPE html>
<html>
<head>
  <title>Code Note</title>
  <link rel="stylesheet" type="text/css" href="./assets/css/home.css">
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

    function control_cookie(){
      if(count($_COOKIE)!=0 and array_key_exists("auth",$_COOKIE)){
        $auth= $_COOKIE['auth'];

        $cookie_know=array("flag"=>"FALSE","username"=>"","name"=>"","surname"=>"");

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

    function get_article($id){
      $conn=connect_db();
      $stmt = $conn->prepare("SELECT * FROM articles WHERE id=?");
      $stmt->bind_param("s", $id);
      $stmt->execute();
      $result = $stmt->get_result();
      return $result;
    }

    function get_articles($category){
      $conn=connect_db();
      $stmt = $conn->prepare("SELECT * FROM articles WHERE category=? order by id desc limit 6");
      $stmt->bind_param("s", $category);
      $stmt->execute();
      $result = $stmt->get_result();
      return $result;
    }

    function get_kind(){
      if(count($_GET)!=0){
        if(array_key_exists("id",$_GET)){
          return "id";
        }
        else if(array_key_exists("category",$_GET)){
          return "category";
        }
      }
    }

    session_start();
    $cookie_know=control_cookie();
    $get_method=get_kind();
  ?>
  <?php include 'topnav.php';?>

  <div class="main">
    <?php if($cookie_know['flag']){ ?>
    <div class="usernav">
        <a href="profile.php"><i><?php echo("@".$_SESSION['username']); ?></i></a>
        <a href="logout.php"><i style="float:left;" class="material-icons md-18">exit_to_app</i></a>
    </div>
    <br>
    <?php } ?>
    <br>
      <div class="header">
        <h1>Code Note</h1>
      </div>
      <?php
      $number_box=1;
      if($get_method=="id"){
      $result=get_article($_GET['id']);
    }
      else if($get_method=="category"){
        $result=get_articles($_GET['category']);
        $number_box=6;
      }

      for($i=0;$i<$number_box;$i++) {
        $row = $result->fetch_assoc();
        ?>

          <div class="content">
            <div class="art_head">
              <h3><a href="./article.php?id=<?php echo($row['id']); ?>"><?php echo($row['header']); ?></a></h3>
            </div>
            <div class="article"><p><?php echo($row['article']); ?></p>
            </div>
            <div class="info">
              <i style="float:left; " class="material-icons md-18">date_range</i>
              <a style="float:left;" href="./article.php?id=<?php echo($row['id']); ?>"><?php echo(date('d-m-Y H:i', strtotime($row['date']))); ?></a>
              <i style="float:left;" class="material-icons md-18" >account_balance</i>
              <a style="float:left;" href="./article.php?category=<?php echo($row['category']); ?>"><?php echo($row['category']); ?></a>
              <i style="float:left;" class="material-icons md-18" >account_circle </i>
              <a style="float:left; " href="./profile.php?user=<?php echo($row['username']); ?>"><?php echo($row['author']); ?></a>
              <a style="float:right;" href="./article.php?id=<?php echo($row['id']); ?>" >Viewing:<?php echo($row['viewing']); ?></a>
              <i style="float:right;" class="material-icons md-18">assessment</i>
              <a style="float:right;" href="./article.php?id=<?php echo($row['id']); ?>">Comments:<?php echo($row['comments']); ?></a>
              <i style="float:right;" class="material-icons md-18">comment</i>
              <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
            </div>
          </div>
            <br>
          <?php } ?>
    <?php include 'footer.php';?>
  </div>
</body>
</html>
