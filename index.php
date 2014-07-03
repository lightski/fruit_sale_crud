<?php

  // enable PHP ridiculous error reporting
  error_reporting(-1);
  ini_set('display_errors', 'On');

  /*
   * first define the array of all fruit items
   * key = mysql table name, value = full name for frontend label purposes
   */
  $fruit_items = array("naval_orang_full" =>"Naval Oranges Full Box",
                       "naval_orang_half" => "Naval Oranges Half Box",
                       "red_grape_full" => "Red Grapefruit Full Box",
                       "red_grape_half" => "Red Grapefruit Half Box",
                       "grann_smith_full" => "Granny Smith Full Box",
                       "grann_smith_half" => "Granny Smith Half Box",
                       "red_delic_full" => "Red Delicious Full Box",
                       "red_delic_half" => "Red Delicious Half Box",
                       "golde_delic_full" => "Golden Delicious Full Box",
                       "golde_delic_half" => "Golden Delicious Half Box",
                       "braeb_full" => "Braeburn Full Box",
                       "braeb_half" => "Braeburn Half Box",
                       "danjo_pears_full" => "D'Anjou Full Box",
                       "danjo_pears_half" => "D'Anjou Half Box",
                       "mixed_a" => "Mixed Box A", "mixed_b" => "Mixed Box B",
                       "mixed_c" => "Mixed Box C", "mixed_d" => "Mixed Box D",
                       "gift_l1" => "Gift Box L", "gift_s" => "Gift Box S",
                       "gift_lp" => "Gift Box LP", "gitf_sp" => "Gift Box SP",
                       "pinea" => "Pineapple");
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
