
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
                    <div class="infoart"><h5><span class="iconb">Rating: </span><span class="iconc"><?php echo($article["rating"])?></span><img alt="Views" class="icona" src="./assest/img/eye.png"><span class="iconc"><?php echo($article["views"])?></span><img alt="Comments" class="icona" src="./assest/img/comment.png"><span class="iconc"><?php echo($article["comments"])?></span><span class="stars2"><a style="text-decoration:none;" href="./profile.php?id=<?php echo($article["uid"])?>"><img class="icona" alt="Author" src="./assest/img/account.png"><span class="iconc"><?php echo($writer)?></span></a></span></h5></div>
                </div>
                <center><div class="author"><a style="text-decoration:none;" href="./profile.php?id=<?php echo($article["uid"])?>"><h5><img class="icona" src="./assest/img/account.png"><span class="iconc"><?php echo($writer)?></span></h5></a></div></center>
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