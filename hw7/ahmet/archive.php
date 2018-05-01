<!DOCTYPE html>
<html>
<head>
  <title>Code Note</title>
  <link rel="stylesheet" type="text/css" href="./assets/css/home.css">
  <link rel="stylesheet" type="text/css" href="./assets/css/pagination.css">
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


    function get_article($page,$category){
      $deleted="delete";
      $conn=connect_db();
      $start_article=($page-1)*5;
      $sql="SELECT articles.* , user.name ,user.surname FROM articles INNER JOIN users user ON articles.author_id = user.id WHERE articles.status!=? ";
      if($category!=NULL){
        $sql=$sql." and category=? ";
      }
      $sql=$sql."order by id desc limit ?,5";
      $stmt = $conn->prepare($sql);
      if($category!=NULL){
        $stmt->bind_param("ssi",$deleted,$category,$start_article);
      }
      else
        $stmt->bind_param("si",$deleted,$start_article);
      $stmt->execute();
      $result = $stmt->get_result();
      return $result;
    }

    function get_kind(){
      if(count($_GET)!=0){
        if(array_key_exists("id",$_GET) and array_key_exists("category",$_GET)){
          return "idandcategory";
        }
        else if(array_key_exists("category",$_GET)){
          return "category";
        }
        else if(array_key_exists("id",$_GET)){
          return "id";
        }
      }
      else
        return "none";
    }

    function number_page($category){
      $deleted="delete";
      $conn=connect_db();
      $sql="SELECT COUNT(*) FROM articles WHERE status!=?";
      if($category!=NULL){
        $sql=$sql." and category=?";
      }
      $stmt = $conn->prepare($sql);
      if($category!=NULL)
        $stmt->bind_param("ss",$deleted,$category);
      else
        $stmt->bind_param("s",$deleted);
      $stmt->execute();
      $result = $stmt->get_result();
      $row = $result->fetch_assoc();
      return ceil($row['COUNT(*)']/5);
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
      $number_box=5;
      $number_page=number_page(0);
      if($get_method=="none"){
        $_GET['id']=1;
        $result=get_article($_GET['id'],0);
        if($result->num_rows<5){
          $number_box=$result->num_rows;
        }
      }
      else if($get_method=="id"){
        $result=get_article($_GET['id'],0);
        if($result->num_rows<5){
          $number_box=$result->num_rows;
        }
      }
      else if($get_method=="category"){
        $number_page=number_page($_GET['category']);
        $_GET['id']=1;
        $result=get_article(1,$_GET['category']);
        if($result->num_rows<6){
          $number_box=$result->num_rows;
        }
      }
      else if($get_method=="idandcategory"){
        $number_page=number_page($_GET['category']);
        $result=get_article($_GET['id'],$_GET['category']);
        if($result->num_rows<6){
          $number_box=$result->num_rows;
        }
      }

      for($i=0;$i<$number_box;$i++) {
        $row = $result->fetch_assoc();
        ?>

          <div class="content">
            <div class="art_head">
              <h2><a href="./article.php?id=<?php echo($row['id']); ?>"><?php echo($row['header']); ?></a></h2>
            </div>
            <div class="article" style="height: 250px; overflow: hidden;" ><p><?php echo(htmlspecialchars_decode($row['article']));?></p>
            </div>
            <div class="info">
              <i style="float:left; " class="material-icons md">date_range</i>
              <a style="float:left;" href="./article.php?id=<?php echo($row['id']); ?>"><?php echo(date('d-m-Y H:i', strtotime($row['date']))); ?></a>
              <i style="float:left;" class="material-icons md" >account_balance</i>
              <a style="float:left;" href="./archive.php?category=<?php echo($row['category']); ?>"><?php echo($row['category']); ?></a>
              <i style="float:left;" class="material-icons md" >account_circle </i>
              <a style="float:left; " href="./profile.php?id=<?php echo($row['author_id']); ?>"><?php echo($row['name'].' '.$row['surname']); ?></a>
              <a style="float:right;" href="./article.php?id=<?php echo($row['id']); ?>" >Views:<?php echo($row['viewing']); ?></a>
              <i style="float:right;" class="material-icons md">assessment</i>
              <a style="float:right;" href="./article.php?id=<?php echo($row['id']); ?>">Comments:<?php echo($row['comments']); ?></a>
              <i style="float:right;" class="material-icons md">comment</i>
            </div>
          </div>
            <br>
          <?php } ?>
          <div class="center">
            <div class="pagination">
                <?php if($_GET['id']>1){
                echo('<a href="?id='.($_GET["id"]-1));
                if(array_key_exists("category",$_GET)){
                  echo('&category='.$_GET['category']);
                }
                echo('">&laquo;</a>');
                } ?>
            <select onchange="if (this.value) window.location.href=this.value">
              <?php
               for ($i = 1; $i <= $number_page; $i++) {
                      echo "<option value='?id=$i";
                      echo(array_key_exists("category",$_GET)) ? "&category=".$_GET['category']."'" :"'";
                     if ($_GET['id'] == $i) {
                           echo ' selected="selected"';
                       }
                       echo ">$i</option>";
                   }
                  ?>
            </select>

            <?php if($_GET['id']<$number_page){
            echo('<a href="?id='.($_GET["id"]+1));
            if(array_key_exists("category",$_GET)){
              echo('&category='.$_GET['category']);
            }
            echo('">&raquo;</a>');
            } ?>
            </div>


          </div>

    <?php include 'footer.php'; ?>
  </div>
</body>
</html>
