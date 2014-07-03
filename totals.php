<?php
//db connection variables
  require_once 'db_config.php';
  //connecting to db
  $mysqli = new mysqli(DB_SERVER, DB_USER, DB_PASSWORD, DB_DATABASE, DB_PORT);
  //check db connection
  if ($mysqli->connect_errno) {
      echo "Connection Failed: " . $mysqli->connect_error;
      die();
  }

?>
<!doctype html>
<html lang="en">
<head>
<title>OPMC Fruit Sale App</title>
<?php require_once "page_defs.php";
      echo $head; ?>
</head>
<body>
<?php echo getHeaderNav("totals"); ?>

<h2>This is the summary of all orders entered.</h2>
<p>Current year:</p>
<p># of students:</p>
<h3>Totals</h3>
  <!-- build this next part by looping through the order type array-->
<table>

</table>

<?php echo $footer; ?>
</body>
</html>
