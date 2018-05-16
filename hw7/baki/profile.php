<html>
<head>
</head>
<body>

<form method="post" enctype="multipart/form-data">
    <input type="file" name="image">
    <button type="submit" name="upload">UPLOAD IMAGE</button>
</form>

<?php
session_start();
/* ------------------------------------DATABASE CONNECTION----------------------------*/
function connection(){
    $server_name = "localhost";
    $username = "root";
    $password = "";
    $db_name="blog";
    $conn = mysqli_connect($server_name, $username, $password,$db_name);
    mysqli_set_charset($conn,"utf8");
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
    else{
        return $conn;
    }
}
/* --------------------------------------------------------------------------------------*/
if(isset($_SESSION["username"])){
    $username = $_SESSION["username"];
    $conn = connection();
    $read = $conn->query("SELECT * FROM users WHERE username='".$username."'");
    $list = mysqli_fetch_array($read);
    $userid = $list[0];
    $email = $list[3];
    $tel = $list[4];
    $age = $list[5];
    $sex = $list[6];
    echo "Welcome: <b>$username</b> </br>" ;
    echo "Email: <b>$email</b> </br>" ;
    echo "Tel Number: <b>$tel</b> </br>";
    echo "Age: <b>$age</b> </br>";
    echo "Sex: <b>$sex</b> </br>";

}
else{
    echo "Please Login. </br> <b>Redirecting...</b>";
    header( "refresh:3;url=login.php" );
}

$uzanti=array('image/jpeg','image/jpg','image/png','image/x-png','image/gif');
## Aynı Dizinde Bulunan Resimler Klasörüne Kaydet
$dizin="resimler";
if(in_array(strtolower($_FILES['resim']['type']),$uzanti)){
    move_uploaded_file($_FILES['resim']['tmp_name'],"./$dizin/{$_FILES['resim']['name']}");
## Veritabanına Bağlanalım ##
    $baglan=   mysqli_connect("localhost","root","") or die ('Sunucuya Bağlanamadım.');
    $asd=      mysqli_select_db("mertk",$baglan) or die ('Veritabanı Bağlanamadık !');
## Dosya İsmimizi Veritabanına Yazdıralım. ##
    mysqli_query("SET NAMES utf8");
    mysqli_query("SET CHARACTER SET utf8");
    mysqli_query("SET COLLATION_CONNECTION = 'utf8_general_ci'");
## Türkçe Karakter Hatası
    $db=$_FILES['resim']['name'];
## Resmimizin Adını Alalım
    $ekle=mysqli_query("INSERT INTO users (image) VALUES ('".$db."')") or die (mysqli_error());
# Blog Tablosu -> Resim Sütununa Ekleyelim.
    echo "Başarılı !";
}else{
    echo "Başarısız !";
}


//if(isset($_POST['upload'])) {
//    $target = "ASSESTS/".basename($_FILES['image']['name']);
//    $image = $_FILES["image"]["name"];
//    $conn->query("INSERT INTO users (image) VALUES ('$image')");
//    if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
//        echo  "image uploaded";
//    } else {
//        echo  "image cant uploaded.";
//    }
//}
?>

<a href="logout.php" style="color: red"><i><b>LOGOUT</b></i></a>

</body>
</html>