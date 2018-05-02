<!DOCTYPE html>
<html>
<head>
  <title>Code Note</title>
  <link rel="stylesheet" type="text/css" href="./assets/css/profile.css">
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
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

    function get_control(){
      if(count($_GET)!=0){
        if(array_key_exists("id",$_GET)){
          if($_GET["id"]!=NULL){
              $profile_id=$_GET["id"];
              $conn=connect_db();
              $stmt = $conn->prepare("SELECT * FROM users WHERE id=? and status!='delete'");
              $stmt->bind_param("i", $profile_id);
              $stmt->execute();
              $result = $stmt->get_result();
              $row = $result->fetch_assoc();

              if(count($row)!=0){
                  $user_info=array("name"=>$row["name"],"surname"=>$row["surname"],"username"=>$row["username"],"about"=>$row["about"],"photo"=>$row["photo"],"id"=>$row["id"]);
                  return $user_info;
              }
              else
                header("Location:./home.php"); /* Redirect browser */
          }
          else
            header("Location:./home.php");
        }
        else
          header("Location:./home.php");
      }
      return my_profile();
    }

    function my_profile(){
      $user_info=array("name"=>$_SESSION["name"],"surname"=>$_SESSION["surname"],"username"=>$_SESSION["username"],"about"=>$_SESSION["about"],"photo"=>$_SESSION["photo"],"id"=>$_SESSION["id"],"know"=>"own");
      return $user_info;
    }



    function get_articles($id){
      $status="delete";
      $conn=connect_db();
      $stmt = $conn->prepare("SELECT id,header FROM articles WHERE author_id=? and status!=? order by id desc limit 5");
      $stmt->bind_param('is',$id,$status);
      $stmt->execute();
      $result = $stmt->get_result();
      return $result;
    }

    function get_comments($id){
      $conn=connect_db();
      $status_app="approve";
      $artstatus="delete";
      $stmt = $conn->prepare("SELECT comments.* FROM comments INNER JOIN articles articles ON comments.article_id = articles.id WHERE  articles.status!=? and comments.user_id=? and comments.status=? order by id desc limit 5");
      $stmt->bind_param("sis",$artstatus, $id,$status_app);
      $stmt->execute();
      $result = $stmt->get_result();
      return $result;
    }

    session_start();
    $cookie_know=control_cookie();
    $split=explode("/",$_SERVER["REQUEST_URI"]);
    $whereami=$split[count($split)-1];
    if(!$cookie_know['flag'] and $whereami=="profile.php"){
      header("Location:./home.php");
    }
    else
      $user_info=get_control();


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

      <div class="row">
        <div class="column1">
          <?php
           echo(array_key_exists("know",$user_info)) ? '<a href="editprofile.php"><i style="float:left;" class="material-icons md-18">edit</i></a>':"";

          $img_source="./assets/image/profiles/";
          $img_source=$img_source.$user_info['photo'].".jpg";
          echo("<img src=".$img_source." ");
           ?>
          alt="profile" height="220" width="220">
          <h2 style="padding-top:0px;"><?php echo $user_info['name']." ".$user_info['surname'];?></h2>
          <h3 style="padding-top:0px;">@<?php echo $user_info['username']; ?></h3>
          <h5 style="padding-top:0px;"><?php echo $user_info['about']; ?></h5>
          </div>
        <div class="column2">
          <h1>Articles</h1>
          <ul>
            <?php
              $result=get_articles($user_info['id']);
              if($result->num_rows==0)
                echo "<li>Can't find any articles.</li>";
              while ($row=$result->fetch_assoc()) {
                echo '<li><a href="./article.php?id='.$row['id'].'">'.$row['header'].'</a></li>';
              }
             ?>
          </ul>
          </div>
          <div class="column2">
            <h1>Comments</h1>
            <ul>
              <?php
                $result=get_comments($user_info['id']);
                if($result->num_rows==0)
                  echo "<li>Can't find any comment.</li>";
                while ($row=$result->fetch_assoc()) {
                  echo '<li><a href="./article.php?id='.$row['article_id'].'">'.$row['comment'].'</a></li>';
                }
               ?>
            </ul>
            </div>
      </div>

    <?php include 'footer.php';?>
  </div>
</body>
</html>
