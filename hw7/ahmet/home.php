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
        <a style="float:right;" href="signup.php">Sign Up</a>
        <a style="float:right;" href="#">Log In</a>
      </div>
      <br>
        <?php $number_box=5;
        for($i=0; $i<=$number_box ;$i++) { ?>
          <div class="content">
              <div class="art_head">
                <h3><a href="https://google.com">Code Day</a></h3>
              </div>
              <div class="article"><p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas sit amet pretium urna. Vivamus venenatis velit nec neque Lorem ipsum dolor sit amet,ass consectetur adipiscing elit. Maecenas sit amet pretium urna. Vivamus venenatis velit nec nequeLorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas sit amet pretium urna. Vivamus venenatis velit nec nequeLorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas sit amet pretium urna. Vivamus venenatis velit nec neque ultricies, eget elementum magna tristique. Quisque vehicula, risus eget aliquam placerat, purus leo tincidunt eros, eget luctus quam orci in velit. Praesent scelerisque tortor sed accumsan convallis.
              <a href="https://google.com">More▷</a></p>
            </div>
            <div class="info">
              <i style="float:left;" class="material-icons md-18">date_range</i>
              <a style="float:left;" href="https://google.com">12.01.2017</a>
              <i style="float:left;" class="material-icons md-18" >account_balance</i>
              <a style="float:left;" href="https://google.com">Java</a>

              <i style="float:left;" class="material-icons md-18" >account_circle </i>
              <a style="float:left; " href="https://google.com">Ahmet Anbar</a>
              <a style="float:right;" href="https://google.com" >Viewing:5</a>
              <i style="float:right;" class="material-icons md-18">assessment</i>
              <a style="float:right;" href="https://google.com">Comments:7</a>
              <i style="float:right;" class="material-icons md-18">comment</i>
              <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
            </div>
          </div>
            <br>
          <?php } ?>
        <br>

      <footer>Copyleft &copy;</footer>
  </div>
</body>
</html>
