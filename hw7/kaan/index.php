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
    function cookie_control()
    {
        if(!(empty($_COOKIE["auth"]))){
            $cookie=$_COOKIE["auth"];
            if($_SESSION["auth"] == $cookie){
                return True;
            }else{
                setcookie("auth", "", time() + 3600);
                session_destroy();
                return False;
            }
        }else{
            return False;
        }
        
    }
    function last_id(){
        $conn=db_connect();

        $result = mysqli_insert_id($conn);
        return $result;
    }
    function article_puller($article){
        $query="SELECT title,article,authorid,imgurl FROM articles WHERE id LIKE '" . mysqli_escape_string($article) . "'";
        $result = mysqli_query($conn, $query);

    }
    $last_article=last_id();
    $cookie=cookie_control();
    if($cookie==True){
        $conn=db_connect();
        $stmt=$conn->prepare("SELECT id FROM users WHERE username=?");
        $stmt->bind_param("s",$_SESSION["username"]);
        $stmt->execute();
        $query = $stmt->get_result();
        $result=$query->fetch_assoc();
        $id=$result["id"];
    }
?>
<html>
    <head>
        <meta charset="utf-8">
        <title>Ana Sayfa - Kaan ARI</title>
        <link rel="stylesheet" href="./assest/styles/styles_main.css">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    
    <body>
        <div class="wrapper">
            <header>
                <div  class="header"></div>
            </header>
            <div class="navbar">
                <ul>
                    <li><a class="active" href="./index.php">Home</a></li>
                    <li><a href="./archive.php">Archive</a></li>
                    <li><a href="./about.php">About</a></li>
                    <?php
                        if((cookie_control())){
                            echo'
                                <li><a href="./logout.php" style="cursor:pointer; float: right;">Logout</a></li> 
                                <li><a href="./profile.php?id='.$id.'" style="float:right;">Profile</a>
                            
                            ';
                        }else{
                            echo'
                                <li><a href="./signup.php" style="cursor:pointer; float: right;">Sign Up</a></li> 
                                <li><a href="./login.php" style="float:right;">Login</a>         
                            ';
                        }

                    ?>
                    </li>
                </ul>
            </div>


            <div class="content">
                <div class="rightcnt">
                    <a style="text-decoration:none;" href="makale.php?article=<?php echo("5")?>">
                        <div style="position:relative;">
                            <img src="./assest/img/header3.jpg"/>
                            <div class="articlebtn">
                                <h3>READ MORE</h3>
                            </div>
                        </div>
                    </a>
                    <div>
                        <h3>BAŞLIK</h3>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas sit amet pretium urna. Vivamus venenatis velit nec neque ultricies, eget elementum magna tristique. Quisque vehicula, risus eget aliquam placerat, purus leo tincidunt eros, eget luctus quam orci in velit. Praesent scelerisque tortor sed accumsan convallis.</p>
                        <h5>Rating: <span style="color:red;margin-right:30px;">2</span> Views: <span style="color:red;margin-right:30px;">2</span> Comments: <span style="color:red;margin-right:30px;">5</span> Author: <span style="color:red;">Kaan ARI</span></h5>
                    </div>
                </div>
                <hr>
                <div class="leftcnt">
                    <a style="text-decoration:none;" href="makale.php?1">
                        <div style="position:relative;">
                            <img src="./assest/img/header3.jpg"/>
                            <div class="articlebtn2">
                                <h3>READ MORE</h3>
                            </div>
                        </div>
                    </a>
                    <div>
                        <h3>DENEME</h3>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas sit amet pretium urna. Vivamus venenatis velit nec neque ultricies, eget elementum magna tristique. Quisque vehicula, risus eget aliquam placerat, purus leo tincidunt eros, eget luctus quam orci in velit. Praesent scelerisque tortor sed accumsan convallis.</p>
                        <h5>Author: <span style="color:red;margin-right:30px;">Kaan ARI</span> Comments: <span style="color:red;margin-right:30px;">5</span> Views: <span style="color:red;margin-right:30px;">2</span> Rating: <span style="color:red;margin-right:30px;">2</span></h5>

                    </div>
                </div>
                <hr>
                <div class="rightcnt">
                    <a style="text-decoration:none;" href="makale.php?1">
                    <div style="position:relative;">
                        <img src="./assest/img/header3.jpg"/>
                        <div class="articlebtn">
                            <h3>READ MORE</h3>
                        </div>
                    </div>
                    </a>
                    <div>
                        <h3>Code Day</h3>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas sit amet pretium urna. Vivamus venenatis velit nec neque ultricies, eget elementum magna tristique. Quisque vehicula, risus eget aliquam placerat, purus leo tincidunt eros, eget luctus quam orci in velit. Praesent scelerisque tortor sed accumsan convallis.Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas sit amet pretium urna. Vivamus venenatis velit nec neque ultricies, eget elementum magna tristique. Quisque vehicula, risus eget aliquam placerat, purus leo tincidunt eros, eget luctus quam orci in velit. Praesent scelerisque tortor sed accumsan convallis.Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas sit amet pretium urna. Vivamus venenatis velit nec neque ultricies, eget elementum magna tristique. Quisque vehicula, risus eget aliquam placerat, purus leo tincidunt eros, eget luctus quam orci in velit. Praesent scelerisque tortor sed accumsan convallis.

                                
                        </p>
                        <h5>Rating: <span style="color:red;margin-right:30px;">2</span> Views: <span style="color:red;margin-right:30px;">2</span> Comments: <span style="color:red;margin-right:30px;">5</span> Author: <span style="color:red;">Kaan ARI</span></h5>

                    </div>
                </div>
                <hr>
                <div class="leftcnt">
                    <a style="text-decoration:none;" href="makale.php?1">
                        <div style="position:relative;">
                            <img src="./assest/img/header3.jpg"/>
                            <div class="articlebtn2">
                                <h3>READ MORE</h3>
                            </div>
                        </div>
                    </a>
                    <div>
                        <h3>ÖZEL GÜN</h3>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas sit amet pretium urna. Vivamus venenatis velit nec neque ultricies, eget elementum magna tristique. Quisque vehicula, risus eget aliquam placerat, purus leo tincidunt eros, eget luctus quam orci in velit. Praesent scelerisque tortor sed accumsan convallis.</p>
                        <h5>Author: <span style="color:red;margin-right:30px;">Kaan ARI</span> Comments: <span style="color:red;margin-right:30px;">5</span> Views: <span style="color:red;margin-right:30px;">2</span> Rating: <span style="color:red;margin-right:30px;">2</span></h5>
                    </div>
                </div>
                <hr>
                <div class="rightcnt">
                    <a style="text-decoration:none;" href="makale.php?1">
                        <div style="position:relative;">
                            <img src="./assest/img/header3.jpg"/>
                            <div class="articlebtn">
                                <h3>READ MORE</h3>
                            </div>
                        </div>
                    </a>
                    <div>
                        <h3>DENEME UZUN SDADADADAFD FDSFSF GDSGSGSG</h3>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas sit amet pretium urna. Vivamus venenatis velit nec neque ultricies, eget elementum magna tristique. Quisque vehicula, risus eget aliquam placerat, purus leo tincidunt eros, eget luctus quam orci in velit. Praesent scelerisque tortor sed accumsan convallis.</p>
                        <h5>Rating: <span style="color:red;margin-right:30px;">2</span> Views: <span style="color:red;margin-right:30px;">2</span> Comments: <span style="color:red;margin-right:30px;">5</span> Author: <span style="color:red;">Kaan ARI</span></h5>

                    </div>
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