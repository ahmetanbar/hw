<!DOCTYPE html>
<html>
<head>
  <title>Code Note</title>
  <link rel="stylesheet" type="text/css" href="./assets/css/panel.css">
  <link rel="stylesheet" type="text/css" href="./assets/css/sidebar.css">
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

  function get_arthead(){
    $deleted="delete";
    $conn=connect_db();
    $stmt = $conn->prepare("SELECT articles.* , user.name,user.surname FROM articles INNER JOIN users user ON articles.author_id = user.id WHERE articles.status!=? order by id desc");
    $stmt->bind_param("s", $deleted);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result;
  }

  function print_art_table(){
    $result=get_arthead();
    while ($row=$result->fetch_assoc()) {
      echo("<tr>");
      echo '<td><a href="./editarticle.php?status=edit&id='.$row['id'].'"><i class="material-icons" style:"font-size: 16px;">mode_edit</i></a><a href="./editarticle.php?status=delete&id='.$row['id'].'"><i class="material-icons" style:"font-size: 16px;">delete</i></a><a href="../article.php?id='.$row['id'].'">'.$row['header'].'</a></td>';
      echo '<td><a href="../profile.php?id='.$row['author_id'].'">'.$row['name'].' '.$row['surname'].'</a></td>';
      echo '<td>'.$row['category'].'</td>';
      echo '<td>'.$row['date'].'</td>';
      echo("</tr>");
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
  ?>
  <?php include 'sidebar.php';?>

  <div style="margin-left:25%;padding:1px 16px;height:1000px;">

    <table>
  <tr>
    <th>Title</th>
    <th>Author</th>
    <th>Category</th>
    <th>Time</th>
  </tr>
<?php print_art_table(); ?>
</table>

  </div>

<br>

<a href="../logout.php"><i style="float:left;" class="material-icons md-18">Log Out</i></a>



</body>
</html>
