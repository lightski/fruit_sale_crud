<?php

  // enable PHP ridiculous error reporting
  error_reporting(-1);
  ini_set('display_errors', 'On');

?>


<!doctype html>
<html lang="en">
<head>
<title>OPMC Fruit Sale App</title>
<?php require_once "page_defs.php";
      echo $head; ?>
</head>
<body>
<?php echo getHeaderNav("index"); ?>

<h2>This is the form to enter stuff:</h2>
<form action="process.php" method="post">
  <input type="text" name="fname" placeholder="first name" autofocus><br>
  <input type="text" name="lname" placeholder="last name"><br><br>

  <?php
	$counter = 1;
	// $fruit_items is from page_defs.php
    foreach ($fruit_items as $shortname => $fullname) {
      // create an input for each type of fruit.
      echo "<label>$fullname</label> <input type=\"number\" name=\"$shortname\" placeholder=\"0\" min=\"0\" max=\"999\">";
      if ($counter % 4 == 0) {
        echo "<br><br>";
      }
      $counter++;
    }
  ?>

  <br>
  <input type="submit" value="Submit" id="submit_buton">
</form>

<?php echo $footer; ?>
</body>
</html>
