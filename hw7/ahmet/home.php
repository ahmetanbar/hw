<!DOCTYPE html>
<html>
<head>
  <title>Code Note</title>
  <link rel="stylesheet" type="text/css" href="./deneme.css">
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>
  <div class="main">
      <div class="header">
        <h1>Code Note</h1>
      </div>
      <div class="topnav">
        <a href="#">Home</a>
        <a href="#">Archive</a>
        <a href="https://google.com">About</a>
        <a style="float:right;" href="#">Sign Up</a>
        <a style="float:right;" href="#">Log In</a>
      </div>
      <br>
      <div class="content">
        <?php $number_box=5;
        for($i=0; $i<=$number_box ;$i++)
        { ?>
          <div class="articlebox">
            <h2>Code Day</h2>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas sit amet pretium urna. Vivamus venenatis velit nec neque ultricies, eget elementum magna tristique. Quisque vehicula, risus eget aliquam placerat, purus leo tincidunt eros, eget luctus quam orci in velit. Praesent scelerisque tortor sed accumsan convallis.
            <a href="https://google.com">More▷</a></p>
            <div class="info">
            </div>
          </div>
          <?php } ?>
        <br>
      </div>
      <footer>Copyright &copy; BAK Software</footer>
  </div>
</body>
</html>
