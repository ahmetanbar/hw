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

      $stmt = $conn->prepare("SELECT * FROM articles WHERE id=?");
      $stmt->bind_param("i", $id);
      $stmt->execute();
      $result = $stmt->get_result();
      return $result;
    }

    function get_comment(){
      $conn=connect_db();
      $stmt = $conn->prepare("SELECT * FROM comments WHERE article_id=? order by id desc limit 5");
      $stmt->bind_param("i", $_GET['id']);
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
        if(array_key_exists("namesurname",$_POST) and array_key_exists("email",$_POST) and array_key_exists("comment",$_POST)){
          $logs=array("namesurname"=>"" , "email"=>"" , "foot_note"=>"" , "input_control"=>"" , "value_name"=>"" , "value_comment"=>"" , "value_email"=>"");
          if($_POST['namesurname']!=NULL and $_POST['email']!=NULL and $_POST['comment']!=NULL){
            $verify_cont=0;
            $logs['value_comment']=$_POST['comment'];
            //name regular expression control
            $subject = $_POST['namesurname'];
            $pattern = '/^[a-zA-Z0-9çÇğĞıIiİöÖŞşÜü_-]{3,20}$/';
            if(preg_match($pattern,$subject)){
              $verify_cont+=1;
              $logs['value_name']=$subject;
            }
            else{
              $logs['namesurname']="Write a real name!";
            }
            //email regular expression control
            if(filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
              $verify_cont+=1;
              $logs['value_email']=$subject;
            }
            else{
              $logs['email']="Write a valid email!";
            }
            //after control input
            if($verify_cont==2){
            $conn =connect_db();

            $email=strtolower($_POST['email']);
            $namesurname=$_POST['namesurname'];
            $comment=nl2br($_POST['comment']);
            $article_id=$_GET['id'];
            date_default_timezone_set("Europe/Istanbul");
            $datetime=date("y.m.d H:i");
            $user_id=0;
            $stmt = $conn->prepare("UPDATE articles SET comments=comments+1 WHERE id=?");
            $stmt->bind_param('i',$article_id);
            $stmt->execute();


            $stmt = $conn->prepare("INSERT INTO comments (user_id,article_id,namesurname,email,comment,datetime) VALUES(?,?,?,?,?,?)");
            $stmt->bind_param("iissss", $user_id, $article_id,$namesurname,$email,$comment,$datetime);
            $stmt->execute();
            }
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
    }
      for($i=0;$i<$number_box;$i++) {
        $row = $result->fetch_assoc();
        ?>

          <div class="content">
            <div class="info">
              <i style="float:left; " class="material-icons md">date_range</i>
              <a style="float:left;" href="./article.php?id=<?php echo($row['id']); ?>"><?php echo(date('d-m-Y H:i', strtotime($row['date']))); ?></a>
              <i style="float:left;" class="material-icons md" >account_balance</i>
              <a style="float:left;" href="./article.php?category=<?php echo($row['category']); ?>"><?php echo($row['category']); ?></a>
              <i style="float:left;" class="material-icons md" >account_circle </i>
              <a style="float:left; " href="./profile.php?user=<?php echo($row['username']); ?>"><?php echo($row['author']); ?></a>
              <a style="float:right;" href="./article.php?id=<?php echo($row['id']); ?>" >Viewing:<?php echo($row['viewing']); ?></a>
              <i style="float:right;" class="material-icons md">assessment</i>
              <a style="float:right;" href="./article.php?id=<?php echo($row['id']); ?>">Comments:<?php echo($row['comments']); ?></a>
              <i style="float:right;" class="material-icons md">comment</i>
              <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
            </div>

            <?php if($get_method=="id"){?>
            <div class="art_head">
              <h2><a href="./article.php?id=<?php echo($row['id']); ?>"><?php echo($row['header']); ?></a></h2>
            </div>
            <div class="article"><p><?php echo($row['article']); ?></p>
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
                  <h2><a href="./article.php?id=<?php echo($row['id']); ?>"><?php echo($row['namesurname']); ?></a></h2>
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
                <?php echo ($logs['namesurname']) ? '<span style="color:#c30000;">'.$logs['namesurname'].'</span><br>':''; ?>
                <input value="<?php echo ($logs['value_name']) ? $logs['value_name'] : '' ;?>" type="text" id="namesurname" name="namesurname" placeholder="Name,Surname*">
                <label for="lname"></label>
                <?php echo ($logs['email']) ? '<span style="color:#c30000;">'.$logs['email'].'</span><br>':''; ?>
                <input value="<?php echo ($logs['value_email']) ? $logs['value_email'] : '' ;?>" type="text" id="email" name="email" placeholder="E-mail* (It will not be seen.)">
                <input type="submit" value="Send">
              </form>
            </div>
        <?php } ?>
    <?php include 'footer.php';?>
  </div>
</body>
</html>
