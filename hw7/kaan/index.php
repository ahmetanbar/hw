<?php
    $baglanti = @mysql_connect('localhost', 'kaanari1_kaan', 'hwworld');
    $veritabani = @mysql_select_db('kaanari1_hw1');
    if($_COOKIE["auth"]){
        //Cookie doluysa karşılaştırılacak
    }
    

            
    
    if($baglanti && $veritabani) {
        $read = mysql_query("select title,article,etime from articles where id=$yazar");
        $list = mysql_fetch_array($read);                
    }
?> 
<html>

    <head>
        <title>Ana Sayfa</title>
        <link rel="stylesheet" href="style.css">

    </head>

    <body>
        <div class="nav">
            <header>
                <nav>
                    <ul>
                        <li><a href="./index.php">Home</a></li>
                        <li><a href="./profile.php">Profile</a></li>
                    </ul>    
                </nav>
            </header>
            
        </div>
        <center><h2 class="text">Login or Signup</h2></center>
        <div style="margin:auto;width:80%;margin-top:5%;">
            <div class="box" style="margin-top:35px;float:left;padding-top:7%; height:32.5%;min-height:150px;margin-right:35%;">
                <formaction="./login.php" method="post">
                    <center>
                        <label>Username</label><br>
                        <input class="textbox" type="text" name="username"><br>
                        <label>Password</label><br>
                        <input class="textbox" type="password" name="pwd"><br>
                        <input class="button" type="submit" value="Login">
                    </center>
                </form>
            </div>
            <div class="box" style="float:right;">
                    <formaction="./signup.php" method="post">
                        <center>
                            <label>Name</label><br>
                            <input class="textbox" type="text" name="name"><br>
                            <label>Surname</label><br>
                            <input class="textbox" type="text" name="surname"><br>
                            <label>E-Mail</label><br>
                            <input class="textbox" type="text" name="email"><br>
                            <label>Username</label><br>
                            <input class="textbox" type="text" name="username"><br>
                            <label>Password</label><br>
                            <input class="textbox" type="password" name="pwd"><br>
                            <input class="button" type="submit" value="Signup"><br>
                        </center>
                    </form>
                </div>
        </div>

    </body>
