<html>
	<head>
        <link rel="stylesheet" type="text/css" href="./hw1.css">
        <meta charset="UTF-8"/>	
    </head>
	<body>
        <?php
            $yazar=$_GET["id"];
            
            $baglanti = @mysql_connect('localhost', 'kaanari1_kaan', 'hwworld');
            $veritabani = @mysql_select_db('kaanari1_hw1');
            if($baglanti && $veritabani) {
                $read = mysql_query("select title,article,etime from articles where id=$yazar");
                $list = mysql_fetch_array($read);
                
            }
        ?> 



        <div class="sayfa">
		    <div class="menuler">
			    <div id="menu"> <a href="http://hw.kaanari.com.tr/hw1/index.php?id=1">Yemekler</a></div>
			    <div id="menu"> <a href="http://hw.kaanari.com.tr/hw1/index.php?id=2">Eğlence</a></div>
			    <div id="menu"> <a href="http://hw.kaanari.com.tr/hw1/index.php?id=3">Bitcoin</a></div>
			    <div id="menu"> <a href="http://hw.kaanari.com.tr/hw1/index.php?id=4">Haberlar</a></div>
			    <div id="menu"> <a href="http://hw.kaanari.com.tr/hw1/index.php?id=0">Futbol</a></div>
            </div>
            <div class="icerik">
                <div id="title">
                    <h1>
                        <?php 
                            echo($list[0]);
                        ?>
                    </h1>
                </div>
                <div id="metin">
                        <p>
                            <?php 
                                echo($list[1]);
                            ?>
                        </p>
                </div>
                <div id="time">
                    <?php 
                        echo($list[2]);
                    ?>
                </div>
            </div>
        </div>
	</body>


</html>
