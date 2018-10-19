<!DOCTYPE html>
<html>
<title>SOCEAN</title>
<meta charset="UTF-8">
<link href="{{asset('css/homepage.css')}}" rel="stylesheet">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<style>
    body,h1,h2,h3,h4,h5 {font-family: "Raleway", sans-serif}
</style>
<body class="w3-light-gray">

<!-- w3-content defines a container for fixed size centered content,
and is wrapped around the whole page content, except for the footer in this example -->
<header class="w3-container w3-center w3-padding-32">
    <h1><a href="homepage.blade.php" style="text-decoration: none">SOCEAN</a></h1>
    <p> <span class="w3-tag">bakialmaci</span> Welcome to Socean</p>
</header>
<div class="w3-content" style="max-width:1200px">

    <!-- Header -->


    <ul style="margin-bottom: 50px">
        <li><a href="#home">Arduino</a></li>
        <li><a href="#news">Arm</a></li>
        <li><a href="#contact">PHP</a></li>
        <li><a href="#about">HTML-CSS</a></li>
        <li><a href="#home">Python</a></li>
        <li><a href="#about">Raspberry Pi</a></li>
        <li><a href="#news">C & C++</a></li>
        <li><a href="#contact">Linux</a></li>
        <li><a href="#about">Windows</a></li>
        <li><a href="#about">Drone</a></li>
        <li><a href="#contact">Electronics</a></li>
        <li><a href="#about">General</a></li>
        <li><a href="#contact">Projects</a></li>
    </ul>


    <div class="w3-row">

        <div class="w3-col l7 s14">
            <!-- Blog entry -->
            <div class="w3-card-4 w3-margin w3-white">
                <img src='{{ asset("images/city.jpg") }}' alt="Norway" style="width:100%;float: left">
                <div class="w3-container">
                    <h3><span class="w3-tag" style="font-size: 16px">bakialmaci</span> <b>BLOG ENTRY</b>  </h3>
                    <h5>Title description, <span class="w3-opacity">April 2, 2014</span></h5>
                </div>

                <div class="w3-container">
                    <p>Mauris neque quam, fermentum ut nisl vitae, convallis maximus nisl. Sed mattis nunc id lorem euismod placerat. Vivamus porttitor magna enim, ac accumsan tortor cursus at. Phasellus sed ultricies mi non congue ullam corper. Praesent tincidunt sed
                        tellus ut rutrum. Sed vitae justo condimentum, porta lectus vitae, ultricies congue gravida diam non fringilla.</p>
                    <div class="w3-row">
                        <div class="w3-col m8 s12">
                            <p><button class="w3-button w3-padding-large w3-white w3-border"><b>READ MORE »</b></button></p>
                        </div>
                        <div class="w3-col m4 w3-hide-small">
                            <p><span class="w3-padding-large w3-right"><b>Comments  </b> <span class="w3-badge">2</span></span></p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="w3-card-4 w3-margin w3-white">
                <img src='{{ asset("images/hunrobotx.jpg") }}' alt="Norway" style="width:100%">
                <div class="w3-container">
                    <h3><span class="w3-tag" style="font-size: 16px">bakialmaci</span> <b>BLOG ENTRY</b>  </h3>
                    <h5>Title description, <span class="w3-opacity">April 2, 2014</span></h5>
                </div>

                <div class="w3-container">
                    <p>Mauris neque quam, fermentum ut nisl vitae, convallis maximus nisl. Sed mattis nunc id lorem euismod placerat. Vivamus porttitor magna enim, ac accumsan tortor cursus at. Phasellus sed ultricies mi non congue ullam corper. Praesent tincidunt sed
                        tellus ut rutrum. Sed vitae justo condimentum, porta lectus vitae, ultricies congue gravida diam non fringilla.</p>
                    <div class="w3-row">
                        <div class="w3-col m8 s12">
                            <p><button class="w3-button w3-padding-large w3-white w3-border"><b>READ MORE »</b></button></p>
                        </div>
                        <div class="w3-col m4 w3-hide-small">
                            <p><span class="w3-padding-large w3-right"><b>Comments  </b> <span class="w3-badge">2</span></span></p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="w3-card-4 w3-margin w3-white">
                <img src='{{ asset("images/robot.png") }}' alt="Norway" style="width:100%">
                <div class="w3-container">
                    <h3><span class="w3-tag" style="font-size: 16px">bakialmaci</span> <b>BLOG ENTRY</b>  </h3>
                    <h5>Title description, <span class="w3-opacity">April 2, 2014</span></h5>
                </div>

                <div class="w3-container">
                    <p>Mauris neque quam, fermentum ut nisl vitae, convallis maximus nisl. Sed mattis nunc id lorem euismod placerat. Vivamus porttitor magna enim, ac accumsan tortor cursus at. Phasellus sed ultricies mi non congue ullam corper. Praesent tincidunt sed
                        tellus ut rutrum. Sed vitae justo condimentum, porta lectus vitae, ultricies congue gravida diam non fringilla.</p>
                    <div class="w3-row">
                        <div class="w3-col m8 s12">
                            <p><button class="w3-button w3-padding-large w3-white w3-border"><b>READ MORE »</b></button></p>
                        </div>
                        <div class="w3-col m4 w3-hide-small">
                            <p><span class="w3-padding-large w3-right"><b>Comments  </b> <span class="w3-badge">2</span></span></p>
                        </div>
                    </div>
                </div>
            </div>
            <!-- END BLOG ENTRIES -->
        </div>

        <!-- Introduction menu -->
        <div class="w3-col l3" style="float: right">
            <form action="" style="margin-top: 50px">
                <input type="search" placeholder="username...">
                <i class="fa fa-search"></i>
            </form>
            <!-- About Card -->
            <div class="w3-card w3-margin w3-margin-top">
                <div class="pp">
                    <img src='{{ asset("images/pp2.jpg") }}' style="width:100%;border: 5px solid black">
                </div>

                <div class="w3-container w3-white" style="text-align: center">
                    <h4><b>Muhammed Baki Almacı</b></h4>
                    <p style="background-color: black;color: white">Hacettepe University</p>
                    <p>Electrical Electronics Engineering</p>
                    <p>Ankara/Çankaya</p>
                    <a href="#" class="settings">Settings</a>
                    <a href="login.php" class="logout">Logout</a>

                </div>
            </div><hr>

            <!-- Posts -->
            <div class="w3-card w3-margin">
                <div class="w3-container w3-padding">
                    <h4>Recent Posts</h4>
                </div>
                <ul class="w3-ul w3-hoverable w3-white">
                    <li class="w3-padding-16" style="min-width: 300px">
                        <img src='{{ asset("images/hunrobotx.jpg") }}' alt="Image" class="w3-left w3-margin-right" style="width:50px">
                        <span class="w3-large">Lorem</span><br>
                        <span>Sed mattis nunc</span>
                    </li>
                    <li class="w3-padding-16" style="min-width: 300px">
                        <img src='{{ asset("images/robot.png") }}' alt="Image" class="w3-left w3-margin-right" style="width:50px">
                        <span class="w3-large">Ipsum</span><br>
                        <span>Praes tinci sed</span>
                    </li>
                    <li class="w3-padding-16" style="min-width: 300px">
                        <img src='{{ asset("images/city.jpg") }}' alt="Image" class="w3-left w3-margin-right" style="width:50px">
                        <span class="w3-large">Dorum</span><br>
                        <span>Ultricies congue</span>
                    </li>
                </ul>
            </div>
            <hr>
            <div class="w3-card w3-margin">
                <div class="w3-container w3-padding">
                    <h4>Categories</h4>
                </div>
                <div class="w3-container w3-white">
                    <p><span class="w3-tag w3-black w3-margin-bottom">Arduino</span> <span class="w3-tag w3-light-grey w3-small w3-margin-bottom">ARM</span> <span class="w3-tag w3-light-grey w3-small w3-margin-bottom">Electronics</span>
                        <span class="w3-tag w3-light-grey w3-small w3-margin-bottom">PHP</span> <span class="w3-tag w3-light-grey w3-small w3-margin-bottom">HTML-CSS</span> <span class="w3-tag w3-light-grey w3-small w3-margin-bottom">General</span>
                        <span class="w3-tag w3-light-grey w3-small w3-margin-bottom">Python</span> <span class="w3-tag w3-light-grey w3-small w3-margin-bottom">Raspberryi Pi</span> <span class="w3-tag w3-light-grey w3-small w3-margin-bottom">Projects</span>
                        <span class="w3-tag w3-light-grey w3-small w3-margin-bottom">C&C++</span> <span class="w3-tag w3-light-grey w3-small w3-margin-bottom">Linux</span>
                        <span class="w3-tag w3-light-grey w3-small w3-margin-bottom">Windows</span> <span class="w3-tag w3-light-grey w3-small w3-margin-bottom">Drone</span>
                    </p>
                </div>
            </div>
        </div>
    </div><br>
</div>

<!-- Footer -->
<footer class="w3-container w3-dark-grey w3-padding-32 w3-margin-top">
    <button class="w3-button w3-black w3-disabled w3-padding-large w3-margin-bottom">Previous</button>
    <button class="w3-button w3-black w3-padding-large w3-margin-bottom">Next »</button>
    <p>Powered by <a href="#" target="_blank">bakialmaci</a></p>
</footer>

</body>
</html>
