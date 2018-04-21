
<?php
    session_start();

    function db_connect(){
        $servername = "localhost";
        $usrname = "root";
        $passwd = "";
        $dbname="deneme";
        $conn = mysqli_connect($servername, $usrname, $passwd,$dbname);
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }else{
            return $conn;
        }
    }
    function article($id){
        $conn=db_connect();
        $stmt=$conn->prepare("SELECT * FROM articles WHERE id=?");
        $stmt->bind_param("i",$id);
        $stmt->execute();
        $query = $stmt->get_result();
        $result=$query->fetch_assoc();
        $last_article=$result;
        return $last_article;
    }
    function writer_name($id){
        $conn=db_connect();
        $stmt=$conn->prepare("SELECT username FROM users WHERE id=?");
        $stmt->bind_param("i",$id);
        $stmt->execute();
        $query = $stmt->get_result();
        $result=$query->fetch_assoc();
        return $result["username"];
    }
    $article=article($_GET["id"]);
    $writer=writer_name($article["uid"]);


?>
<html>
    <head>
        <meta charset="utf-8">
        <title><?php echo($article["title"])?> - Kaan Arı</title>
        <link rel="stylesheet" href="./assest/styles/styles_article.css">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    
    <body>
        <div class="wrapper">
            <header>
                <div  class="header"></div>
            </header>
            <div class="navbar">
                <ul>
                    <li><a href="./index.php">Home</a></li>
                    <li><a href="./archive.php">Archive</a></li>
                    <li><a href="./about.php">About</a></li>
                    <li><a href="./signup.php" style="cursor:pointer; float: right;">Sign Up</a></li> 
                    <li><a href="./login.php" style="float:right;">Login</a></li>
                </ul>
            </div>

            <div class="content">
                <div class="image" style="position:relative;background-image:url(./assest/img/article.jpg);">
                    <h3 class="title"><?php echo($article["title"])?></h3>
                </div>
                <div class="article">
                    <p><?php echo($article["body"])?></p>
                    <h5 style="float:right;">Rating: <span style="color:#333;margin-right:30px;"><?php echo($article["rating"])?></span><img class="icona" src="./assest/img/eye.png"><span style="color:darkred;margin-right:30px;margin-left:10px;"><?php echo($article["views"])?></span><img class="icona" src="./assest/img/comment.png"><span class="iconc"><?php echo($article["comments"])?></span><img class="icona" src="./assest/img/account.png"><span class="iconc"><?php echo($writer)?></span></h5>
                </div>
                <hr>
                <div class="comment">
                    <h3 style="vertical-align:middle;color:lightgrey;" >Comments</h3>
                    <hr style="background-color:#333; border-color:#333;">
                </div>
            </div>
                <footer>
                    <div  class="footer">
                        <center>
                            <ul>
                                <li><a id="in1" href="http://wwww.facebook.com/kaan.ari.tr"><img style="height:30px; width:30px;" src="./assest/img/face5.png"/></a></li>
                                <li><a id="in2" href="https://twitter.com/kaanaritr"><img style="height:30px; width:30px;" src="./assest/img/twitter6.png"/></a></li>
                                <li><a id="in3" href="https://www.tumblr.com/login?redirect_to=%2Fblog%2Fengineerofhctp"><img style="height:30px; width:30px;" src="./assest/img/tumblr5.png"/></a></li>
                            </ul>
                        </center>
                    </div>
                </footer>
        </div>
    </body>
</html>