<!doctype html>
<html>
<head>
<meta charset="utf-8">
<!-- TemplateBeginEditable name="doctitle" -->
<title>Başlıksız Belge</title>

<style type="text/css">
<!--
body {
	font: 100%/1.4 Verdana, Arial, Helvetica, sans-serif;
	background-color: #FAFAFA;
	margin: auto;
	padding: 0;
	color: #000;
}

/* ~~ Öğe/etiket seçiciler ~~ */
ul, ol, dl { /* Tarayıcıların arasındaki çeşitlemelerden dolayı, listelerde dolgu ve kenar boşluğunu sıfırlamakta fayda vardır. Tutarlılık sağlamak için, istediğiniz miktarları burada veya içerdikleri liste öğelerinde (LI, DT, DD) belirtebilirsiniz. Burada yaptığınızın siz daha belirli bir seçici yazmadığınız sürece .nav listesine basamaklanacağını unutmayın. */
	padding: 0;
	margin: 0;
}
h1, h2, h3, h4, h5, h6, p {
	font-family:verdana;
	margin-top: 0;	 /* üst kenar boşluğunu kaldırmak kenar boşluklarının onları içeren div’den kaçabilecekleri bir duruma sebep olur. Kalan alt kenar boşluğu onu takip eden herhangi bir öğeden uzak tutar. */
	padding-right: 15px;
	padding-left: 15px; /* div’lerin kendisinin yerine onların içindeki öğelerin kenarlarına dolgu eklemek, herhangi bir kutu modeli matematiğinin olmamasını sağlar. Ayrıca kenar dolgulu bir yuvalanmış div de alternatif bir yöntem olarak kullanılabilir. */
}
a img { /* bu seçici, bazı tarayıcılarda görüntü bir bağla çevrelendiğinde görüntünün etrafında görüntülenen varsayılan mavi kenarlığı kaldırır */
	border: none;
}

/* ~~ Sitenizin bağlarının stili, hover efektini oluşturan seçiciler grubu da dahil olmak üzere, şu sırada kalmalıdır. ~~ */
a:link {
	color: #F2F2F2;
	text-decoration: underline; /* bağlarınıza aşırı derecede benzersiz görüneceği şekilde stil vermediğiniz sürece, hızlı görsel tanımlama olabilmesi için yapılabilecek en iyi şey alt çizgi sağlamaktır.  */
}
a:visited {
	color: #6E6C64;
	text-decoration: underline;
}
a:hover, a:active, a:focus { /* bu seçiciler grubu, bir klavye gezginine fare kullanan bir kişiyle aynı hover (üzerine gelme) deneyimini sağlayacaktır. */
	text-decoration: none;
}

/* ~~ bu sabit genişlik kabı diğer tüm div’leri çevreler~~ */
.container {
	width: 50%;
	background-color: #F2F2F2;
	position:static;
	margin: auto; /* genişlik ile eşleştirilen kenarlardaki otomatik değer, mizanpajı ortalar */
	overflow: hidden; /* bu bildirim .container öğesinin içerideki yüzdürülen sütunların nerede bittiğini anlamasını sağlar ve onları içerir */
}


.sidebar1 {
	padding-top:5%;
	padding-left:20%;
	margin:auto;
	width: 100%;
	height: 32px;
	display: table-header-group;
	background-color: #E0ECF8;
	float: left;
	
}
.content {
	padding-top:3%;
	padding-left:15%;
	margin:auto;
	width: 70%;
	background-color: #F2F2F2;
	float: left;
}


/* ~~ Bu gruplanan seçici .content alanındaki listeleri verir ~~ */
.content ul, .content ol { 
	padding: 0 15px 15px 40px; /* bu dolgu yukarıda üstbilgilerdeki ve paragraf kuralındaki sağ dolguyu yansıtır. Dolgu listelerdeki diğer öğeler arasındaki alan için alta ve satırbaşını oluşturmak için sola yerleştirilir. Bunlar istediğiniz gibi ayarlanabilir. */
}

