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
    function getinfo($id){
        global $usr_info;
        $conn=db_connect();
        $stmt=$conn->prepare("SELECT * FROM users WHERE id=?");
        $stmt->bind_param("s",$id);
        $stmt->execute();
        $query = $stmt->get_result();
        $usr_info=$query->fetch_assoc();
    }
    function update_userdata($id){
        $conn=db_connect();
        $stmt=$conn->prepare("SELECT * FROM users WHERE id=?");
        $stmt->bind_param("s",$id);
        $stmt->execute();
        $query = $stmt->get_result();
        $result=$query->fetch_assoc();
        if(password_verify($_POST["pwd"],$result["pwd"])){
            echo("SIFRE DOGRU");
            $newpwd=$_POST["newpwd"];
            $renewpwd=$_POST["renewpwd"];
            $name=$_POST["usr_name"];
            $surname=$_POST["usr_surname"];
            $gender=$_POST["gender"];
            $bdate=$_POST["bdate"];
            $usrtel=$_POST["usrtel"];
            $country=$_POST["country"];
            if(!(empty($_POST["newpwd"]))){
                echo("NEW PW");
            }
            if(!(empty($_POST["renewpwd"]))){
                echo("NEW PW");
            }
            if(empty($_POST["name"])){
                
            }else{
                if($_POST["name"]!=$usr_info["usr_name"]){

                }
            }
            if(empty($_POST["surname"])){
                
            }else{
                if($_POST["name"]!=$usr_info["usr_surname"]){

                }
            }
            if($_POST["gender"]!=$usr_info["gender"]){
                echo("NEW GENDER");
            }
            die();
        }else{
            echo("SIFRE YANLIS");
            die();
        }
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
        $userid=$result["id"];
        $id=$_GET["id"];
        if($userid==$id){
            if($_POST){
                update_userdata($userid);
                getinfo($id);
            }else{
                getinfo($id);
            }
        }else{
            header("Location: ./profile.php?id=$id");                                                                
            die();  
        }
    }else{
        header("Location: ./index.php");                                                                
        die();  
    }
?>
<html>
    <head>
        <meta charset="utf-8">
        <title><?php echo($usr_info["username"]);?>'s Profile</title>
        <link rel="stylesheet" href="./assest/styles/styles_profilepanel.css">
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
                    <?php
                        if((cookie_control())){
                            echo'
                                <li><a href="./logout.php" style="cursor:pointer; float: right;">Logout</a></li> 
                                <li><a class="active" href="./profile.php?id='.$userid.'" style="float:right;">Profile</a>
                            
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
            <form action="./profilepanel.php?id=<?php echo($userid);?>" method="POST">
                <div class="form1" style="user-select:none;">
                        <label><center><b style="color:darkred;">Account Information:</b></center></label><br>
                        <label><b>Username </b> </label>
                        <input class="inp2" type="text" name="username" value="<?php echo($usr_info["username"]);?>" disabled>
                        <label><b>Password <span style="color:darkred;">(*)</span></b></label>
                        <input class="inp" type="password" placeholder="Enter Password" name="pwd" required>
                        <label><b>New Password </b></label>
                        <input class="inp" type="password" name="newpwd" placeholder="Enter New Password">
                        <label><b>Retype New Password </span></b></label>
                        <input class="inp" type="password" name="renewpwd" placeholder="Enter New Password">
                        <label><b>E-mail </b></label>
                        <input class="inp2" type="email" name="mail" value="<?php echo($usr_info["email"]);?>" disabled>
                        <br>
                        
                        
                </div>
                <hr class="a">
                <div class="form1">
                        <label><center><b style="color:darkred;">Personal Information:</b></center></label><br>
                        <label><b>Name </b></label>
                        <input class="inp" type="text" name="name" value="<?php echo($usr_info["usr_name"]);?>" required>
                        <label><b>Surname </b></label>
                        <input class="inp" type="text" name="surname" value="<?php echo($usr_info["usr_surname"]);?>" required>
                        <label><b>Gender </span></b></label><br>
                        <?php
                            if($usr_info["gender"]=="Male"){
                                echo'
                                    <span class="gender">
                                    <input type="radio" name="gender" value="Male" checked> Male
                                    <input type="radio" name="gender" value="Female"> Female  
                                    <input type="radio" name="gender" value="Other"> Other
                                    </span>
                                ';
                            }
                            if($usr_info["gender"]=="Female"){
                                echo'
                                    <span class="gender">
                                    <input type="radio" name="gender" value="Male"> Male
                                    <input type="radio" name="gender" value="Female" checked> Female  
                                    <input type="radio" name="gender" value="Other"> Other
                                    </span>
                                ';
                            }
                            if($usr_info["gender"]=="Other"){
                                echo'
                                <span class="gender">
                                <input type="radio" name="gender" value="Male"> Male
                                <input type="radio" name="gender" value="Female"> Female  
                                <input type="radio" name="gender" value="Other" checked> Other
                                </span>
                            ';
                            }
                        
                        ?>
                        <br>
                        <label><b>Birthday </b></label>
                        <input class="inp" type="text" value="<?php echo($usr_info["bdate"]);?>" onfocus="(this.type='date')" onblur="(this.type='text')" id="date" name="bdate" required>
                        <label><b>Tel Number <span style="color:darkred;"></span></b></label>
                        <input class="inp" type="text" name="usrtel" placeholder="Enter Phone Number" value="<?php echo($usr_info["usr_phone"]);?>">
                        <label><b>Country</b></label>
                        <input class="inp" type="text" placeholder="Enter Country" name="country" value="<?php echo($usr_info["country"]);?>">                      
                        <br>
                        
                        
                </div>
                <hr class="a">
                <div class="form1">
                        <label><center><b style="color:darkred;">Additional Information:</b></center></label><br>
                        <label><b>Profile Photo</b></label>
                        <center><div style="background-image:url(./assest/img/profile_default.png);border-radius:10px;margin-top:10px;height:175px;width:150px;overflow:hidden;background-position:center;background-repeat:no-repeat;background-size:cover;"></div></center><br>
                        <center><label class="uploadbtn" for="ppimg">Browse...</label></center>
                        <input style="z-index:-1; position:absolute; opacity:0;" type="file" name="ppimg" id="ppimg" accept=".jpg, .jpeg, .png">
                        <input class="sgninbtn" type="submit" value="SAVE">
                        <br>
                        
                </div>
                </form>
                
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