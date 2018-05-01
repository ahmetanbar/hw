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

  function get_comments(){
    $delete="deleted";
    $conn=connect_db();
    $stmt = $conn->prepare("SELECT comments.* , user.name,user.surname FROM comments INNER JOIN users user ON comments.user_id = user.id WHERE comments.status!=? order by id desc");
    $stmt->bind_param('s',$delete);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result;
  }

  function print_comment_table(){
    $result=get_comments();
    while ($row=$result->fetch_assoc()) {
      echo("<tr>");
      echo '<td><a href="../article.php?id='.$row['article_id'].'">'.$row['article_id'].'</a></td>';
      echo '<td><a href="../profile.php?id='.$row['user_id'].'">'.$row['name'].' '.$row['surname'].'</td>';
      echo '<td>'.$row['comment'].'</td>';
      echo '<td>'.$row['datetime'].'</td>';
      if($row['status']=="notapprove")
        echo '<td>Not approved<a href="./editcomment.php?status=approve&id='.$row['id'].'"><i class="material-icons" style:"font-size: 16px;">check</i></a><a href="./editcomment.php?status=deleted&id='.$row['id'].'"><i class="material-icons" style:"font-size: 16px;">delete</i></a></td>';
      if($row['status']=="approve")
        echo '<td>Approved<a href="./editcomment.php?status=notapprove&id='.$row['id'].'"><i class="material-icons" style:"font-size: 16px;">cancel</i></a><a href="./editcomment.php?status=deleted&id='.$row['id'].'"><i class="material-icons" style:"font-size: 16px;">delete</i></a></td>';
      if($row['status']=="deleted")
          echo '<td>Deleted<a href="./editcomment.php?status=notapprove&id='.$row['id'].'"><i class="material-icons" style:"font-size: 16px;">sync</i></a></td>';
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
    <th>Article ID</th>
    <th>User ID</th>
    <th>Comment</th>
    <th>Datetime</th>
    <th>Status</th>
  </tr>
<?php print_comment_table(); ?>
</table>

  </div>

<br>

<a href="../logout.php"><i style="float:left;" class="material-icons md-18">Log Out</i></a>



</body>
</html>
