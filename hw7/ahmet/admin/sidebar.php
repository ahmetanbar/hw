<?php
$split=explode("/",$_SERVER["SCRIPT_NAME"]);
$whereami=$split[count($split)-1];
?>

<ul>
  <li><a <?php echo($whereami=="panel.php") ? 'class="active"':'href="./panel.php"' ?>>Home</a></li>
  <li><a <?php echo($whereami=="add-art.php") ? 'class="active"':'href="./add-art.php"' ?> >Add article</a></li>
  <li><a <?php echo($whereami=="articles.php" or $whereami=="editarticle.php") ? 'class="active"':'href="./articles.php"' ?> >Articles</a></li>
  <li><a <?php echo($whereami=="members.php") ? 'class="active"':'href="./members.php"' ?> >Members</a></li>
  <li><a <?php echo($whereami=="comments.php") ? 'class="active"':'href="./comments.php"' ?> >Comments</a></li>
  <li><a <?php echo($whereami=="auth.php") ? 'class="active"':'href="./auth.php"' ?> >Authority</a></li>
  <li><a href="../logout.php">Log Out</a></li>
  <li><a href="../home.php">&#8592back</a></li>
</ul>