/* ~~ Gezinme listesi stilleri (Spry gibi bir önceden yapılmış açılır pencere menüsü kullanmayı tercih ederseniz kaldırılabilir) ~~  */
.nav li{
	float:left;
	list-style-type: none;

}


ul.nav a, ul.nav a:visited { /* bu seçicileri gruplamak, bağlarınızın ziyaret edildikten sonra bile düğme görünümünü kaybetmemesini sağlar */
	padding: 5px 5px 5px 15px;
	display: block; /* bu, bağa blok özellikleri ekleyerek onu içeren LI’nın tamamının doldurmasını sağlar. Bu, alanın tümünün fare tıklatılmasına tepki vermesini sağlar. */
	width: 160px;  /*bu genişlik düğmenin tamamını IE6 için tıklatılabilir hale getirir. IE6’yı desteklemeniz gerekmiyorsa, kaldırılabilir. Bu bağdaki dolguyu yan çubuk kabınızın genişliğinden çıkararak uygun genişliği hesaplayın. */
	text-decoration: none;
	background-color: #E0ECF8;
}
ul.nav a:hover, ul.nav a:active, ul.nav a:focus { /* bu fare ve klavye gezginleri için arka plan ve metin rengini değiştirir */
	background-color: #CEE3F6;
	color: #FFF;
}

/* ~~ çeşitli float/clear sınıfları ~~ */
.fltrt {  /* bu sınıf bir öğeyi sayfanızın sağında yüzdürmek için kullanılabilir. Yüzen öğe sayfada olması gereken bir sonraki öğeden önce gelmelidir. */
	float: right;
	margin-left: 8px;
}
.fltlft { /* bu sınıf bir öğeyi sayfanızın solunda yüzdürmek için kullanılabilir. Yüzen öğe sayfada olması gereken bir sonraki öğeden önce gelmelidir. */
	float: left;
	margin-right: 8px;
}
.clearfloat { /* bu sınıf, .container öğesindeki overflow:hidden kaldırılırsa, son yüzdürülen div’i (#container öğesi içinde) takiben bir <br /> veya boş bir div’e yerleştirilebilir */
	clear:both;
	height:0;
	font-size: 1px;
	line-height: 0px;
}


-->
</style>

</head>

<body>

				<?php
				$baslik;

				$yazar=$_GET["yazar"];
				if(!$yazar)
				{
					$yazar = 1;
					$baslik = "Who will steal Android from Google?";
				}


				else if ($yazar == 1)
				{
					$baslik = "Who will steal Android from Google?";
				}
				else if ($yazar == 2)
				{
					$baslik = "AI";
				}
				else if ($yazar == 3)
				{
					$baslik = "Flakka";
				}
				else{
					$yazar = 1;
					$baslik = "Who will steal Android from Google?";
				}
				?>

<div class="container">
  <div class="sidebar1">
    <center><ul class="nav">
      <li><a href="http://localhost/index.php?yazar=1">Android & Google</a></li>
      <li><a href="http://localhost/index.php?yazar=2">Artifical Intelligence</a></li>
      <li><a href="http://localhost/index.php?yazar=3">Whats Flakka</a></li>
    </ul></center>
	<!-- end .sidebar1 --></div>
  <div class="content">
  
    <center> <h1> <?php echo ($baslik) ?> </h1> </center>
<p>

				<?php
				$baglanti = @mysql_connect('localhost', 'root', '');
				$veritabani = @mysql_select_db('authors');?>
				

				<font face="tahoma" size="3" color="red"> 
				<?php
				if (!($baglanti && $veritabani))
				{
				echo 'Bağlantı kurulamadı.<br>';
				}?>


				<font face="tahoma" size="3" color="maroon">
				<?php
				$read = mysql_query("select * from authors");
				while($list = mysql_fetch_array($read))
				{
					
					echo "$list[$yazar] <br>";
				}
				mysql_close($baglanti);?> </p>
<!-- end .content --></div>

<!-- end .sidebar2 --></div>
  <!-- end .container --></div>
</body>
</html>
