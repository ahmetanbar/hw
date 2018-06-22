<!DOCTYPE html>
<html>
<head>
  <title>Code Note</title>
  <link rel="stylesheet" type="text/css" href="./assets/css/home.css">
  <link rel="stylesheet" type="text/css" href="./admin/assets/css/add-art.css">
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
      else
        header("Location:home.php");
    }

    function get_article(){
      $conn=connect_db();
      $sql = "SELECT * FROM articles order by id desc limit 5";
      $result = $conn->query($sql);
      return $result;
    }

    function post_control(){

      if(count($_POST)!=0){
        if(array_key_exists("article",$_POST) and array_key_exists("category",$_POST) and array_key_exists("title",$_POST)){
          $logs=array("article"=>"","title"=>"","category"=>"","value_article"=>"","value_category"=>"","value_title"=>"");
          if($_POST['article']!=NULL and $_POST['title']!=NULL and $_POST['category']!=NULL){
            $conn =connect_db();
            date_default_timezone_set("Europe/Istanbul");
            $date=date("y.m.d H:i");
            $article=(htmlspecialchars($_POST['article']));
            $stmt = $conn->prepare("INSERT INTO articles (author_id,header,article,date,category) VALUES(?,?,?,?,?)");
            $stmt->bind_param("sssss", $_SESSION['id'], $_POST['title'],$article,$date,$_POST['category']);
            $stmt->execute();
            header("Location:home.php"); /* Redirect browser */
          }
          else{
            $logs['foot_note']="Complete All of Them!";
          }
          return $logs;
        }
      }
    }

    session_start();
    $cookie_know=control_cookie();
    post_control();

  ?>
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

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
    <br>
    <?php include 'footer.php';?>
  </div>

</body>
</html>
