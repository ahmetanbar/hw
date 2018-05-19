<!doctype html>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">

		<title>Ana Sayfa</title>
		<link rel="stylesheet" href="styles.css">
		<link rel="shortcut icon" href="icon.ico">
	</head>

	<body>
		<div class="table">
			<div class="banner">
			
			</div>
			<div class="menu">
				<div class="image">

				</div>
				<div>
					<header>
						<nav class="header">
							<ul>
								<li><a href="#">Ana Sayfa</a></li>
								<li><a href="./projeler.html">Projeler</a></li>
								<li><a href="./projeler.html">Makaleler</a></li>
								<li><a href="./projeler.html">Eğitimler</a></li>
								<li><a href="./projeler.html">Hakkımda</a></li>
								@if (Route::has('login'))
                    			@auth
                        		<a href="{{ url('/home') }}">Home</a>
                    			@else
                        		<a href="{{ route('login') }}">Login</a>
                        		<a href="{{ route('register') }}">Register</a>
                    			@endauth
            					@endif
								<li><a href="./iletisim.html">İletişim</a></li>
							</ul>
						</nav>
					</header>
				</div>
			</div>	
			<div class="type">
				<pre>denemememememmememeemem
				edsdsdsdsdksdkskdksdksdksdkskdkskkdskdskdkssssssdenemememememmememeemem
				edsdsdsdsdksdkskdksdksdksdkskdkskkdskdskdkssssssdenemememememmememeemem
				edsdsdsdsdksdkskdksdksdksdkskdkskkdskdskdkssssssdenemememememmememeemem
			edsdsdsdsdksdkskdksdksdksdkskdkskkdskdskdkssssssdenemememememmememeemem
			edsdsdsdsdksdkskdksdksdksdkskdkskkdskdskdkssssssdenemememememmememeemem
			edsdsdsdsdksdkskdksdksdksdkskdkskkdskdskdkssssssdenemememememmememeemem
			edsdsdsdsdksdkskdksdksdksdkskdkskkdskdskdkssssssdenemememememmememeemem
			edsdsdsdsdksdkskdksdksdksdkskdkskkdskdskdkssssssdenemememememmememeemem
			edsdsdsdsdksdkskdksdksdksdkskdkskkdskdskdkssssssdenemememememmememeemem
			edsdsdsdsdksdkskdksdksdksdkskdkskkdskdskdkssssssdenemememememmememeememsssssssssssssssssssssssssssssssdadada
			
			edsdsdsdsdksdkskdksdksdksdkskdkskkdskdskdkssssssdenemememememmememeemem
			edsdsdsdsdksdkskdksdksdksdkskdkskkdskdskdkssssssdenemememememmememeemem
			edsdsdsdsdksdkskdksdksdksdkskdkskkdskdskdkssssss
			a
			a
			a
			a
			a
			a
			
			a
			a
			a
			a
			a
			
			a
			a
			a
			a
			a
			a
			a
			
			a
			a
			a
			a
			a
			
			a
			a
			
			a
			a
			a
			a
			a
				</pre>
			</div>	
		</div>
		<footer>
			<div class="end">
				<div id="sutun">
				<div class="ic1"><a href="http://wwww.facebook.com/kaan.ari.tr"><img onmouseover="this.src='face5.png'" onmouseout="this.src='face2.png'" style="height:30px; width:30px;" src="face2.png"/></a></div>
				<div class="ic1"><a href="http://www.twitter.com/kaanaritr"><img onmouseover="this.src='twitter6.png'" onmouseout="this.src='twitter2.png'" style="height:30px; width:30px;" src="twitter2.png"/></a></div>
				<div class="ic1"><a href="http://www.tumblr.com/blog/engineerofhctp"><img onmouseover="this.src='tumblr5.png'" onmouseout="this.src='tumblr2.png'" style="height:30px; width:30px;" src="tumblr2.png"/></a></div>
			</div>
			</div>
		</footer>
	</body>
</html>
