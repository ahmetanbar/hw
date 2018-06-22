<!DOCTYPE html>
<html>
<head>
  <title>Code Note</title>
  <link rel="stylesheet" type="text/css" href="./assets/css/home.css">
  <link rel="stylesheet" type="text/css" href="./assets/css/article.css">
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
      $stmt = $conn->prepare("UPDATE articles SET viewing=viewing+1 WHERE id=?");
      $stmt->bind_param('i',$id);
      $stmt->execute();
      $status_art="delete";
      $stmt = $conn->prepare("SELECT articles.* , user.name ,user.surname FROM articles INNER JOIN users user ON articles.author_id = user.id WHERE articles.id=? and articles.status!=?");
      $stmt->bind_param("is", $id,$status_art);
      $stmt->execute();
      $result = $stmt->get_result();
      return $result;
    }

    function get_comment(){
      $status="approve";
      $conn=connect_db();
      $stmt = $conn->prepare("SELECT comments.* , user.name,user.surname FROM comments INNER JOIN users user ON comments.user_id = user.id WHERE comments.article_id=? and comments.status=? order by id desc");
      $stmt->bind_param("is", $_GET['id'],$status);
      $stmt->execute();
      $result = $stmt->get_result();
      return $result;
    }

    function get_kind(){
      if(count($_GET)!=0){
        if(array_key_exists("id",$_GET)){
          return "id";
        }
      }
    }

    function comment_post(){
      if(count($_POST)!=0){
        if(array_key_exists("comment",$_POST)){
          $logs=array("value_comment"=>"","foot_note"=>"");
          if( $_POST['comment']!=NULL){
            $verify_cont=0;
            $conn =connect_db();

            $comment=nl2br($_POST['comment']);
            $article_id=$_GET['id'];
            date_default_timezone_set("Europe/Istanbul");
            $datetime=date("y.m.d H:i");
            $user_id=$_SESSION['id'];
            $status="notapprove";
            $stmt = $conn->prepare("INSERT INTO comments (user_id,article_id,comment,datetime,status) VALUES(?,?,?,?,?)");
            $stmt->bind_param("iisss", $user_id, $article_id,$comment,$datetime,$status);
            $stmt->execute();
          }
          else{
            $logs['foot_note']="Complete All!";
          }
          return $logs;
        }
      }
    }

    session_start();

    $cookie_know=control_cookie();
    $get_method=get_kind();

    $logs=comment_post();


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
      if($result->num_rows==0)
        header("Location:./home.php");
    }
    else{
      header("Location:./home.php");
    }
      for($i=0;$i<$number_box;$i++) {
        $row = $result->fetch_assoc();
        ?>

          <div class="content">
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
              <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
            </div>

            <?php if($get_method=="id"){?>
            <div class="art_head">
              <h2><a href="./article.php?id=<?php echo($row['id']); ?>"><?php echo($row['header']); ?></a></h2>
            </div>
            <div class="article"><p><?php echo(htmlspecialchars_decode($row['article']));?></p>
            </div>
            <?php }?>
          </div>
            <br>
          <?php }

          $result=get_comment();
          $number_comment=$result->num_rows;

          for($i=0;$i<$number_comment;$i++) {
            $row = $result->fetch_assoc();
            ?>

              <div class="comments">
                  <i style="float:left;" class="material-icons md-80">person</i>
                <div class="art_head">
                  <h2><a href="./profile.php?id=<?php echo($row['user_id']); ?>"><?php echo($row['name'].' '.$row['surname']); ?></a></h2>
                  <h4><?php echo(date('d-m-Y, H:i', strtotime($row['datetime']))); ?></h4>
                </div>

                <div class="article"><p><?php echo($row['comment']); ?></p>
                </div>
              </div>
                <br>
              <?php }


          if($get_method=="id"){ ?>
            <div class="commentbox">
              <form method="post" autocomplete="off" accept-charset="UTF-8" action="">
                <?php echo ($logs['foot_note']) ? '<span style="color:#c30000;">'.$logs['foot_note'].'</span><br>':''; ?>
                <textarea id="comment" name="comment" placeholder="Write your comment.." style="height:200px"><?php echo ($logs['value_comment']) ? $logs['value_comment'] : '' ;?></textarea>


                <?php echo($cookie_know['flag']) ? '<input type="submit" value="Send">':'<span style="color:#c30000; text-align:auto; ">For comment you should <a color:red href="login.php">Log In</a></span>'; ?>

              </form>
            </div>
      <?php
      } ?>
    <?php include 'footer.php';?>
  </div>
</body>
</html>
