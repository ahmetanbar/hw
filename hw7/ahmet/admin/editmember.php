<!DOCTYPE html>
<html>
<head>
  <title>Code Note</title>
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

  function get_control(){
    if(count($_GET)!=0){
      if(array_key_exists("id",$_GET) and array_key_exists("status",$_GET)){
        if($_GET["id"]!=NULL and $_GET["status"]!=NULL){
            $member_id=$_GET["id"];
            $conn=connect_db();
            $stmt = $conn->prepare("SELECT * FROM users WHERE id=?");
            $stmt->bind_param("i", $member_id);
            $stmt->execute();
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();
            if(count($row)!=0){
              $status=$_GET["status"];
              update_member($member_id,$status);
            }
            else
              header("Location:./members.php"); /* Redirect browser */
        }
        else
          header("Location:./members.php");
      }
      else
        header("Location:./members.php");
    }
    else
      header("Location:./members.php"); /* Redirect browser */
  }

  function update_member($member_id,$status){
    $conn=connect_db();
    $stmt = $conn->prepare("UPDATE users SET status=? WHERE id=?");
    $stmt->bind_param('si',$status,$member_id);
    $stmt->execute();

    header("Location:./members.php");
  }

  session_start();
  $cookie_know=control_cookie();
  if ($cookie_know['flag']==1){
    if(!admin_control($admin))
      header("Location:../home.php"); /* Redirect browser */
    else
      get_control();
  }
  else
    header("Location:../home.php"); /* Redirect browser */

  ?>

</body>
</html>
