<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="index.css">

</head>
<body>


<div class="banner">
    <!--<img id="banner-button" src="logo.png" alt="logo">-->

    <a href="http://facebook.com/bakialmaci">
        <img   class="social" src="facebook.png" alt="facebook" >
    </a>

    <a href="http://twitter.com/baki_almaci">
        <img   class="social" src="twitter.png" alt="Smiley face" >
    </a>

    <a href="http://linkedin.com">
        <img   class="social" src="linkedin.png" alt="Smiley face" >
    </a>


    <form>
        <button class="banner-button"  name="btn" type="submit"  value="Homepage" >HOMEPAGE </button>
        <button class="banner-button"  name="btn" type="submit"  value="Posted"> POSTED </button>
        <button class="banner-button"  name="btn" type="submit"  value="About"> ABOUT </button>
        <button class="banner-button"  name="btn" type="submit"  value="Contact"> CONTACT </button>
        <button class="banner-button"  name="btn" type="submit"  value="Login"> LOGIN </button>
        <button class="banner-button"  name="btn" type="submit"  value="Signup"> SIGNUP </button>

    </form>
    <!--<div class="vertical-menu2">-->
    <!--<a href="#">LOGIN</a>-->
    <!--<a href="#">SIGNUP</a>-->
    <!--</div>-->

</div>


<div class="vertical-menu">
    <a href="#">Projects</a>
    <a href="#">ARDUINO</a>
    <a href="#">ARM</a>
    <a href="#">Raspberry Pi</a>
    <a href="#">C Language</a>
    <a href="#">Python</a>
    <a href="#">Java</a>
    <a href="#">HTML</a>
    <a href="#">CSS</a>
    <a href="#">PHP</a>
    <a href="#">REGEX</a>
</div>



<?php
$i =0;
for($i = 0;$i<=5;$i++)
{
?>

<div class="form">
    <img class="img" src="small.jpg" alt="Smiley face">

    <h1> Lorem Ipsumun Faydaları</h1>

    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed eu odio sit amet felis pretium accumsan at a enim. In pretium viverra orci, ac vehicula velit tristique eu. Vestibulum at mollis velit. In iaculis tincidunt mi, sit amet aliquet sapien posuere vitae. Proin mollis sem et odio consectetur tempus. Nullam eget facilisis tellus. Donec vestibulum quam at tristique dignissim. Nam ultricies tellus at eros mattis, consequat ornare turpis sodales. Praesent pulvinar egestas diam vitae tincidunt. Aliquam vehicula, arcu vel gravida porta, ex arcu interdum nisl, at aliquet turpis tortor in nulla. Vivamus maximus, mauris a tristique porttitor, erat urna feugiat urna, vel maximus sapien urna semper arcu. Vestibulum sed mauris enim.
        Donec venenatis eget turpis sit amet posuere. Aliquam eu est sit amet sem ullamcorper faucibus. Nam lacinia egestas nisi quis faucibus. Nullam consequat metus eget justo mollis congue. Morbi finibus quis lectus sit amet lobortis. In vel felis viverra, convallis diam nec, malesuada ipsum. Morbi at euismod sapien. Pellentesque rhoncus porttitor dui a pulvinar.
        Nullam eget turpis posuere, egestas dui eget, ultricies odio. Vestibulum ac risus est. Phasellus in risus aliquam, consectetur lorem a, commodo leo. Curabitur at semper tellus. Proin efficitur vehicula nisi, ac venenatis tortor blandit cursus. In tortor purus, vehicula id justo ac, dignissim porttitor mi. Nunc quis tellus a felis vehicula consequat. Etiam at ligula interdum, auctor enim ut, aliquet neque. Phasellus vestibulum in libero ac sagittis. Phasellus posuere luctus tempor. Vestibulum porttitor magna eu nisl fermentum laoreet. Proin egestas lectus nec ex viverra cursus.
        Pellentesque sollicitudin leo quis hendrerit tincidunt. Quisque pharetra, lectus non cursus consequat, quam dui molestie mi, id gravida metus mauris non nulla. Nullam eu convallis tellus. Proin in quam arcu. Praesent quam lorem, imperdiet ac vestibulum quis, hendrerit at nibh. Mauris nunc dui, dignissim non justo ut, egestas porta tellus. Mauris id urna mauris. Vivamus rutrum pharetra nibh, non tempus diam consectetur eget. Etiam faucibus finibus vestibulum. Phasellus pretium convallis tortor, consequat malesuada nunc mollis non. Integer volutpat ultrices tincidunt.
        Duis sed metus quis quam elementum iaculis. Aliquam pulvinar magna nec tellus porta iaculis. Donec tincidunt posuere cursus. Aenean a arcu maximus, luctus justo elementum, lacinia nulla. Fusce viverra felis sed lacinia consectetur. Aenean finibus ut mi euismod pharetra. Maecenas urna lacus, dignissim quis sem malesuada, egestas molestie neque. Vestibulum venenatis leo eu efficitur consequat.
    </p>

    <div class="information">
        <form action="article.php">
        <p>View:55</p>
        <p>Topic:Programming</p>
        <p>Date:04/08/2023</p>
        <p>Writer:Baki Almacı</p>
        <p>Comment:23</p>
        <p>Like:33</p>
            <button  name="btn" type="submit"  value="Contact" > READ MORE </button>
        </form>
    </div>
</div>

    <?php } ?>


<div class="footer">
    <p> Copyleft - Muhammed Baki Almacı Product</p>


</div>

</body>
</html>
