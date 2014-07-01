<?php

  // enable PHP ridiculous error reporting
  error_reporting(-1);
  ini_set('display_errors', 'On');

  /*
   * first define the array of all fruit items
   */
  $fruit_items = array("naval_orange_full", "naval_orange_half",
                  "red_gra_full", "red_gra_half",
                  "granny_smith_full", "granny_smith_half",
                  "red_deli_full", "red_deli_half",
                  "golde_deli_full", "golden_deli_half",
                  "braeb_full", "braeb_half",
                  "pears_full", "pears_half",
                  "mixed_a", "mixed_b", "mixed_c", "mixed_d",
                  "gift_l", "gift_s", "gift_lp", "gitf_sp",
                 "pineapple");
?>


<!DOCTYPE html>
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
  <input type="text" name="fname" placeholder="first name"><br>
  <input type="text" name="lname" placeholder="last name"><br><br>

  <?php

    foreach ($fruit_items as $item) {
      echo "<label>$item</label> <input type=\"number\" name=\"variable_here\" size=\"2\" placeholder=\"0\"><br>";
    }

  ?>
  <input type="submit" value="Submit" id="submit_buton">
</form>

<?php echo $footer; ?>
</body>
</html>
